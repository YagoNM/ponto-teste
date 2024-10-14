<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArquivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Caminho para o arquivo (atualize conforme necessário)
        $filePath = storage_path('app/AFD00014003750163172 (9).txt');

        if (file_exists($filePath)) {
            // Abra o arquivo e leia linha por linha
            $file = fopen($filePath, 'r');
            if ($file) {
                while (($line = fgets($file)) !== false) {
                    // Insira a linha no banco de dados
                    DB::table('arquivos')->insert([
                        'ponto' => trim($line),
                    ]);
                }
                fclose($file);
            }
        } else {
            echo "Arquivo não encontrado: " . $filePath;
        }
    }
}
