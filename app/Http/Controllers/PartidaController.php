<?php 
namespace App\Http\Controllers;

use App\Models\Partida;
use App\Models\Ciudad;
use App\Models\Enfermedad;
use App\Models\User;
use Illuminate\Http\Request;

class PartidaController extends Controller
{

    public function getPartidasList($userId){
        $user = User::findOrFail($userId);

        $partidas = $user->partidas;

        return response()->json($partidas);
    }
    // Crear una nueva partida con ciudades y enfermedades
    
    public function store(Request $request)
    {
        // Validar el request
        $validated = $request->validate([
            'counterTurnos' => 'required|integer',
            'jugadas' => 'required|integer',
            'listCiudades' => 'required|array',
            'listEnfermedades' => 'required|array',
            'user_id' => 'required|exists:users,id',
        ]);

        // Crear la partida
        $partida = Partida::create([
            'turno' => 0, // El turno inicial
            'user_id' => $validated['user_id']
        ]);

        // Crear las ciudades y asociarlas a la partida
        foreach ($validated['listCiudades'] as $ciudadData) {
            $ciudad = $partida->ciudades()->create([
                'nombre' => $ciudadData['nombre'],
                'centro_investigacion' => $ciudadData['centroInvestigacion'],
                'coordenadasX' => $ciudadData['coordenadasX'],
                'coordenadasY' => $ciudadData['coordenadasY'],
                'eAmarillo' => $ciudadData['eAmarillo'],
                'eAzul' => $ciudadData['eAzul'],
                'eRojo' => $ciudadData['eRojo'],
                'eVerde' => $ciudadData['eVerde'],
            ]);

            // Crear personajes asociados a la ciudad (si hay)
            foreach ($ciudadData['listPersonajes'] as $personajeData) {
                $ciudad->personajes()->create([
                    'name' => $personajeData['name'],
                    'movido' => $personajeData['movido'],
                    'en_accion' => $personajeData['en_accion'],
                    'turno_comienzo' => 0 // Este es un ejemplo, puedes ajustarlo
                ]);
            }
        }

        // Crear las enfermedades y asociarlas a la partida
        foreach ($validated['listEnfermedades'] as $enfermedadData) {
            $partida->enfermedades()->create([
                'name' => $enfermedadData['name'],
                'turnos_para_curarse' => $enfermedadData['turnosParaCurar'],
                'infeccion_a_colindandes' => $enfermedadData['infeccionAColindandes']
            ]);
        }

        // Retornar la respuesta con la partida creada
        return response()->json($partida, 201);
    }

    // Obtener una partida con sus ciudades y enfermedades
    public function show($id)
    {
        $partida = Partida::with(['ciudades', 'ciudades.personajes', 'enfermedades'])->findOrFail($id);
        return response()->json($partida);
    }
}