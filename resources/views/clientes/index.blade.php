<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('sucesso'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('sucesso') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Lista de Clientes</h3>
                    <a href="{{ route('clientes.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Novo Cliente
                    </a>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 pr-4">Nome</th>
                            <th class="py-2 pr-4">CPF</th>
                            <th class="py-2 pr-4">Telefone</th>
                            <th class="py-2 pr-4">Endereço</th>
                            <th class="py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 pr-4">{{ $cliente->nome }}</td>
                                <td class="py-2 pr-4">{{ $cliente->cpf }}</td>
                                <td class="py-2 pr-4">{{ $cliente->telefone }}</td>
                                <td class="py-2 pr-4">{{ $cliente->endereco }}</td>
                                <td class="py-2 flex gap-2">
                                    <a href="{{ route('clientes.edit', $cliente) }}"
                                       class="text-yellow-600 hover:underline">Editar</a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                          onsubmit="return confirm('Confirma exclusão?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">
                                    Nenhum cliente cadastrado ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>