<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { font-size: 22px; margin: 0; }
        .header p { margin: 4px 0; color: #666; }
        .totais { display: table; width: 100%; margin-bottom: 24px; }
        .totais-row { display: table-row; }
        .totais-col { display: table-cell; text-align: center; padding: 12px; border: 1px solid #ddd; background: #f9f9f9; }
        .totais-col .numero { font-size: 24px; font-weight: bold; }
        .totais-col .legenda { font-size: 12px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f0f0f0; padding: 8px; text-align: left; font-size: 13px; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 13px; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #999; }
        .section h2 { font-size: 16px; border-bottom: 1px solid #ccc; padding-bottom: 4px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>JurosCertos</h1>
        <p>Relatório Geral de Empréstimos</p>
        
        @if($totais['mes'] && $totais['ano'])
            <p>Período: {{ ucfirst($totais['mes']) }} de {{ $totais['ano'] }}</p>
        @else
        <p>Todos os períodos</p>
        @endif
        
        <p>Emitido em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <h2>Resumo</h2>
        <div class="totais">
            <div class="totais-row">
                <div class="totais-col">
                    <div class="numero">{{ $totais['total'] }}</div>
                    <div class="legenda">Total</div>
                </div>
                <div class="totais-col">
                    <div class="numero">{{ $totais['ativos'] }}</div>
                    <div class="legenda">Ativos</div>
                </div>
                <div class="totais-col">
                    <div class="numero">{{ $totais['quitados'] }}</div>
                    <div class="legenda">Quitados</div>
                </div>
                <div class="totais-col">
                    <div class="numero">{{ $totais['em_atraso'] }}</div>
                    <div class="legenda">Em Atraso</div>
                </div>
                <div class="totais-col">
                    <div class="numero">R$ {{ number_format($totais['valor_total'], 2, ',', '.') }}</div>
                    <div class="legenda">Valor Total</div>
                </div>


                <div class="totais-col">
                    <div class="numero" style="color: #1d4ed8">R$ {{ number_format($totais['total_juros'], 2, ',', '.') }}</div>
                    <div class="label">Total de Juros Previstos</div>
                </div>
                <div class="totais-col">
                    <div class="numero" style="color: #15803d">R$ {{ number_format($totais['juros_recebidos'], 2, ',', '.') }}</div>
                    <div class="label">Juros Recebidos</div>
                </div>  

            </div>
        </div>
    </div>

    <div class="section">
        <h2>Lista de Empréstimos</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Juros</th>
                    <th>Parcelas</th>
                    <th>Início</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emprestimos as $emprestimo)
                    <tr>
                        <td>{{ $emprestimo->id }}</td>
                        <td>{{ $emprestimo->cliente->nome }}</td>
                        <td>R$ {{ number_format($emprestimo->valor_principal, 2, ',', '.') }}</td>
                        <td>{{ $emprestimo->taxa_juros }}% ({{ $emprestimo->tipo_juros }})</td>
                        <td>{{ $emprestimo->num_parcelas }}x</td>
                        <td>{{ \Carbon\Carbon::parse($emprestimo->data_inicio)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $emprestimo->status)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Documento gerado automaticamente pelo sistema JurosCertos.</p>
    </div>

</body>
</html>