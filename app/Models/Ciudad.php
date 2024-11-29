<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    protected $table = "ciudad";
    protected $fillable = ['name', 'partida_id', 'centro_investigacion', 'coordenadasX', 'coordenadasY', 'eVerde', 'eRoja', 'eAmarilla', 'eAzul'];
    
    public function personajes(){
        return $this->hasMany(Personaje::class);
    }
    public function partida(){
        return $this->belongsTo(Partida::class);
    }

    public function ciudadColindante(){
        return $this->hasMany(CiudadColindante::class);
    }
}