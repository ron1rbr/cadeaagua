<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RuaResource;
use App\Models\Rua;
use Illuminate\Http\Request;

class RuaController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'q' => 'nullable|string'
        ]);

        $query = Rua::query();

        if ($request->filled('q')) {
            $query->where('nome', 'ilike', "%{$request->q}%");
        }

        if ($request->filled(['lat', 'lng'])) {
            $rua = Rua::maisProxima($request->lat, $request->lng, 50)->first();

            if (!$rua) {
                return response()->json(['message' => 'Nenhuma rua encontrada.'], 404);
            }

            return new RuaResource($rua);
        }

        return RuaResource::collection(
            $query->orderBy('nome')->limit(20)->get()
        );
    }
}
