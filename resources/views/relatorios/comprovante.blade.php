<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { font-size: 22px; margin: 0; }
        .header p { margin: 4px 0; color: #666; }
        .section { margin-bottom: 20px; }
        .section h2 { font-size: 16px; border-bottom: 1px solid #ccc; padding-bottom: 4px; margin-bottom: 10px; }
        .grid { display: table; width: 100%; }
        .row { display: table-row; }
        .col { display: table-cell; padding: 4px 8px; width: 50%; }
        .label { color: #666; font-size: 12px; }
        .value { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f0f0f0; padding: 8px; text-align: left; font-size: 13px; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 13px; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #999; }
        .status-ativo { color: #15803d; }
        .status-quitado { color: #6b7280; }
        .status-em_atraso { color: #dc2626; }
    </style>
</head>
<body>

    <div class="header">
        <h1>JurosCertos</h1>
        <p>Comprovante de Empréstimo #{{ $emprestimo->id }}</p>
        <p>Emitido em {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <h2>Dados do Cliente</h2>
        <div class="grid">
            <div class="row">
                <div class="col"><span class="label">Nome</span><br><span class="value">{{ $emprestimo->cliente->nome }}</span></div>
                <div class="col"><span class="label">CPF</span><br><span class="value">{{ $emprestimo->cliente->cpf }}</span></div>
            </div>
            <div class="row">
                <div class="col"><span class="label">Telefone</span><br><span class="value">{{ $emprestimo->cliente->telefone }}</span></div>
                <div class="col"><span class="label">Endereço</span><br><span class="value">{{ $emprestimo->cliente->endereco }}</span></div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Dados do Empréstimo</h2>
        <div class="grid">
            <div class="row">
                <div class="col"><span class="label">Valor Principal</span><br><span class="value">R$ {{ number_format($emprestimo->valor_principal, 2, ',', '.') }}</span></div>
                <div class="col"><span class="label">Tipo de Juros</span><br><span class="value">{{ ucfirst($emprestimo->tipo_juros) }}</span></div>
            </div>
            <div class="row">
                <div class="col"><span class="label">Taxa de Juros</span><br><span class="value">{{ $emprestimo->taxa_juros }}% ao mês</span></div>
                <div class="col"><span class="label">Número de Parcelas</span><br><span class="value">{{ $emprestimo->num_parcelas }}x</span></div>
            </div>
            <div class="row">
                <div class="col"><span class="label">Data de Início</span><br><span class="value">{{ \Carbon\Carbon::parse($emprestimo->data_inicio)->format('d/m/Y') }}</span></div>
                <div class="col"><span class="label">Status</span><br><span class="value class-status-{{ $emprestimo->status }}">{{ ucfirst(str_replace('_', ' ', $emprestimo->status)) }}</span></div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Parcelas</h2>
        <table>
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Pagamento</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emprestimo->parcelas as $parcela)
                    <tr>
                        <td>{{ $parcela->numero }}</td>
                        <td>R$ {{ number_format($parcela->valor, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}</td>
                        <td>{{ $parcela->data_pagamento ? \Carbon\Carbon::parse($parcela->data_pagamento)->format('d/m/Y') : '-' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $parcela->status)) }}</td>
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