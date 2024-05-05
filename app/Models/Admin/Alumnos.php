<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\TenantModel;

class Alumnos extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'alumnos';
    protected $fillable = ['codigo', 'grado_grupo_id', 'nombre_apellido'];

    public function getGradoGrupo()
    {
        return $this->hasOne('App\Models\Configuracion\GradosGrupos', 'id', 'grado_grupo_id');
    }



}