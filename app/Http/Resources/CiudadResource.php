<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CiudadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'name' => $this->name,
            'listCiudadesColindantes' => CiudadColindateResource::collection($this->ciudadColindante),
            'listPersonajes' =>PersonajeLiteResource::collection($this->personajes),
            'coordenadasX' => $this->coordenadasX,
            'coordenadasY' => $this->coordenadasY,
            'centro_investigacion' => $this->centro_investigacion,
            'eVerde' => $this->eVerde,
            'eRoja' => $this->eRoja,
            'eAmarilla' => $this->eAmarilla,
            'eAzul' => $this->eAzul,
        ];
    }
}
