<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove o campo antigo de texto longo
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }

            // Adiciona os novos campos separados
            $table->string('cep')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable(); // Guarda apenas a UF (ex: SP, DF)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Caso queira voltar atrás, recria o campo antigo e remove os novos
            $table->text('address')->nullable();

            $table->dropColumn(['cep', 'street', 'number', 'neighborhood', 'city', 'state']);
        });
    }
};
