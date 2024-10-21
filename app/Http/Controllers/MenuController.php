<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function menu() 
    {
        return view('menu');
    }

    public function getServidor(Request $request)
    {
        return response()->json(['message' => 'API funcionando corretamente']);
    }
}
