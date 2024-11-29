<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CiudadColindante extends Model
{
    use HasFactory;
    protected $table = "ciudad_colindante";
    protected $fillable = ['name', 'partida_id', 'ciudad_id' ];
    public function partida(){
        return $this->belongsTo(Partida::class);
    }
    public function ciudad(){
        return $this->belongsTo(Ciudad::class);
    }
}
