<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Previsao extends Model
{
    protected $fillable = [
        'local_id',
        'proxima_agua_chega',
        'proxima_agua_acaba',
        'confianca',
        'dados_base'
    ];

    protected $casts = [
        'proxima_agua_chega' => 'datetime',
        'proxima_agua_acaba' => 'datetime',
        'dados_base' => 'array'
    ];

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
