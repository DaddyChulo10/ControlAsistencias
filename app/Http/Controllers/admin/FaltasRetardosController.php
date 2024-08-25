<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Alumnos;
use App\Models\Configuracion\GradosGrupos;
use Illuminate\Http\Request;
use App\Models\Admin\FaltasRetardos;
use App\Models\Configuracion\Reglas;


class FaltasRetardosController extends Controller
{
    public function index()
    {
        $title = 'Faltas y Retardos';
        // $alumnos = Alumnos::get();
        // $grados_grupos = GradosGrupos::get();
        return view('admin.faltas_retardos.index', compact('title'));
    }

    public function registrar()
    {
        date_default_timezone_set('America/Mexico_City');
        $codigo = $_GET['codigoAlumno'];
        $valores = $_GET['valores'];
        $fecha = date('Y-m-d');
        $hora = date('h:i:s');
        $NuevaHora = strtotime('-1 hour', strtotime($hora));
        $alumno = Alumnos::where('codigo', $codigo)->first();

        $arrayReglas = [];

        if ($valores['reglas'] != 'false') {
            foreach ($valores['reglas'] as $key => $item) {
                array_push($arrayReglas, $item['id']);
            }
        }


        FaltasRetardos::create([
            'alumno_id' => $alumno->id,
            'asistencia' => $valores['asistencia'] == 'true' ? true : false,
            'retardo' => $valores['retardo'] == 'true' ? true : false,
            'reglas' => $valores['reglas'] != 'false' ? json_encode($arrayReglas) : null,
            'fecha' => $fecha,
            'hora' => date('h:i:s', $NuevaHora),
        ]);
        // return $alumno;
    }


    public function cargarRegistros()
    {
        $faltas_retardos = FaltasRetardos::orderBy('id', 'desc')->get();
        foreach ($faltas_retardos as $key => $item) {
            $item['nombre_apellido'] = $item->getAlumno->nombre_apellido ?? 'Alumno eliminado';
        }
        return $faltas_retardos;
    }


    public function validarCodigoQr()
    {
        $response = [];
        $codigo = $_GET['codigo'];
        $alumno = Alumnos::where('codigo', $codigo)->first();
        $reglas = Reglas::where('sexo', $alumno->sexo)->get();
        $grado = $alumno->getGradoGrupo->grado_grupo ?? 'Grado y grupo eliminado';
        $response['alumno'] = $alumno;
        $response['reglas'] = $reglas;
        $response['grado'] = $grado;

        return $response;
        // return $alumno;

    }
}
