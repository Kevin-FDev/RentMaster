<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {

        return Product::with('category')->get();
    }


    public function headings(): array
    {
        return ['ID', 'Equipamento', 'Categoria', 'Preço por Dia', 'Status', 'Cadastrado em'];
    }


    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->category->name,
            'R$ ' . number_format($product->price_per_day, 2, ',', '.'),
            ucfirst($product->status),
            $product->created_at->format('d/m/Y H:i'),
        ];
    }
}
