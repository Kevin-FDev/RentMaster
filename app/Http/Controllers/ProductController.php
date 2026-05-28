<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::all();


        $query = Product::where('status', 'disponivel');


        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }


        $products = $query->paginate(6)->appends($request->all());

        return view('welcome', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    public function storeRental(Request $request, Product $product)
    {
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

        Rental::create([
            'user_id'     => \Illuminate\Support\Facades\Auth::id(),
            'product_id'  => $product->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'total_price' => $totalPrice,
            'status'      => 'pendente'
        ]);

        return redirect()->back()->with('success', 'Sua solicitação de reserva foi enviada com sucesso! Aguarde a aprovação do administrador.');
    }
}
