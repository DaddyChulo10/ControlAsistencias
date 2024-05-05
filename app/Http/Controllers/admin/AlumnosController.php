<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Alumnos;
use App\Models\Configuracion\GradosGrupos;
use Illuminate\Http\Request;



class AlumnosController extends Controller
{
    public function index()
    {
        $title = 'Lista de alumnos';
        $alumnos = Alumnos::get();
        $grados_grupos = GradosGrupos::get();
        return view('admin.alumnos.index', compact('title', 'alumnos', 'grados_grupos'));
    }

    public function store( Request $request )
    {
        Alumnos::create([
            'codigo' => $request->codigo,
            'nombre_apellido' => $request->nombre_apellido,
            'grado_grupo_id' => $request->grado_grupo_id
        ]);

        return back();
    }

    public function delete()
    {
        $id = $_GET['id'];
        Alumnos::find($id)->delete();
    }
}
