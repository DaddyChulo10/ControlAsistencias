<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\TenantModel;

class CicloEscolar extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'ciclo_escolar';
    protected $fillable = ['ciclo'];




}