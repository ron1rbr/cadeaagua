<?php

namespace App\Http\Controllers;

use App\Models\Rua;
use App\Services\TimelineRuaService;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request, TimelineRuaService $service)
    {
        $ruaSelecionada = null;
        $timeline = [];
        $inicio = null;
        $fim = null;

        if ($request->filled('rua_id')) {
            $ruaSelecionada = Rua::select('id', 'nome')->findOrFail($request->rua_id);

            $resultado = $service->gerar($ruaSelecionada);

            $timeline = $resultado['timeline'];
            $inicio = $resultado['inicio'];
            $fim = $resultado['fim'];
        }

        return view('ruas.timeline', compact(
            'ruaSelecionada',
            'timeline',
            'inicio',
            'fim'
        ));
    }
}
