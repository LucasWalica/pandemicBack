<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnfermedadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "turnosParaCurar" => $this->turnos_para_curarse,
            "infeccionAColindandes" => $this->infeccion_a_colindantes,
        ];
    }
}
