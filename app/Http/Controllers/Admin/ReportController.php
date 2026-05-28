<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barrier\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'relatorio-equipamentos.xlsx');
    }


    public function exportPdf()
    {
        $products = Product::with('category')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.products_pdf', compact('products'));

        return $pdf->download('relatorio-equipamentos.pdf');
    }
}
