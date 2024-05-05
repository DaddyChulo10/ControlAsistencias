<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\TenantModel;

class FaltasRetardos extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'faltas_retardos';
    protected $fillable = ['alumno_id', 'asistencia', 'retardo', 'fecha', 'hora'];

    public function getAlumno()
    {
        return $this->hasOne('App\Models\Admin\Alumnos', 'id', 'alumno_id');
    }



}