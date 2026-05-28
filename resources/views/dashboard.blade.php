<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(auth()->user()->role === 'admin')
                <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Painel de Controle</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Bem-vindo ao centro de gerenciamento do RentMaster.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.reports.excel') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-file-excel"></i>
                            Exportar Excel
                        </a>
                        <a href="{{ route('admin.reports.pdf') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-file-pdf"></i>
                            Exportar PDF
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Frota Total</span>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $totalEquipamentos }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xl">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Disponíveis</span>
                            <h3 class="text-2xl font-black text-green-600 dark:text-green-400 mt-1">{{ $disponiveis }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 text-xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Manutenção</span>
                            <h3 class="text-2xl font-black text-red-600 dark:text-red-400 mt-1">{{ $emManutencao }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 text-xl">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Locações Ativas</span>
                            <h3 class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ $contratosAtivos }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 text-xl">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between col-span-1 md:col-span-2 lg:col-span-1">
                        <div>
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Faturamento</span>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mt-1">R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-500 dark:text-amber-400 text-xl">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-colors duration-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Desempenho Financeiro</h2>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Visão mensal de receita gerada por aluguéis aprovados.</p>
                        </div>
                    </div>
                    <div class="w-full h-80 relative">
                        <canvas id="financialChart"
                                data-labels="{{ json_encode($labelsGrafico ?? []) }}"
                                data-valores="{{ json_encode($valoresGrafico ?? []) }}">
                        </canvas>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const chartElement = document.getElementById('financialChart');
                        if (!chartElement) return;

                        const ctx = chartElement.getContext('2d');
                        const labelsData = JSON.parse(chartElement.getAttribute('data-labels')) || [];
                        const valoresData = JSON.parse(chartElement.getAttribute('data-valores')) || [];

                        // ARRUMADO: Agora declaramos dinamicamente se o HTML está em dark mode
                        let isDark = document.documentElement.classList.contains('dark');
                        let textColor = isDark ? '#9ca3af' : '#4b5563';
                        let gridColor = isDark ? 'rgba(75, 85, 99, 0.2)' : 'rgba(229, 231, 235, 0.5)';

                        const financialChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labelsData.length > 0 ? labelsData : ['Sem registros'],
                                datasets: [{
                                    label: 'Faturamento (R$)',
                                    data: valoresData.length > 0 ? valoresData : [0],
                                    backgroundColor: 'rgba(59, 130, 246, 0.25)', // Azul padrão RentMaster
                                    borderColor: 'rgb(59, 130, 246)',
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    barThickness: 40
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { labels: { color: textColor, font: { weight: 'bold' } } }
                                },
                                scales: {
                                    x: {
                                        ticks: { color: textColor },
                                        grid: { color: gridColor }
                                    },
                                    y: {
                                        ticks: { color: textColor },
                                        grid: { color: gridColor },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        // ATUALIZAÇÃO EM TEMPO REAL: Atualiza as cores do gráfico ao clicar no botão de tema
                        function updateChartTheme() {
                            setTimeout(() => {
                                const updatedDark = document.documentElement.classList.contains('dark');
                                const updatedColor = updatedDark ? '#9ca3af' : '#4b5563';
                                const updatedGrid = updatedDark ? 'rgba(75, 85, 99, 0.2)' : 'rgba(229, 231, 235, 0.5)';

                                financialChart.options.scales.x.ticks.color = updatedColor;
                                financialChart.options.scales.x.grid.color = updatedGrid;
                                financialChart.options.scales.y.ticks.color = updatedColor;
                                financialChart.options.scales.y.grid.color = updatedGrid;
                                financialChart.options.plugins.legend.labels.color = updatedColor;
                                financialChart.update();
                            }, 100);
                        }

                        const toggleBtn = document.getElementById('theme-toggle');
                        const toggleBtnMobile = document.getElementById('theme-toggle-mobile');
                        if (toggleBtn) toggleBtn.addEventListener('click', updateChartTheme);
                        if (toggleBtnMobile) toggleBtnMobile.addEventListener('click', updateChartTheme);
                    });
                </script>

            @else
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Meus Aluguéis</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Acompanhe o status dos seus pedidos de reserva e equipamentos contratados.</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden transition-colors duration-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                    <th class="p-4">Equipamento</th>
                                    <th class="p-4">Retirada</th>
                                    <th class="p-4">Devolução</th>
                                    <th class="p-4">Valor Total</th>
                                    <th class="p-4">Status da Reserva</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-600 dark:text-gray-300">
                                @forelse($meusAlugueis as $aluguel)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="p-4 font-bold text-gray-950 dark:text-white">{{ $aluguel->product->name }}</td>
                                        <td class="p-4">{{ $aluguel->start_date->format('d/m/Y') }}</td>
                                        <td class="p-4">{{ $aluguel->end_date->format('d/m/Y') }}</td>
                                        <td class="p-4 font-semibold text-gray-900 dark:text-gray-100">R$ {{ number_format($aluguel->total_price, 2, ',', '.') }}</td>
                                        <td class="p-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                                {{ $aluguel->status === 'pendente' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' : '' }}
                                                {{ $aluguel->status === 'aprovado' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300' : '' }}
                                                {{ $aluguel->status === 'finalizado' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : '' }}
                                                {{ $aluguel->status === 'cancelado' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : '' }}
                                            ">
                                                {{ $aluguel->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-12 text-center text-gray-400 dark:text-gray-500">
                                            <i class="fa-solid fa-calendar-days text-4xl mb-3 text-gray-300 dark:text-gray-600 block"></i>
                                            Você ainda não realizou nenhuma solicitação de aluguel.
                                            <a href="/" class="text-blue-600 dark:text-blue-400 hover:underline font-medium block mt-2">Explorar catálogo de equipamentos</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
