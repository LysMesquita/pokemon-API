<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    // Atributos que podem ser preenchidos via mass assignment
    protected $fillable = [
        'nome',       // Nome do Pokémon
        'tipo',       // Tipo do Pokémon (por exemplo: Fogo, Água, Elétrico)
        'nivel',      // Nível do Pokémon
        'hp',         // Pontos de vida (HP)
        'ataque',     // Atributo de ataque
        'defesa',     // Atributo de defesa
        'descricao',  // Descrição do Pokémon (ex: características, origem, etc)
    ];

}
