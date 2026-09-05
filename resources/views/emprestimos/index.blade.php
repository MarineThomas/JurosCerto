<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Empréstimos
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
                <h3 class="text-lg font-medium mb-4">Filtrar por Mês</h3>
                <form method="GET" action="{{ route('emprestimos.index') }}" class="flex gap-3 items-end">
                    <div>
                        <label class="block text-gray-700 text-sm mb-1">Mês</label>
                        <select name="mes" class="border rounded px-3 py-2">
                            <option value="">Todos</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm mb-1">Ano</label>
                        <select name="ano" class="border rounded px-3 py-2">
                            <option value="">Todos</option>
                            @foreach($anos as $ano)
                                <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>
                                    {{ $ano }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Filtrar
                    </button>
                    <a href="{{ route('emprestimos.index') }}"
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Limpar
                    </a>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Lista de Empréstimos</h3>
                    <div class="flex gap-3">
                        <a href="{{ route('emprestimos.create') }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Novo Empréstimo
                        </a>
                        <a href="{{ route('relatorios.geral', ['mes' => request('mes'), 'ano' => request('ano')]) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Relatório Geral PDF
                        </a>
                    </div>
                </div>

                @php $statusAtual = null; @endphp

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 pr-4">Cliente</th>
                            <th class="py-2 pr-4">Valor</th>
                            <th class="py-2 pr-4">Juros</th>
                            <th class="py-2 pr-4">Parcelas</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprestimos as $emprestimo)
                            @if($statusAtual !== $emprestimo->status)
                                @php $statusAtual = $emprestimo->status; @endphp
                                <tr>
                                    <td colspan="6" class="py-2 pt-4 font-medium text-sm
                                        {{ $emprestimo->status === 'ativo' ? 'text-green-700' : '' }}
                                        {{ $emprestimo->status === 'em_atraso' ? 'text-red-700' : '' }}
                                        {{ $emprestimo->status === 'quitado' ? 'text-gray-500' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $emprestimo->status)) }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 pr-4">{{ $emprestimo->cliente->nome }}</td>
                                <td class="py-2 pr-4">R$ {{ number_format($emprestimo->valor_principal, 2, ',', '.') }}</td>
                                <td class="py-2 pr-4">{{ $emprestimo->taxa_juros }}% ({{ $emprestimo->tipo_juros }})</td>
                                <td class="py-2 pr-4">{{ $emprestimo->num_parcelas }}x</td>
                                <td class="py-2 pr-4">
                                    <span class="px-2 py-1 rounded text-sm
                                        {{ $emprestimo->status === 'ativo' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $emprestimo->status === 'quitado' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $emprestimo->status === 'em_atraso' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $emprestimo->status)) }}
                                    </span>
                                </td>
                                <td class="py-2 flex gap-2">
                                    <a href="{{ route('emprestimos.show', $emprestimo) }}"
                                       class="text-blue-600 hover:underline">Ver</a>
                                    <form action="{{ route('emprestimos.destroy', $emprestimo) }}" method="POST"
                                          onsubmit="return confirm('Confirma exclusão?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">
                                    Nenhum empréstimo encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>