<?php

namespace App\Http\Controllers;

use App\Services\RegistroAbastecimentoService;
use App\Models\Rua;
use App\Models\RegistroAbastecimento;
use App\Exceptions\RegistroAbastecimentoException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroAbastecimentoController extends Controller
{
    public function index(Request $request)
    {
        $registros = RegistroAbastecimento::with('rua')
            ->when($request->rua_id, function ($query) use ($request) {
                $query->where('rua_id', $request->rua_id);
            })
            ->when($request->tipo_evento, function ($query) use ($request) {
                $query->where('tipo_evento', $request->tipo_evento);
            })
            ->when($request->data_inicio, function ($query) use ($request) {
                $query->whereDate('data_evento', '>=', $request->data_inicio);
            })
            ->when($request->data_fim, function ($query) use ($request) {
                $query->whereDate('data_evento', '<=', $request->data_fim);
            })
            ->where('user_id', Auth::id())
            ->orderByRaw('DATE(data_evento) desc')
            ->paginate(20)
            ->onEachSide(1);
        
        $ruaSelecionada = null;

        if ($request->rua_id) {
            $ruaSelecionada = Rua::select('id', 'nome')->find($request->rua_id);
        }

        return view('registros.index', compact('registros', 'ruaSelecionada'));
    }

    public function create()
    {
        return view('registros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rua_id' => 'required|exists:ruas,id',
            'tipo_evento' => 'required|in:chegou,acabou',
            'nota' => 'nullable|string|max:255'
        ]);

        try {
            $service = new RegistroAbastecimentoService();

            $resultado = $service->criarRegistro(
                Auth::id(),
                $request->rua_id,
                $request->tipo_evento,
                $request->nota
            );

            return redirect()
                ->route('registros.index')
                ->with('success', 'Registro enviado e processado com sucesso!');
        } catch (RegistroAbastecimentoException $e) {
            return back()->withErrors(['business' => $e->getMessage()]);
        }
    }

    public function storeRapido(Request $request, string $tipoEvento)
    {
        $request->validate([
            'rua_id' => 'required|exists:ruas,id'
        ]);

        try {
            $service = new RegistroAbastecimentoService();

            $resultado = $service->criarRegistro(Auth::id(), $request->rua_id, $tipoEvento);

            return redirect()
                ->route('registros.index')
                ->with('success', 'Registro enviado e processado com sucesso!');
        } catch (RegistroAbastecimentoException $e) {
            return back()->withErrors(['business' => $e->getMessage()]);
        }
    }

    public function historico(Request $request)
    {
        $registros = RegistroAbastecimento::with('rua')
            ->when($request->rua_id, function ($query) use ($request) {
                $query->where('rua_id', $request->rua_id);
            })
            ->when($request->tipo_evento, function ($query) use ($request) {
                $query->where('tipo_evento', $request->tipo_evento);
            })
            ->when($request->data_inicio, function ($query) use ($request) {
                $query->whereDate('data_evento', '>=', $request->data_inicio);
            })
            ->when($request->data_fim, function ($query) use ($request) {
                $query->whereDate('data_evento', '<=', $request->data_fim);
            })
            ->orderByRaw('DATE(data_evento) desc')
            ->paginate(20)
            ->onEachSide(1);

        $ruaSelecionada = null;

        if ($request->rua_id) {
            $ruaSelecionada = Rua::select('id', 'nome')->find($request->rua_id);
        }

        return view('registros.historico', compact('registros', 'ruaSelecionada'));
    }
}
