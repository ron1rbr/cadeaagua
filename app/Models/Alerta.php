<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $fillable = [
        'user_id',
        'local_id',
        'tipo_alerta',
        'canal',
        'ativo'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
