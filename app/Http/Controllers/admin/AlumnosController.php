<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AlumnosController extends Controller
{
    public function index()
    {
        $title = 'Lista de alumnos';
        return view('admin.alumnos.index', compact('title'));
    }
}
