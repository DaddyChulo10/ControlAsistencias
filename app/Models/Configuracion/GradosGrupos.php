<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\TenantModel;

class GradosGrupos extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'grados_grupos';
    protected $fillable = ['grado_grupo', 'ciclo_escolar_id'];

    public function getcicloEscolar()
    {
        return $this->hasOne('App\Models\Configuracion\CicloEscolar', 'id', 'ciclo_escolar_id');
    }



}