<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'name' => $this->faker->words(3, true), // Cria um nome com 3 palavras
        'description' => $this->faker->sentence(), // Cria uma frase de descrição
        'price_per_day' => $this->faker->randomFloat(2, 20, 200), // Preço entre 20 e 200
        'status' => 'disponivel',
        'image' => null, // Deixamos nulo por enquanto
    ];
}
}
