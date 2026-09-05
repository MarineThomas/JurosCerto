<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novo Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Nome</label>
                        <input type="text" name="nome" value="{{ old('nome') }}"
                               class="w-full border rounded px-3 py-2 @error('nome') border-red-500 @enderror">
                        @error('nome')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">CPF</label>
                        <input type="text" name="cpf" value="{{ old('cpf') }}"
                               placeholder="000.000.000-00"
                               class="w-full border rounded px-3 py-2 @error('cpf') border-red-500 @enderror">
                        @error('cpf')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Telefone</label>
                        <input type="text" name="telefone" value="{{ old('telefone') }}"
                               class="w-full border rounded px-3 py-2 @error('telefone') border-red-500 @enderror">
                        @error('telefone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Endereço</label>
                        <input type="text" name="endereco" value="{{ old('endereco') }}"
                               class="w-full border rounded px-3 py-2 @error('endereco') border-red-500 @enderror">
                        @error('endereco')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Salvar
                        </button>
                        <a href="{{ route('clientes.index') }}"
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>