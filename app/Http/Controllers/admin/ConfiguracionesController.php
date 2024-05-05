<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuracion\CicloEscolar;
use App\Models\Configuracion\GradosGrupos;
use Illuminate\Http\Request;
class ConfiguracionesController extends Controller
{
    public function index()
    {
        $title = 'Configuraciónes';
        $ciclo = CicloEscolar::get();
        $grados_grupos = GradosGrupos::get();

        return view('admin.configuraciones.index', compact('title', 'ciclo', 'grados_grupos'));
    }

    public function storeCiclo(Request $request)
    {
        // dd('aaa');
        CicloEscolar::create([
            'ciclo' => $request->ciclo,
        ]);

        return redirect()->route('configuraciones.index');
    }

    public function deleteCiclo()
    {
        // dd('entro');
        $id = $_GET['id'];
        CicloEscolar::find($id)->delete();
    }

    public function storegrado_grupo(Request $request)
    {
        // return $request->all();
        GradosGrupos::create([
            'grado_grupo' => $request->grados_grupos,
            'ciclo_escolar_id' => $request->ciclo_id, 
            // 'created_at' => date('Y-m-d H:i:s'),
            // 'updated_at' => date('Y-m-d H:i:s'),
            // // 'created_at' => 
            // 'deleted_at' => '2022-06-06 12:00:00',
        ]);
        return redirect()->route('configuraciones.index');

    }

    public function deletegrado_grupo()
    {
        $id = $_GET['id'];
        GradosGrupos::find($id)->delete();
    }
}
