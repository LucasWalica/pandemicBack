<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonajeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name"=> $this->name,
            "specialSkill"=>$this->specialSKill,
            // specialSkill
            "movido"=> $this->movido,
            "ciudadEnLaQueEsta" => $this->ciudad,
            "turno_comienzo"=> $this->turno_comienzo,
            "en_accion"=> $this->en_accion,
        ];
    }
}

