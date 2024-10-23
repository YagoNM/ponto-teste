<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function menu()
    {
        return view('menu');
    }

    public function getServidor(Request $request)
    {
        try {
            // Valida a entrada
            $request->validate([
                'search' => 'required|string',
            ]);

            // Busca o servidor pelo nome
            $servidor = Servidor::where('nome', 'like', '%' . $request->search . '%')
                ->first();

            if (!$servidor) {
                return response()->json(['error' => 'Usuario não encontrado'], 404);
            }

            // Busca os pontos do servidor usando o PIS
            $pontos = DB::table('ponto_relatorio')
                ->where('pis_id', $servidor->pis)
                ->orderBy('mes', 'asc')
                ->orderBy('dia', 'asc')
                ->orderBy('hora', 'asc')
                ->orderBy('minutos', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return $item->dia . '/' . $item->mes;
                });

            // Retorna os dados em formato JSON
            return response()->json([
                'servidor' => $servidor,
                'pontos' => $pontos,
            ]);
        } catch (\Exception $e) {
            // Logando o erro para depuração
            Log::error('Erro ao buscar servidor: ' . $e->getMessage());

            // Retorna um erro 500 com uma mensagem mais amigável
            return response()->json(['error' => 'Ocorreu um erro no servidor.'], 500);
        }
    }
}
