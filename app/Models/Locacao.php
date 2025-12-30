<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    use HasFactory;

    protected $table = 'locacoes';

    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_retirada',
        'data_devolucao_prevista',
        'valor_diaria',
        'valor_total',
        'status',
    ];

    protected $casts = [
        'data_retirada'            => 'date',
        'data_devolucao_prevista'  => 'date',
        'valor_diaria'             => 'decimal:2',
        'valor_total'              => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class);
    }

    public function carro()
    {
        return $this->belongsTo(\App\Models\Carro::class);
    }
}