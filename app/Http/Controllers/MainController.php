<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function main()
    {
        return view('index');
    }

    public function handleUpload(Request $request)
    {
        // Validar se o arquivo foi enviado
        $request->validate([
            'ponto_file' => 'required|file|mimes:txt',
        ]);

        // Armazenar o arquivo
        $filePath = $request->file('ponto_file')->store('ponto_relatorios');

        // Processar o arquivo
        $this->processFile(storage_path('app/private/' . $filePath));

        return back()->with('success', 'Arquivo processado com sucesso!');
    }

    private function processFile($filePath)
    {
        if (file_exists($filePath)) {
            $file = fopen($filePath, 'r');
            if ($file) {
                // Define o padrão para 36 dígitos seguidos de 2 caracteres alfanuméricos
                $pattern = '/^\d{36}[a-zA-Z0-9]{2}$/';

                while (($line = fgets($file)) !== false) {
                    $line = trim($line); // Remove espaços em branco extras

                    // Verifica se a linha corresponde ao padrão
                    if (preg_match($pattern, $line)) {
                        $tipo_id = substr($line, 0, 10);
                        $dia = (int)substr($line, 10, 2);
                        $mes = (int)substr($line, 12, 2);
                        $ano = (int)substr($line, 14, 4);
                        $hora = (int)substr($line, 18, 2);
                        $minutos = (int)substr($line, 20, 2);
                        $pis = substr($line, 22, 12);
                        $chave = substr($line, 34, 4);

                        DB::table('ponto_relatorio')->insert([
                            'tipo_id' => $tipo_id,
                            'dia' => $dia,
                            'mes' => $mes,
                            'ano' => $ano,
                            'hora' => $hora,
                            'minutos' => $minutos,
                            'pis_id' => $pis,
                            'chave' => $chave,
                        ]);
                    }
                }
                fclose($file);
            }
        } else {
            Log::error('Arquivo não encontrado: ' . $filePath);

            echo "Erro: Arquivo não encontrado no caminho especificado.";
        }
    }
}
