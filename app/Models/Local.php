<?php
// app/Models/Local.php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locais';

    protected $fillable = [
        'bairro',
        'rua',
        'latitude',
        'longitude',
    ];

    /**
     * Scope responsável apenas por calcular e ordenar pela distância (EM METROS).
     */
    public function scopeOrderByDistance(
        Builder $query,
        float $latitude,
        float $longitude
    ): Builder {
        return $query
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('*')
            ->selectRaw(
                '((6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )) * 1000) AS distancia',
                [$latitude, $longitude, $latitude]
            )
            ->orderBy('distancia');
    }
}
