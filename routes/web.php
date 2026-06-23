<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminRentalController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    if ($user && $user->role === 'admin') {
        $totalEquipamentos = \App\Models\Product::count();
        $emManutencao      = \App\Models\Product::where('status', 'manutencao')->count();
        $disponiveis       = \App\Models\Product::where('status', 'disponivel')->count();

        $faturamentoTotal  = \App\Models\Rental::whereIn('status', ['aprovado', 'finalizado'])->sum('total_price');
        $contratosAtivos   = \App\Models\Rental::where('status', 'aprovado')->count();

        // Correção para SQLite: extrai o número do mês (01, 02, etc.)
        $dadosMeses = \App\Models\Rental::whereIn('status', ['aprovado', 'finalizado'])
            ->selectRaw('strftime("%m", start_date) as mes_num, SUM(total_price) as total')
            ->groupBy('mes_num')
            ->orderBy('mes_num', 'asc')
            ->get();

        // Mapeamento para traduzir o número gerado pelo SQLite para o nome do mês
        $mesesTraduzidos = [
            '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril',
            '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto',
            '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
        ];

        // Transforma a coleção gerando a lista de nomes traduzidos para o gráfico
        $labelsGrafico = $dadosMeses->map(function($item) use ($mesesTraduzidos) {
            return $mesesTraduzidos[$item->mes_num] ?? $item->mes_num;
        })->toArray();

        $valoresGrafico = $dadosMeses->pluck('total')->toArray();

        return view('dashboard', compact(
            'totalEquipamentos',
            'emManutencao',
            'disponiveis',
            'faturamentoTotal',
            'contratosAtivos',
            'labelsGrafico',
            'valoresGrafico'
        ));
    }

    $meusAlugueis = \App\Models\Rental::where('user_id', $user->id)
        ->with('product')
        ->latest()
        ->get();

    return view('dashboard', compact('meusAlugueis'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/products/{product}/rent', [ProductController::class, 'storeRental'])->name('rentals.store');
});


Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');

    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::patch('/rentals/{rental}/approve', [AdminRentalController::class, 'approve'])->name('rentals.approve');
    Route::patch('/rentals/{rental}/finalize', [AdminRentalController::class, 'finalize'])->name('rentals.finalize');
});

require __DIR__.'/auth.php';
