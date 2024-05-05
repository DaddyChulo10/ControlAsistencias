<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Alumnos;
use App\Models\Configuracion\GradosGrupos;
use Illuminate\Http\Request;



class FaltasRetardosController extends Controller
{
    public function index()
    {
        $title = 'Faltas y Retardos';
        // $alumnos = Alumnos::get();
        // $grados_grupos = GradosGrupos::get();
        return view('admin.faltas_retardos.index', compact('title'));
    }

   
}
