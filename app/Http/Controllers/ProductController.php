<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // 👈 Importação do Mailer adicionada
use App\Mail\RentalConfirmedNotification; // 👈 Importação da nossa classe de email adicionada

class ProductController extends Controller
{
    // 1. INDEX PÚBLICO (Vitrine do sistema - welcome.blade.php)
    public function index(Request $request)
    {
        $categories = Category::all();

        // CORRIGIDO: Iniciamos a query buscando apenas produtos disponíveis
        $query = Product::where('status', 'disponivel');

        // Se o usuário filtrou por categoria na vitrine
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // CORRIGIDO: Agora aplicamos a paginação em cima da busca filtrada ($query)
        $products = $query->paginate(8);

        return view('welcome', compact('products', 'categories'));
    }

    // 2. INDEX DO ADMINISTRADOR (Painel de Gerenciamento - admin/products/index.blade.php)
    public function adminIndex()
    {
        // Paginamos todos os produtos (independente de status) para o admin gerenciar
        $products = Product::paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    public function storeRental(Request $request, Product $product)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // CORRIGIDO: Checa se os novos campos de endereço separados estão preenchidos
        if (empty($user->cpf) || empty($user->phone) || empty($user->cep) || empty($user->street) || empty($user->number)) {
            return redirect()->route('profile.edit')
                ->with('error', 'Atenção! Você precisa completar suas informações de perfil e endereço antes de solicitar qualquer equipamento.');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        if ($product->status !== 'disponivel') {
            return redirect()->back()->withErrors(['O produto selecionado não está disponível para locação no momento.']);
        }

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);
        $days  = $start->diffInDays($end);

        if ($days === 0) {
            $days = 1;
        }

        $totalPrice = $days * $product->price_per_day;

        // Cria a locação no banco de dados
        $rental = Rental::create([
            'user_id'     => \Illuminate\Support\Facades\Auth::id(),
            'product_id'  => $product->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'total_price' => $totalPrice,
            'status'      => 'pendente'
        ]);

        // 📧 GATILHO DE ENVIO DE EMAIL AUTOMÁTICO
        // Envia o e-mail informando o valor, nome do produto e tempo total de aluguel
        $durationText = $days . ($days === 1 ? ' dia' : ' dias');
        Mail::to($user->email)->send(new RentalConfirmedNotification(
            $product->name,
            $totalPrice,
            $durationText
        ));

        return redirect()->back()->with('success', 'Sua solicitação de reserva foi enviada com sucesso! Um e-mail com os detalhes foi enviado para você.');
    }
}
