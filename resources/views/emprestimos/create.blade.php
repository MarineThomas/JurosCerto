<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novo Empréstimo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('emprestimos.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Cliente</label>
                        <select name="cliente_id"
                                class="w-full border rounded px-3 py-2 @error('cliente_id') border-red-500 @enderror">
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Valor Principal (R$)</label>
                        <input type="number" step="0.01" name="valor_principal" value="{{ old('valor_principal') }}"
                               class="w-full border rounded px-3 py-2 @error('valor_principal') border-red-500 @enderror">
                        @error('valor_principal')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Tipo de Juros</label>
                        <select name="tipo_juros"
                                class="w-full border rounded px-3 py-2 @error('tipo_juros') border-red-500 @enderror">
                            <option value="">Selecione o tipo</option>
                            <option value="simples" {{ old('tipo_juros') == 'simples' ? 'selected' : '' }}>Simples</option>
                            <option value="composto" {{ old('tipo_juros') == 'composto' ? 'selected' : '' }}>Composto</option>
                        </select>
                        @error('tipo_juros')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Taxa de Juros (% ao mês)</label>
                        <input type="number" step="0.01" name="taxa_juros" value="{{ old('taxa_juros') }}"
                               class="w-full border rounded px-3 py-2 @error('taxa_juros') border-red-500 @enderror">
                        @error('taxa_juros')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Número de Parcelas</label>
                        <input type="number" name="num_parcelas" value="{{ old('num_parcelas') }}"
                               class="w-full border rounded px-3 py-2 @error('num_parcelas') border-red-500 @enderror">
                        @error('num_parcelas')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Data de Início</label>
                        <input type="date" name="data_inicio" value="{{ old('data_inicio') }}"
                               class="w-full border rounded px-3 py-2 @error('data_inicio') border-red-500 @enderror">
                        @error('data_inicio')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Salvar
                        </button>
                        <a href="{{ route('emprestimos.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>