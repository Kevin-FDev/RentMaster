<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Controle Operacional de Reservas</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Aprovação de novos pedidos de aluguel e controle de devolução de equipamentos.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-800 dark:text-green-300 rounded-r-xl font-medium shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-600 dark:text-green-400"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                <th class="p-4">Cliente / Contato</th>
                                <th class="p-4">Endereço de Entrega</th>
                                <th class="p-4">Equipamento</th>
                                <th class="p-4">Período</th>
                                <th class="p-4">Valor Total</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-600 dark:text-gray-300">
                            @forelse($rentals as $rental)
                                <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/40 transition-colors">

                                    <td class="p-4 font-medium text-gray-950 dark:text-white">
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-base font-bold">{{ $rental->user->name }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                <i class="fa-solid fa-id-card text-[10px]"></i> CPF: {{ $rental->user->cpf ?? 'Não informado' }}
                                            </span>
                                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $rental->user->email }}</span>
                                            <span class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold flex items-center gap-1 mt-0.5">
                                                <i class="fa-solid fa-phone text-[10px]"></i> {{ $rental->user->phone ?? 'Sem telefone' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="p-4 max-w-xs">
                                        <div class="text-xs text-gray-600 dark:text-gray-300 line-clamp-3">
                                            <i class="fa-solid fa-location-dot text-gray-400 mr-0.5"></i>
                                            {{ $rental->user->address ?? 'Endereço não cadastrado' }}
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $rental->product->name }}</span>
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-2 text-xs">
                                            <span class="bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-2 py-1 rounded font-medium">
                                                {{ $rental->start_date->format('d/m/Y') }}
                                            </span>
                                            <i class="fa-solid fa-arrow-right text-gray-300 dark:text-gray-600 text-[10px]"></i>
                                            <span class="bg-purple-50 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 px-2 py-1 rounded font-medium">
                                                {{ $rental->end_date->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="p-4 font-bold text-gray-900 dark:text-white">
                                        R$ {{ number_format($rental->total_price, 2, ',', '.') }}
                                    </td>

                                    <td class="p-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold tracking-wide uppercase
                                            {{ $rental->status === 'pendente' ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300' : '' }}
                                            {{ $rental->status === 'aprovado' ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300' : '' }}
                                            {{ $rental->status === 'finalizado' ? 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300' : '' }}
                                            {{ $rental->status === 'cancelado' ? 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300' : '' }}
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
                                                <span class="text-xs text-gray-400 dark:text-gray-500 italic px-2">Sem ações pendentes</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 dark:text-gray-500">
                                        <i class="fa-solid fa-inbox text-3xl mb-2 block text-gray-300 dark:text-gray-600"></i>
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
