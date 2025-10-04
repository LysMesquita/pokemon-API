<?php
namespace App\Http\Controllers;

use App\Models\Pokemons;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PokemonController extends Controller
{
    public function index()
    {
        // Buscando todos os Pokémons
        $pokemons = Pokemon::all();

        // Contando o número de registros
        $contador = $pokemons->count();

        // Verificando se há Pokémons
        if ($contador > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Pokémons encontrados com sucesso!',
                'data' => $pokemons,
                'total' => $contador
            ], 200); // Retorna HTTP 200 (OK) com os dados e a contagem
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum Pokémon encontrado.',
            ], 404); // Retorna HTTP 404 (Not Found) se não houver registros
        }
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validador = Validator::make($request->all(), [
            'nome' => 'required',
            'tipo' => 'required',
            'nivel' => 'required',
            'hp' => 'required',
            'ataque' => 'required',
            'defesa' => 'required',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validador->errors(),
            ], 400); // Retorna HTTP 400 (Bad Request) se houver erro de validação
        }

        // Criando um Pokémon no banco de dados
        $pokemon = Pokemon::create($request->all());

        if ($pokemon) {
            return response()->json([
                'success' => true,
                'message' => 'Pokémon cadastrado com sucesso!',
                'data' => $pokemon,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar o Pokémon',
            ], 500); // Retorna HTTP 500 (Internal Server Error) se o cadastro falhar
        }
    }

    public function show($id)
    {
        // Buscando um Pokémon pelo ID
        $pokemon = Pokemon::find($id);

        // Verificando se o Pokémon foi encontrado
        if ($pokemon) {
            return response()->json([
                'success' => true,
                'message' => 'Pokémon localizado com sucesso!',
                'data' => $pokemon
            ], 200); // Retorna HTTP 200 (OK) com os dados do Pokémon
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pokémon não encontrado.',
            ], 404); // Retorna HTTP 404 (Not Found) se o Pokémon não for encontrado
        }
    }

    public function update(Request $request, string $id)
    {
        $validador = Validator::make($request->all(), [
            'nome' => 'required',
            'tipo' => 'required',
            'nivel' => 'required',
            'hp' => 'required',
            'ataque' => 'required',
            'defesa' => 'required',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $validador->errors()
            ], 400); // Retorna HTTP 400 se houver erro de validação
        }

        // Encontrando um Pokémon no banco
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Pokémon não encontrado'
            ], 404);
        }

        // Atualizando os dados do Pokémon
        $pokemon->nome = $request->nome;
        $pokemon->tipo = $request->tipo;
        $pokemon->nivel = $request->nivel;
        $pokemon->hp = $request->hp;
        $pokemon->ataque = $request->ataque;
        $pokemon->defesa = $request->defesa;

        // Salvando as alterações
        if ($pokemon->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Pokémon atualizado com sucesso!',
                'data' => $pokemon
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o Pokémon'
            ], 500); // Retorna HTTP 500 se houver erro ao salvar
        }
    }

    public function destroy($id)
    {
        // Encontrando um Pokémon
        $pokemon = Pokemon::find($id);

        if (!$pokemon) {
            return response()->json([
                'success' => false,
                'message' => 'Pokémon não encontrado.'
            ], 404); // Retorna HTTP 404 se o Pokémon não for encontrado
        }

        // Deletando o Pokémon
        if ($pokemon->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Pokémon deletado com sucesso'
            ], 200); // Retorna HTTP 200 se a exclusão for bem-sucedida
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao deletar o Pokémon'
        ], 500); // Retorna HTTP 500 se houver erro na exclusão
    }
}
