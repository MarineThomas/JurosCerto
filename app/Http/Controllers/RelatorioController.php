<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function comprovante(Emprestimo $emprestimo)
    {
        $emprestimo->load('cliente', 'parcelas');

        $pdf = Pdf::loadView('relatorios.comprovante', compact('emprestimo'));

        return $pdf->download('comprovante-emprestimo-' . $emprestimo->id . '.pdf');
    }
    
    public function geral(Request $request){
        $query = Emprestimo::with('cliente', 'parcelas');

        if ($request->filled('mes')) {
            $query->whereMonth('data_inicio', $request->mes);
        }

        if ($request->filled('ano')) {
            $query->whereYear('data_inicio', $request->ano);
        }

    $emprestimos = $query->orderByRaw("FIELD(status, 'ativo', 'em_atraso', 'quitado')")->get();

    $totais = [
        'total'           => $emprestimos->count(),
        'ativos'          => $emprestimos->where('status', 'ativo')->count(),
        'quitados'        => $emprestimos->where('status', 'quitado')->count(),
        'em_atraso'       => $emprestimos->where('status', 'em_atraso')->count(),
        'valor_total'     => $emprestimos->sum('valor_principal'),
        'total_juros'     => $emprestimos->sum(function($emprestimo) {
            $totalParcelas = $emprestimo->parcelas->sum('valor');
            return $totalParcelas - $emprestimo->valor_principal;
        }),
        'juros_recebidos' => $emprestimos->sum(function($emprestimo) {
            $parcelasPagas = $emprestimo->parcelas->where('status', 'pago')->sum('valor');
            $proporcaoPrincipal = $emprestimo->parcelas->count() > 0
                ? ($emprestimo->parcelas->where('status', 'pago')->count() / $emprestimo->parcelas->count()) * $emprestimo->valor_principal
                : 0;
            return $parcelasPagas - $proporcaoPrincipal;
        }),
        'mes' => $request->mes ? \Carbon\Carbon::create()->month((int)$request->mes)->translatedFormat('F') : null,
        'ano'  => $request->ano ?? null,
    ];


    $pdf = Pdf::loadView('relatorios.geral', compact('emprestimos', 'totais'));
    return $pdf->download('relatorio-geral.pdf');
    }
}
