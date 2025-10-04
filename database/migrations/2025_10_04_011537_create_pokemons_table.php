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
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id(); // ID único do Pokémon
            $table->string('nome'); // Nome do Pokémon
            $table->string('tipo'); // Tipo do Pokémon (ex: Fogo, Água, Elétrico)
            $table->integer('nivel'); // Nível do Pokémon
            $table->integer('hp'); // Pontos de vida (HP)
            $table->integer('ataque'); // Atributo de ataque
            $table->integer('defesa'); // Atributo de defesa
            $table->text('descricao'); // Descrição do Pokémon (ex: história, características, etc.)
            $table->timestamps(); // timestamps para created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemons'); // Apaga a tabela 'pokemons'
    }
};
