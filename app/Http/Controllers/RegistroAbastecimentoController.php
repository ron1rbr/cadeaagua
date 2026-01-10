<?php

namespace App\Http\Controllers;

use App\Models\Rua;
use App\Models\RegistroAbastecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroAbastecimentoController extends Controller
{
    public function index()
    {
        $registros = RegistroAbastecimento::with('rua')
            ->where('user_id', Auth::id())
            ->orderBy('data_evento', 'desc')
            ->paginate(2);

        return view('registros.index', compact('registros'));
    }

    public function create()
    {
        $ruas = Rua::orderBy('nome')->get();
        return view('registros.create', compact('ruas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rua_id' => 'required|exists:ruas,id',
            'tipo_evento' => 'required|in:chegou,acabou',
            'data_evento' => 'required|date',
            'nota' => 'nullable|string|max:255'
        ]);

        RegistroAbastecimento::create([
            'user_id' => Auth::id(),
            'rua_id' => $request->rua_id,
            'tipo_evento' => $request->tipo_evento,
            'data_evento' => $request->data_evento,
            'nota' => $request->nota
        ]);

        return redirect()->route('registros.index')->with('success', 'Registro enviado com sucesso!');
    }

    public function storeRapido(Request $request, string $tipo)
    {
        $request->validate([
            'rua_id' => 'required|exists:ruas,id'
        ]);


        $rua = Rua::find($request->rua_id);

        RegistroAbastecimento::create([
            'user_id' => Auth::id(),
            'rua_id' => $rua->id,
            'tipo_evento' => $tipo,
            'data_evento' => now(),
            'nota' => 'Registro rápido.'
        ]);

        return redirect()
            ->route('registros.index')
            ->with('success', 'Registro rápido enviado com sucesso!');
    }
}
