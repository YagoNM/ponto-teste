<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ponto_relatorio', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_id', 10); 
            $table->integer('dia');
            $table->integer('mes');
            $table->integer('ano');
            $table->integer('hora');
            $table->integer('minutos');
            $table->string('pis_id', 11);
            $table->string('chave', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ponto_relatorio');
    }
};
