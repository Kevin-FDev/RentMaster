<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
{

    \App\Models\User::create([
        'name' => 'Administrador',
        'email' => 'admin@email.com',
        'password' => bcrypt('senha123'),
        'role' => 'admin',
    ]);


    \App\Models\User::create([
        'name' => 'Fulano Cliente',
        'email' => 'cliente@email.com',
        'password' => bcrypt('senha123'),
        'role' => 'cliente',
    ]);


    $categorias = ['Ferramentas', 'Fotografia', 'Camping'];

    foreach ($categorias as $nomeCategoria) {
        $categoria = \App\Models\Category::create(['name' => $nomeCategoria]);


        \App\Models\Product::factory(100)->create([
            'category_id' => $categoria->id
        ]);
    }
}
}
