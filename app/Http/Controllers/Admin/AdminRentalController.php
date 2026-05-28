<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class AdminRentalController extends Controller
{
    // Listar todas as reservas para o Admin gerenciar
    public function index()
    {
        // Traz as reservas carregando junto os dados do usuário e do produto associado
        $rentals = Rental::with(['user', 'product'])->latest()->get();
        return view('admin.rentals.index', compact('rentals'));
    }

    // Aprovar a reserva e colocar o produto como Alugado
    public function approve(Rental $rental)
    {
        // Altera o status da reserva
        $rental->update(['status' => 'aprovado']);

        // Altera o status do produto correspondente para "alugado"
        $rental->product->update(['status' => 'alugado']);

        return redirect()->back()->with('success', 'Reserva aprovada com sucesso! O equipamento agora consta como ALUGADO.');
    }

    // Confirmar a devolução e liberar o produto de volta para Disponível
    public function finalize(Rental $rental)
    {
        // Altera o status da reserva para finalizado
        $rental->update(['status' => 'finalizado']);

        // Libera o equipamento de volta para o catálogo
        $rental->product->update(['status' => 'disponivel']);

        return redirect()->back()->with('success', 'Devolução confirmada! O equipamento voltou a ficar DISPONÍVEL para novos aluguéis.');
    }
}
