<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Alumnos;
use App\Models\Configuracion\GradosGrupos;
use Illuminate\Http\Request;
use App\Models\Admin\FaltasRetardos;


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
        $codigo = $_GET['codigo'];
        $asistencia = $_GET['asistencia'];
        $retardo = $_GET['retardo'];
        $fecha = date('Y-m-d');
        $hora = date('h:i:s');

        $NuevaHora = strtotime ( '-1 hour' , strtotime ($hora) ) ;
        // $hora 

        
        $alumno = Alumnos::where('codigo', $codigo)->first();

       

        FaltasRetardos::create([
            'alumno_id' => $alumno->id,
            'asistencia' => $asistencia == 'true' ? true : false,
            'retardo' => $retardo == 'true' ? true : false,
            'fecha' => $fecha,
            'hora' => date('h:i:s', $NuevaHora),
        ]);
        // return $alumno;
    }


    public function cargarRegistros() 
    {
        $array = [];
        $faltas_retardos = FaltasRetardos::get();
        foreach($faltas_retardos as $key => $item){
            $item['nombre_apellido'] = $item->getAlumno->nombre_apellido ?? 'Alumno eliminado';

        }
        return $faltas_retardos;
    }

   
}
