<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consolidacao extends Model
{
    protected $table = 'consolidacoes';

    protected $fillable = [
        'rua_id',
        'tipo_evento',
        'data_consolidacao'
    ];

    protected $casts = [
        'data_consolidacao' => 'datetime'
    ];
}
