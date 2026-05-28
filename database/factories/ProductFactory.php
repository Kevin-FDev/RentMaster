<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $equipamentos = [
            'Câmera Canon EOS Rebel T7',
            'Câmera Nikon D5600',
            'Lente Sony 50mm f/1.8',
            'Tripé Profissional Manfrotto',
            'Microfone de Lapela Rode Wireless',
            'Iluminador Led Godox',
            'Estabilizador Gimbal DJI Ronin',
            'Flash Speedlite Yongnuo',
            'Drone DJI Mavic Air 2',
            'Projetor BenQ 4K',
            'Caixa de Som JBL Boombox 3',
            'Notebook Gamer Dell G15'
        ];

        return [

            'name' => $this->faker->randomElement(['Câmera ', 'Lente ', 'Tripé ', 'Microfone ', 'Projetor ', 'Iluminador ']) . $this->faker->firstName() . ' ' . $this->faker->regexify('[A-Z]{3}-[0-9]{3}'),


            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,


            'description' => 'Equipamento de alta qualidade, revisado e pronto para uso profissional. Acompanha acessórios básicos e case de transporte.',


            'price_per_day' => $this->faker->randomFloat(2, 30, 250),

            'status' => 'disponivel',
            'image' => $this->faker->randomElement([
                'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500', // Câmera
                'https://images.unsplash.com/photo-1616440347437-b1c73416efc2?w=500', // Lente
                'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=500', // Eletrônicos
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=500', // Gadgets
                'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500'  // Tecnologia
            ]),
        ];
    }
}
