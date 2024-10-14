<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PontoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Caminho para o arquivo (atualize conforme necessário)
        $filePath = storage_path('app/AFD00014003750163172 (9).txt');

        if (file_exists($filePath)) {
            $file = fopen($filePath, 'r');
            if ($file) {
                while (($line = fgets($file)) !== false) {

                    $tipo_id = substr($line, 0, 10);
                    $dia = (int)substr($line, 10, 2);
                    $mes = (int)substr($line, 12, 2);
                    $ano = (int)substr($line, 14, 4);
                    $hora = (int)substr($line, 18, 2);
                    $minutos = (int)substr($line, 20, 2);
                    $pis = substr($line, 22, 11);
                    $chave = substr($line, 33, 5);

                    DB::table('ponto_relatorio')->insert([
                        'tipo_id' => $tipo_id,
                        'dia' => $dia,
                        'mes' => $mes,
                        'ano' => $ano,
                        'hora' => $hora,
                        'minutos' => $minutos,
                        'pis' => $pis,
                        'chave' => $chave,
                    ]);
                }
                fclose($file);
            }
        } else {
            echo "Arquivo não encontrado: " . $filePath;
        }
    }
}
