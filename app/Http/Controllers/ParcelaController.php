<?php

namespace App\Http\Controllers;
use App\Models\Parcela;



class ParcelaController extends Controller
{
     public function pagar(Parcela $parcela)
    {
        $parcela->update([
            'status'          => 'pago',
            'data_pagamento'  => now(),
        ]);

        $emprestimo = $parcela->emprestimo;
        $todasPagas = $emprestimo->parcelas()
            ->where('status', '!=', 'pago')
            ->doesntExist();

        if ($todasPagas) {
            $emprestimo->update(['status' => 'quitado']);
        }

        return redirect()->route('emprestimos.show', $emprestimo)
            ->with('sucesso', 'Parcela paga com sucesso!');
    }
}
