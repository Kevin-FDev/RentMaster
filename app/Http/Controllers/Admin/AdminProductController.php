<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    // Lista todos os produtos no painel do Admin
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Abre o formulário de cadastro de novo produto
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Salva o produto no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price_per_day' => $request->price_per_day,
            'description' => $request->description,
            'status' => 'disponivel',
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    // Abre a tela de edição com os dados do produto preenchidos
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Atualiza os dados do produto no banco
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:disponivel,alugado,manutencao',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    // Exclui o produto do banco de dados
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produto excluído com sucesso!');
    }
}
