<?php 
namespace App\Http\Controllers;

use App\Models\Partida;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }
            // Validar el request
            $validated = $request->validate([
                'counterTurnos' => 'required|integer',
                'jugadas' => 'required|integer',
                'listCiudades' => 'required|array',
                'listEnfermedades' => 'required|array',
                'listaPersonajes' => 'required|array',
            ]);

            // Crear la partida
            $partida = Partida::create([
                'counterTurnos' => $validated['counterTurnos'], 
                'jugadas' => $validated['jugadas'],
                'user_id' => $user->id
            ]);

            // Crear las ciudades
            foreach ($validated['listCiudades'] as $ciudadData) {
                $ciudad = $partida->ciudades()->create([
                    'name' => $ciudadData['nombre'],
                    'partida_id'=> $partida->id,
                    'centro_investigacion' => $ciudadData['centroInvestigacion'],
                    'coordenadasX' => $ciudadData['coordenadasX'],
                    'coordenadasY' => $ciudadData['coordenadasY'],
                    'eAmarillo' => $ciudadData['eAmarillo'],
                    'eAzul' => $ciudadData['eAzul'],
                    'eRojo' => $ciudadData['eRojo'],
                    'eVerde' => $ciudadData['eVerde'],
                ]);

                foreach ($ciudadData['listPersonajes'] as $personajeData) {
                    $ciudad->personajes()->create([
                        'name' => $personajeData['name'],
                        'partida_id'=>$partida->id,
                        'movido' => $personajeData['movido'],
                        'ciudad_id'=>$ciudad->id,
                        'en_accion' => $personajeData['en_accion'],
                        'turno_comienzo' => $personajeData['turno_comienzo'],
                    ]);
                }
            }

            // Crear las enfermedades
            foreach ($validated['listEnfermedades'] as $enfermedadData) {
                $partida->enfermedades()->create([
                    'name' => $enfermedadData['name'],
                    'turnos_para_curarse' => $enfermedadData['turnosParaCurar'],
                    'infeccion_a_colindandes' => $enfermedadData['infeccionAColindandes'],
                    'partida_id'=>$partida->id
                ]);
            }

            DB::commit();
            return response()->json($partida, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    

    // Obtener una partida con sus ciudades y enfermedades
    public function show($id)
    {
        $partida = Partida::with(['ciudades', 'ciudades.personajes', 'enfermedades'])->findOrFail($id);
        return response()->json($partida);
    }
}