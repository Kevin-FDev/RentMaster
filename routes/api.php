<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;


Route::get('/products', function () {
    $products = Product::with('category')->get();

    return response()->json([
        'success' => true,
        'count'   => $products->count(),
        'data'    => $products
    ], 200);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
