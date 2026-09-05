<?php

namespace App\Services;

use Carbon\Carbon;

class JurosService
{
    public function calcularParcelas(
        float $valorPrincipal,
        float $taxaJuros,
        int $numParcelas,
        string $tipoJuros,
        string $dataInicio
    ): array {
        $parcelas = [];
        $dataVencimento = Carbon::parse($dataInicio);

        for ($i = 1; $i <= $numParcelas; $i++) {
            $dataVencimento = $dataVencimento->copy()->addMonth();

            if ($tipoJuros === 'simples') {
                $valorParcela = ($valorPrincipal + ($valorPrincipal * ($taxaJuros / 100) * $numParcelas)) / $numParcelas;
            } else {
                $taxa = $taxaJuros / 100;
                $valorParcela = $valorPrincipal * ($taxa * pow(1 + $taxa, $numParcelas)) / (pow(1 + $taxa, $numParcelas) - 1);
            }

            $parcelas[] = [
                'numero'          => $i,
                'valor'           => round($valorParcela, 2),
                'data_vencimento' => $dataVencimento->format('Y-m-d'),
                'status'          => 'pendente',
            ];
        }

        return $parcelas;
    }
}