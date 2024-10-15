<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';

    protected $fillable = [
        'pis',
        'nome',
    ];

    public function relatorios()
    {
        return $this->hasMany(Relatorio::class, 'pis_id', 'pis');
    }
}
