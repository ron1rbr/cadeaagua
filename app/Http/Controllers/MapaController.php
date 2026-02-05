<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MapaController extends Controller
{
    public function index()
    {
        return view('mapa.index');
    }

    public function ruasGeoJson()
    {
        $ruas = DB::select("
            SELECT
                r.id,
                r.nome,
                c.tipo_evento,
                c.data_consolidacao,
                ST_AsGeoJSON(r.geom) AS geom
            FROM ruas r
            LEFT JOIN LATERAL (
                SELECT tipo_evento, data_consolidacao
                FROM consolidacoes
                WHERE rua_id = r.id
                ORDER BY data_consolidacao DESC
                LIMIT 1
            ) c ON true
        ");

        $features = [];

        foreach ($ruas as $rua) {
            if (!$rua->geom) {
                continue;
            }

            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($rua->geom),
                'properties' => [
                    'nome' => $rua->nome,
                    'tipo_evento' => $rua->tipo_evento,
                    'data_consolidacao' => $rua->data_consolidacao,
                    'data_consolidacao_formatada' => $rua->data_consolidacao
                        ? Carbon::parse($rua->data_consolidacao)->format('d/m/Y H:i')
                        : null
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }
}
