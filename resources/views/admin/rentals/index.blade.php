<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Controle Operacional de Reservas</h1>
                    <p class="text-sm text-gray-500 mt-1">Aprovação de novos pedidos de aluguel e controle de devolução de equipamentos.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-xl font-medium shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-600"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold uppercase tracking-wider text-gray-700">
                                <th class="p-4">Cliente</th>
                                <th class="p-4">Equipamento</th>
                                <th class="p-4">Período</th>
                                <th class="p-4">Valor Total</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                            @forelse($rentals as $rental)
                                <tr class="hover:bg-gray-50/70 transition-colors">
                                    <td class="p-4 font-medium text-gray-950">
                                        {{ $rental->user->name }}
                                        <span class="block text-xs text-gray-400 font-normal">{{ $rental->user->email }}</span>
                                    </td>

                                    <td class="p-4">
                                        <span class="font-semibold text-gray-900">{{ $rental->product->name }}</span>
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded font-medium">
                                                {{ $rental->start_date->format('d/m/Y') }}
                                            </span>
                                            <i class="fa-solid fa-arrow-right text-gray-300 text-[10px]"></i>
                                            <span class="bg-purple-50 text-purple-700 px-2 py-1 rounded font-medium">
                                                {{ $rental->end_date->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="p-4 font-bold text-gray-900">
                                        R$ {{ number_format($rental->total_price, 2, ',', '.') }}
                                    </td>

                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold tracking-wide uppercase
                                            {{ $rental->status === 'pendente' ? 'bg-amber-100 text-amber-800' : '' }}
                                            {{ $rental->status === 'aprovado' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $rental->status === 'finalizado' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $rental->status === 'cancelado' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ $rental->status }}
                                        </span>
                                    </td>

                                    <td class="p-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            @if($rental->status === 'pendente')
                                                <form action="{{ route('admin.rentals.approve', $rental->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-bold flex items-center gap-1 shadow-sm transition-all">
                                                        <i class="fa-solid fa-check"></i> Aprovar
                                                    </button>
                                                </form>
                                            @endif

                                            @if($rental->status === 'aprovado')
                                                <form action="{{ route('admin.rentals.finalize', $rental->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold flex items-center gap-1 shadow-sm transition-all">
                                                        <i class="fa-solid fa-box-open"></i> Receber Devolução
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($rental->status, ['finalizado', 'cancelado']))
                                                <span class="text-xs text-gray-400 italic px-2">Sem ações pendentes</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400">
                                        <i class="fa-solid fa-inbox text-3xl mb-2 block text-gray-300"></i>
                                        Nenhuma solicitação de reserva encontrada no sistema.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
