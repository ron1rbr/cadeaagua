<?php

namespace App\Services;

use App\Models\Consolidacao;
use App\Models\Rua;

class TimelineRuaService
{
    public function gerar(Rua $rua, int $dias = 7): array
    {
        $inicio = now()->subDays($dias)->startOfDay();
        $fim = now();

        $consolidacoes = Consolidacao::where('rua_id', $rua->id)
            ->where('data_consolidacao', '>=', $inicio)
            ->orderBy('data_consolidacao')
            ->get();

        $timeline = $this->montarTimeline($consolidacoes, $fim);

        return [
            'timeline' => $timeline,
            'inicio' => $inicio,
            'fim' => $fim
        ];
    }

    protected function montarTimeline($consolidacoes, $fim): array
    {
        if ($consolidacoes->isEmpty()) {
            return [];
        }

        $eventos = [];

        foreach ($consolidacoes as $i => $c) {
            $inicioEvento = $c->data_consolidacao;
            $fimEvento = $consolidacoes[$i + 1]->data_consolidacao ?? $fim;

            $duracaoEvento = $inicioEvento->diffInSeconds($fimEvento);

            $eventos[] = [
                'tipo' => $c->tipo_evento == 'chegou'
                    ? 'chegou'
                    : 'acabou',
                'inicio' => $inicioEvento,
                'fim' => $fimEvento,
                'inicio_formatado' => $inicioEvento->format('d/M H:i'),
                'fim_formatado' => $fimEvento->format('d/M H:i'),
                'duracao' => $duracaoEvento,
                'label' => $this->formatarDuracaoEvento($duracaoEvento)
            ];
        }

        return $eventos;
    }

    protected function formatarDuracaoEvento(int $duracaoEvento): string
    {
        if ($duracaoEvento < 3600) {
            return floor($duracaoEvento / 60) . 'm';
        }

        if ($duracaoEvento < 86400) {
            $h = floor($duracaoEvento / 3600);
            $m = floor(($duracaoEvento % 3600) / 60);

            return "{$h}h {$m}m";
        }

        $d = floor($duracaoEvento / 86400);
        $h = floor(($duracaoEvento % 86400) / 3600);

        return "{$d}d {$h}h";
    }
}