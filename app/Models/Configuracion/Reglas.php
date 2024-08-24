<?php

namespace App\Models\Configuracion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\TenantModel;

class Reglas extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'reglas';
    protected $fillable = ['reglas', 'sexo'];
}