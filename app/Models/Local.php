<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $fillable = [
        'bairro',
        'rua',
        'latitude',
        'logitude'
    ];

    public function registros()
    {
        return $this->hasMany(RegistroAbastecimento::class);
    }
}
