<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuracion\CicloEscolar;
use App\Models\Configuracion\GradosGrupos;
use App\Models\Configuracion\Reglas;

use Illuminate\Http\Request;

class ConfiguracionesController extends Controller
{
    public function index()
    {
        $title = 'Configuraciónes';
        $ciclo = CicloEscolar::get();
        $grados_grupos = GradosGrupos::get();
        $reglas = Reglas::get();

        return view('admin.configuraciones.index', compact('title', 'ciclo', 'grados_grupos', 'reglas'));
    }

    public function storeCiclo(Request $request)
    {
        CicloEscolar::create([
            'ciclo' => $request->ciclo,
        ]);

        return redirect()->route('configuraciones.index');
    }

    public function deleteCiclo()
    {
        $id = $_GET['id'];
        CicloEscolar::find($id)->delete();
    }

    public function storegrado_grupo(Request $request)
    {
        GradosGrupos::create([
            'grado_grupo' => $request->grados_grupos,
            'ciclo_escolar_id' => $request->ciclo_id,
        ]);
        return redirect()->route('configuraciones.index');
    }

    public function deletegrado_grupo()
    {
        $id = $_GET['id'];
        GradosGrupos::find($id)->delete();
    }

    public function storeReglas(Request $request)
    {
        Reglas::create([
            'reglas' => $request->reglas,
            'sexo' => $request->sexo
        ]);
        return redirect()->route('configuraciones.index');
    }

    public function deleteReglas()
    {
        $id = $_GET['id'];
        Reglas::find($id)->delete();
    }
}
