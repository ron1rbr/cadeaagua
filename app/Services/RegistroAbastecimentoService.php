<?php

namespace App\Services;

use App\Models\RegistroAbastecimento;
use App\Models\Consolidacao;
use App\Models\User;
use App\Exceptions\RegistroAbastecimentoException;

class RegistroAbastecimentoService
{
    /**
    * Cria um registro e tenta consolidar.
    */
    public function criarRegistro($userId, $ruaId, $tipoEvento, $nota = null)
    {
        // Anti-span: verifica último registro
        $ultimoRegistro = RegistroAbastecimento::where('user_id', $userId)
            ->where('rua_id', $ruaId)
            ->latest('data_evento')
            ->first();


        if ($ultimoRegistro) {
            if ($ultimoRegistro->tipo_evento == $tipoEvento) {
                throw new RegistroAbastecimentoException(
                    'Você já registrou o mesmo evento para esta rua.'
                );
            }

            if ($ultimoRegistro->data_evento->gt(now()->subHours(24))) {
                throw new RegistroAbastecimentoException(
                    'Aguarde antes de enviar outro registro para esta rua.'
                );
            }
        }

        // Cria registro
        $registro = RegistroAbastecimento::create([
            'user_id' => $userId,
            'rua_id' => $ruaId,
            'tipo_evento' => $tipoEvento,
            'data_evento' => now(),
            'nota' => $nota ?: 'Registro rápido.'
        ]);

        // Consolida eventos
        $this->consolidarRua($ruaId);

        return ['success' => true, 'registro' => $registro];
    }

    /**
    * Consolida eventos de uma rua ponderando pela confiança dos usuários
    */
    protected function consolidarRua($ruaId)
    {
        $ultimaConsolidacao = Consolidacao::where('rua_id', $ruaId)
            ->latest('data_consolidacao')
            ->first();

        $registros = RegistroAbastecimento::with('usuario')
            ->where('rua_id', $ruaId)
            ->when($ultimaConsolidacao, function ($query) use ($ultimaConsolidacao) {
                $query->where('data_evento', '>', $ultimaConsolidacao->data_consolidacao);
            })
            ->get();

        if ($registros->isEmpty()) return;

        $pesos = ['chegou' => 0, 'acabou' => 0];

        $pesoTotalUsuarios = 0;

        foreach ($registros as $registro) {
            $pesoUsuario = $this->pesoDoUsuario($registro->usuario->trust_level);
            $pesos[$registro->tipo_evento] += $pesoUsuario;
            $pesoTotalUsuarios += $pesoUsuario;
        }

        $limiar = max(
            2, // mínimo absoluto
            ceil($pesoTotalUsuarios * 0.4)
        );

        $usuariosPorEvento = $registros
            ->groupBy('tipo_evento')
            ->map(fn ($items) => $items->pluck('user_id')->unique()->count());

        $tipoEventoConsolidado = null;

        // Verifica se algum tipo de evento atingiu o limiar
        foreach ($pesos as $tipoEvento => $pesoTotal) {
            if (
                $pesoTotal >= $limiar &&
                ($usuariosPorEvento[$tipoEvento] ?? 0) >= 2
            ) {
                $tipoEventoConsolidado = $tipoEvento;
                break;
            }
        }

        if (!$tipoEventoConsolidado) return; // Nada a consolidar

        // Evita duplicar consolidação
        if ($ultimaConsolidacao && $ultimaConsolidacao->tipo_evento == $tipoEventoConsolidado) return;

        // Salva consolidação
        $consolidacao = Consolidacao::create([
            'rua_id' => $ruaId,
            'tipo_evento' => $tipoEventoConsolidado,
            'data_consolidacao' => now()
        ]);

        // Ajusta confiança dos usuários
        $usuariosAcertaram = $registros->filter(fn($registro) => $registro->tipo_evento == $tipoEventoConsolidado)
            ->pluck('user_id')
            ->unique();

        $usuariosErraram = $registros->filter(fn($registro) => $registro->tipo_evento != $tipoEventoConsolidado)
            ->pluck('user_id')
            ->unique();

        User::whereIn('id', $usuariosAcertaram)
            ->where('trust_level', '<', 100)
            ->increment('trust_level');

        User::whereIn('id', $usuariosErraram)
            ->where('trust_level', '>', 0)
            ->decrement('trust_level');
    }

    protected function pesoDoUsuario($trustLevel)
    {
        return match (true) {
            $trustLevel >= 60 => 4,
            $trustLevel >= 30 => 3,
            $trustLevel >= 10 => 2,
            default => 1
        };
    }
}
