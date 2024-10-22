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
        // Valida a entrada
        $request->validate([
            'search' => 'required|string',
        ]);

        // Busca servidores pelo nome (ajustar conforme seu banco de dados)
        $servidores = Servidor::where('nome', 'like', '%' . $request->search . '%')
            ->select('nome', 'pis')
            ->get();

        // Retorna a resposta em JSON
        return response()->json(['usuario' => $servidores]);
    }
}
