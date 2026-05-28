<x-app-layout>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Voltar para o catálogo
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-lg font-medium shadow-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg font-medium shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        <span class="font-bold">Não foi possível realizar a reserva:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm pl-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="w-full h-80 bg-gray-100 relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image text-6xl"></i>
                            </div>
                        @endif

                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm
                            {{ $product->status === 'disponivel' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $product->status === 'alugado' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $product->status === 'manutencao' ? 'bg-red-100 text-red-800' : '' }}
                        ">
                            {{ $product->status }}
                        </span>
                    </div>

                    <div class="p-8">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                            {{ $product->category->name }}
                        </span>
                        <h1 class="text-3xl font-extrabold text-gray-900 mt-3 tracking-tight">{{ $product->name }}</h1>

                        <hr class="my-6 border-gray-100">

                        <h3 class="text-lg font-bold text-gray-900 mb-2">Descrição do Equipamento</h3>
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description ?? 'Nenhuma descrição detalhada fornecida para este item.' }}</p>
                    </div>
                </div>

                <div id="booking-card" data-price="{{ $product->price_per_day }}" class="bg-white rounded-2xl border border-gray-100 shadow-md p-6 sticky top-6">
                    <div class="flex justify-between items-baseline mb-6">
                        <div>
                            <span class="text-2xl font-extrabold text-gray-900">R$ {{ number_format($product->price_per_day, 2, ',', '.') }}</span>
                            <span class="text-sm text-gray-500">/ dia</span>
                        </div>
                    </div>

                    @if($product->status === 'disponivel')
                        <form action="{{ route('rentals.store', $product->id) }}" method="POST">
                            @csrf

                            <div class="border border-gray-300 rounded-xl overflow-hidden shadow-sm mb-4">
                                <div class="grid grid-cols-2 divide-x divide-gray-300">
                                    <div class="p-3">
                                        <label for="start_date" class="block text-[10px] font-bold uppercase tracking-wider text-gray-700">Retirada</label>
                                        <input type="date" id="start_date" name="start_date" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required
                                               class="w-full border-0 p-0 mt-1 text-sm text-gray-900 focus:ring-0 cursor-pointer">
                                    </div>
                                    <div class="p-3">
                                        <label for="end_date" class="block text-[10px] font-bold uppercase tracking-wider text-gray-700">Devolução</label>
                                        <input type="date" id="end_date" name="end_date" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required
                                               class="w-full border-0 p-0 mt-1 text-sm text-gray-900 focus:ring-0 cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            <div id="price_summary" class="hidden space-y-3 mb-6 bg-gray-50 p-3 rounded-xl border border-gray-100 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span id="summary_days">R$ {{ number_format($product->price_per_day, 2, ',', '.') }} x 0 dias</span>
                                    <span id="summary_subtotal">R$ 0,00</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Taxa de serviço RentMaster</span>
                                    <span class="text-green-600">Grátis</span>
                                </div>
                                <hr class="border-gray-200">
                                <div class="flex justify-between font-bold text-gray-950 text-base">
                                    <span>Total estimado</span>
                                    <span id="summary_total">R$ 0,00</span>
                                </div>
                            </div>

                            @auth
                                <button type="submit" class="w-full py-3 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white font-bold rounded-xl shadow-sm transition-all text-center">
                                    Solicitar Reserva
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="block w-full py-3 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-xl shadow-sm transition-colors text-center text-sm">
                                    Entre para reservar
                                </a>
                            @endauth
                        </form>
                    @else
                        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-4 text-center">
                            <i class="fa-solid fa-calendar-xmark text-2xl mb-2 text-amber-600"></i>
                            <p class="text-sm font-semibold">Este equipamento não aceita reservas no momento porque está com status de <span class="font-bold uppercase">{{ $product->status }}</span>.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const priceSummary = document.getElementById('price_summary');
            const summaryDays = document.getElementById('summary_days');
            const summarySubtotal = document.getElementById('summary_subtotal');
            const summaryTotal = document.getElementById('summary_total');

            // Captura o preço injetado com segurança pela tag HTML do card
            const bookingCard = document.getElementById('booking-card');
            const pricePerDay = parseFloat(bookingCard.getAttribute('data-price')) || 0;

            function calculatePrice() {
                const startVal = startDateInput.value;
                const endVal = endDateInput.value;

                if (startVal && endVal) {
                    const start = new Date(startVal + 'T00:00:00');
                    const end = new Date(endVal + 'T00:00:00');

                    if (end >= start) {
                        const diffTime = Math.abs(end - start);
                        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDays === 0) diffDays = 1;

                        const total = diffDays * pricePerDay;

                        const formattedTotal = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                        const formattedPricePerDay = pricePerDay.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                        summaryDays.innerText = `${formattedPricePerDay} x ${diffDays} ${diffDays === 1 ? 'dia' : 'dias'}`;
                        summarySubtotal.innerText = formattedTotal;
                        summaryTotal.innerText = formattedTotal;

                        priceSummary.classList.remove('hidden');
                    } else {
                        priceSummary.classList.add('hidden');
                    }
                } else {
                    priceSummary.classList.add('hidden');
                }
            }

            startDateInput.addEventListener('change', () => {
                endDateInput.min = startDateInput.value;
                calculatePrice();
            });

            endDateInput.addEventListener('change', calculatePrice);
        });
    </script>
</x-app-layout>
