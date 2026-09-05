<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-3xl font-bold text-blue-600">{{ $totais['clientes'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Clientes cadastrados</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-3xl font-bold text-green-600">{{ $totais['emprestimos_ativos'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Empréstimos ativos</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-3xl font-bold text-red-600">{{ $totais['em_atraso'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Empréstimos em atraso</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-gray-400">
                    <div class="text-3xl font-bold text-gray-600">{{ $totais['emprestimos_quitados'] }}</div>
                    <div class="text-gray-500 text-sm mt-1">Empréstimos quitados</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-3xl font-bold text-yellow-600">R$ {{ number_format($totais['valor_total'], 2, ',', '.') }}</div>
                    <div class="text-gray-500 text-sm mt-1">Valor total emprestado</div>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-6">
                <a href="{{ route('clientes.index') }}"
                   class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition">
                    <div class="font-medium text-gray-800 mb-1">Gerenciar Clientes</div>
                    <div class="text-gray-500 text-sm">Cadastrar, editar e excluir clientes</div>
                </a>
                <a href="{{ route('emprestimos.index') }}"
                   class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition">
                    <div class="font-medium text-gray-800 mb-1">Gerenciar Empréstimos</div>
                    <div class="text-gray-500 text-sm">Registrar e acompanhar empréstimos</div>
                </a>
                <a href="{{ route('relatorios.geral') }}"
                   class="bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition">
                    <div class="font-medium text-gray-800 mb-1">Relatório Geral PDF</div>
                    <div class="text-gray-500 text-sm">Baixar relatório completo em PDF</div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>