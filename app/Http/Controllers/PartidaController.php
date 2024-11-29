<?php 
namespace App\Http\Controllers;

use App\Http\Resources\PartidaResource;
use App\Models\Partida;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartidaController extends Controller
{

    public function getPartidasList(Request $request){
        
        try {
            $user = Auth::user();
    
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }
    
            $partidas = $user->partidas;

            // Cargar las partidas con relaciones de ciudades, enfermedades y personajes
            $partidas = $user->partidas()->with(['ciudades', 'enfermedades', 'personajes', 'ciudadColindante'])->get();

           
           return PartidaResource::collection($partidas);
    
        } catch (\Exception $e) {
            // Log el error para inspeccionarlo
            \Log::error('Error en getPartidasList: ' . $e->getMessage());
    
            return response()->json([
                'error' => 'Error al obtener las partidas',
                'details' => $e->getMessage(),
            ], 500);
        }

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
                if (isset($ciudadData['listCiudadesColindantes'])) {
                    foreach ($ciudadData['listCiudadesColindantes'] as $colindante) {
                        // Crear la relación de ciudad colindante
                        $ciudad->ciudadColindante()->create([
                            'name' => $colindante['name'],
                            'partida_id' => $partida->id,
                        ]);
                    }
                }

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
    public function show(Request $request)
    {

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
        $partida = Partida::with(['ciudades', 'ciudades.personajes', 'enfermedades'])->findOrFail($user->id);
        return response()->json($partida);
    }
}