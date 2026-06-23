<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentMaster - Aluguel de Equipamentos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased text-gray-900 dark:text-gray-100 transition-colors duration-200">

    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-8">
                    <div class="flex-shrink-0">
                        <a href="/" class="text-2xl font-bold text-blue-600 dark:text-blue-400">RentMaster</a>
                    </div>
                    <div class="hidden sm:flex space-x-4">
                        <a href="/" class="border-b-2 border-blue-500 text-sm text-gray-900 dark:text-white px-1 pt-1 font-semibold">
                            Equipamentos
                        </a>
                    </div>
                </div>

                <div class="flex space-x-4 items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-xl font-semibold shadow-sm transition-all">
                                📊 Meu Painel
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-2 text-sm text-white bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded-md font-medium shadow-sm transition-colors">Cadastrar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mb-8 transition-colors duration-200">
            <form action="/" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="w-full sm:w-auto">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filtrar por Categoria</label>
                    <select name="category_id" id="category_id" onchange="this.form.submit()" class="w-full sm:w-64 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas as Categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if(request('category_id'))
                    <a href="/" class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">Limpar Filtros</a>
                @endif
            </form>
        </div>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Equipamentos Disponíveis</h2>

        @if($products->isEmpty())
            <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm transition-colors duration-200">
                <p class="text-gray-500 dark:text-gray-400">Nenhum equipamento disponível nesta categoria no momento.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col justify-between hover:shadow-md dark:hover:border-gray-600 transition-all duration-200">
                        <div class="p-4">

                            <div class="w-full h-40 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-4 overflow-hidden border border-gray-100 dark:border-gray-600">
                                @if($product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center text-gray-400 dark:text-gray-500">
                                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-xs font-medium">Sem Foto</span>
                                    </div>
                                @endif
                            </div>

                            <span class="inline-block px-2 py-1 text-xs font-bold rounded bg-blue-50 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 uppercase tracking-wider mb-2">
                                {{ $product->category->name }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 tracking-tight">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>
                        </div>
                        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30 flex items-center justify-between transition-colors duration-200">
                            <div>
                                <span class="text-xs text-gray-400 dark:text-gray-500 block font-medium">Diária</span>
                                <span class="text-lg font-extrabold text-gray-900 dark:text-white">R$ {{ number_format($product->price_per_day, 2, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('products.show', $product) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-all transform hover:-translate-y-0.5">
                                Reservar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 px-2 dark:text-gray-300">
                {{ $products->links() }}
            </div>
        @endif

    </main>

</body>
</html>
