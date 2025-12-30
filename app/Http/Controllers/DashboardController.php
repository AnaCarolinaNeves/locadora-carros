<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Carro;
use App\Models\Cliente;
use App\Models\Locacao;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMarcas   = Marca::count();
        $totalModelos  = Modelo::count();
        $totalCarros   = Carro::count();
        $carrosDisp    = Carro::where('status', 'disponivel')->count();

        $totalClientes = Cliente::count();

        $locacoesAbertas     = Locacao::where('status', 'aberta')->count();
        $locacoesFinalizadas = Locacao::where('status', 'finalizada')->count();
        $locacoesCanceladas  = Locacao::where('status', 'cancelada')->count();

        // Faturamento simples (soma de valor_total de finalizadas)
        $faturamentoTotal = Locacao::where('status', 'finalizada')->sum('valor_total');

        return view('dashboard', compact(
            'totalMarcas',
            'totalModelos',
            'totalCarros',
            'carrosDisp',
            'totalClientes',
            'locacoesAbertas',
            'locacoesFinalizadas',
            'locacoesCanceladas',
            'faturamentoTotal'
        ));
    }
}