<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = ['turno', 'user_id'];

    public function ciudades(){
        return $this->hasMany(Ciudad::class);
    }

    public function partida(){
        return $this->belongsTo(Partida::class);
    }

    public function scopeByUser($query, $user_id){
        return $query->where('user_id', $user_id);
    }


}
