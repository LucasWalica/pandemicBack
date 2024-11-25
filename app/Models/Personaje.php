<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personaje extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'partida_id', 'movido', 'ciudad_id', 'turno_comienzo', 'en_accion'];

    public function ciudad(){
        return $this->belongsTo(Ciudad::class);
    }
    // testear si al ser movido cambia de ciudad etc
}
