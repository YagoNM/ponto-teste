<?php

namespace Database\Seeders;

use App\Models\Servidor;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class ServidorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            Servidor::insert([
                ['pis' => '01238796011', 'nome' => 'Osvaldo Teodoro Alves'],
                ['pis' => '000', 'nome' => 'Rogério Fernandes Navarro']
            ]);
        });
    }
}
