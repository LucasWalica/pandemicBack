<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;
    protected $table = "partida";
    protected $fillable = ['turno', 'user_id'];

    public function ciudades(){
        return $this->hasMany(Ciudad::class);
    }
    public function ciudadColindante(){
        return $this->hasMany(CiudadColindante::class);
    }
    public function enfermedades(){
        return $this->hasMany(Enfermedad::class);
    }
    public function personajes(){
        return $this->hasMany(Personaje::class);
    }

    public function scopeByUser($query, $user_id){
        return $query->where('user_id', $user_id);
    }


}
