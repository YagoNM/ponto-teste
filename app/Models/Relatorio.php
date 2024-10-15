<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    use HasFactory;

    protected $table = 'ponto_relatorio';

    protected $fillable = [
        'tipo_id',
        'dia',
        'mes',
        'ano',
        'hora',
        'minutos',
        'pis_id',
        'chave'
    ];

    public function servidor() 
    {
        return $this->belongsTo(Servidor::class, 'pis_id', 'pis');
    }
}
