<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroAbastecimento extends Model
{
    protected $table = 'registros_abastecimento';

    protected $fillable = [
        'user_id',
        'rua_id',
        'tipo_evento',
        'data_evento',
        'nota'
    ];

    protected $casts = [
        'data_evento' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rua()
    {
        return $this->belongsTo(Rua::class);
    }
}
