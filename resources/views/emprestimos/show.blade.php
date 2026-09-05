<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Empréstimo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('sucesso'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('sucesso') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">Informações do Empréstimo</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-500 text-sm">Cliente</span>
                        <p class="font-medium">{{ $emprestimo->cliente->nome }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Valor Principal</span>
                        <p class="font-medium">R$ {{ number_format($emprestimo->valor_principal, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Tipo de Juros</span>
                        <p class="font-medium">{{ ucfirst($emprestimo->tipo_juros) }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Taxa de Juros</span>
                        <p class="font-medium">{{ $emprestimo->taxa_juros }}% ao mês</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Parcelas</span>
                        <p class="font-medium">{{ $emprestimo->num_parcelas }}x</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Data de Início</span>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($emprestimo->data_inicio)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">Status</span>
                        <p>
                            <span class="px-2 py-1 rounded text-sm
                                {{ $emprestimo->status === 'ativo' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $emprestimo->status === 'quitado' ? 'bg-gray-100 text-gray-700' : '' }}
                                {{ $emprestimo->status === 'em_atraso' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $emprestimo->status)) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Parcelas</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 pr-4">Nº</th>
                            <th class="py-2 pr-4">Valor</th>
                            <th class="py-2 pr-4">Vencimento</th>
                            <th class="py-2 pr-4">Pagamento</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emprestimo->parcelas as $parcela)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 pr-4">{{ $parcela->numero }}</td>
                                <td class="py-2 pr-4">R$ {{ number_format($parcela->valor, 2, ',', '.') }}</td>
                                <td class="py-2 pr-4">{{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}</td>
                                <td class="py-2 pr-4">
                                    {{ $parcela->data_pagamento ? \Carbon\Carbon::parse($parcela->data_pagamento)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="py-2 pr-4">
                                    <span class="px-2 py-1 rounded text-sm
                                        {{ $parcela->status === 'pendente' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $parcela->status === 'pago' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $parcela->status === 'em_atraso' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $parcela->status)) }}
                                    </span>
                                </td>
                                <td class="py-2">
                                    @if($parcela->status !== 'pago')
                                        <form action="{{ route('parcelas.pagar', $parcela) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-green-600 hover:underline">
                                                Pagar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">Pago</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    
                <a href="{{ route('relatorios.comprovante', $emprestimo) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Baixar Comprovante PDF
                    </a>
                    <a href="{{ route('emprestimos.index') }}"
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Voltar
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>