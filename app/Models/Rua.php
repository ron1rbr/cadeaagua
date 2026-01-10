<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Rua extends Model
{
    protected $table = 'ruas';

    /**
     * Retorna a rua mais próxima do ponto do usuário (em metros)
     */
     public function scopeMaisProxima(Builder $query, float $lat, float $lng, int $raio = 50): Builder
     {
         return $query
             ->select('*')
             ->selectRaw(
                 "
                 ST_Distance(
                     geom::geography,
                     ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                 ) AS distancia
                 ",
                 [$lng, $lat]
             )
             ->whereRaw(
                 "
                    ST_DWithin(
                        geom::geography,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                        ?
                    )
                ",
                [$lng, $lat, $raio]
             )
             ->orderBy('distancia');
     }

    public function registros()
    {
        return $this->hasMany(RegistroAbastecimento::class);
    }
}

