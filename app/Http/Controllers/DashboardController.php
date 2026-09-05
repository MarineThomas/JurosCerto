<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Cliente;

class DashboardController extends Controller
{
    public function index()
    {
        $totais = [
            'clientes'             => Cliente::count(),
            'emprestimos_ativos'   => Emprestimo::where('status', 'ativo')->count(),
            'emprestimos_quitados' => Emprestimo::where('status', 'quitado')->count(),
            'em_atraso'            => Emprestimo::where('status', 'em_atraso')->count(),
            'valor_total'          => Emprestimo::sum('valor_principal'),
        ];

        return view('dashboard', compact('totais'));
    }
}