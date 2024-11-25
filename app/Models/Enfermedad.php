<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfermedad extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'turnos_para_curarse', 'infeccion_a_colindates' ,'partida_id'];

    public function partida(){
        return $this->belongsTo(Partida::class);
    }

    public function scopeByPartida($query, $partidaId){
    return $query->where('partida_id', $partidaId);
    }

}
