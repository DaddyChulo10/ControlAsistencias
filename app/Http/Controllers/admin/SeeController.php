<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SeeController extends Controller
{


    public function index()
    {

        return view('admin.index');
    }


}
