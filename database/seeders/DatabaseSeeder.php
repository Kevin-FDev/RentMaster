<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // 1. Criar Usuário Admin
    \App\Models\User::create([
        'name' => 'Administrador',
        'email' => 'admin@email.com',
        'password' => bcrypt('senha123'), // Criptografa a senha
        'role' => 'admin',
    ]);

    // 2. Criar Usuário Cliente Comum
    \App\Models\User::create([
        'name' => 'Fulano Cliente',
        'email' => 'cliente@email.com',
        'password' => bcrypt('senha123'),
        'role' => 'cliente',
    ]);

    // 3. Criar as Categorias e anexar Produtos a elas
    $categorias = ['Ferramentas', 'Fotografia', 'Camping'];

    foreach ($categorias as $nomeCategoria) {
        $categoria = \App\Models\Category::create(['name' => $nomeCategoria]);

        // Cria 4 produtos falsos para cada categoria
        \App\Models\Product::factory(4)->create([
            'category_id' => $categoria->id
        ]);
    }
}
}
