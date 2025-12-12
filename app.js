const pokedexContainer = document.getElementById('pokedex-container');

async function fetchPokemonData(id) {
  try {
    const res = await fetch(`https://pokeapi.co/api/v2/pokemon/${id}`);
    const data = await res.json();

    const speciesRes = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${id}`);
    const speciesData = await speciesRes.json();

    const tipoPT = {
      normal: 'Normal',
      fire: 'Fogo',
      water: 'Água',
      grass: 'Grama',
      electric: 'Elétrico',
      ice: 'Gelo',
      fighting: 'Lutador',
      poison: 'Veneno',
      ground: 'Terra',
      flying: 'Voador',
      psychic: 'Psíquico',
      bug: 'Inseto',
      rock: 'Pedra',
      ghost: 'Fantasma',
      dragon: 'Dragão',
      dark: 'Sombrio',
      steel: 'Aço',
      fairy: 'Fada'
    };

    return {
      id: id,
      nome: data.name,
      tipo: data.types.map(t => tipoPT[t.type.name]).join(', '),
      hp: data.stats.find(s => s.stat.name === 'hp').base_stat,
      ataque: data.stats.find(s => s.stat.name === 'attack').base_stat,
      defesa: data.stats.find(s => s.stat.name === 'defense').base_stat,
      nivel: data.base_experience,
      imagem: data.sprites.front_default,
      speciesUrl: speciesData.evolution_chain.url
    };
  } catch (error) {
    console.error('Erro ao buscar Pokémon:', error);
  }
}

function createPokemonCard(pokemon, container, isLast) {
  const card = document.createElement('div');
  card.classList.add('pokemon-card');

  card.innerHTML = `
    <img src="${pokemon.imagem}" alt="${pokemon.nome}">
    <h3>${pokemon.nome}</h3>
    <p><strong>Tipo:</strong> ${pokemon.tipo}</p>
    <p><strong>HP:</strong> ${pokemon.hp}</p>
    <p><strong>Ataque:</strong> ${pokemon.ataque}</p>
    <p><strong>Defesa:</strong> ${pokemon.defesa}</p>
    <p><strong>Nível:</strong> ${pokemon.nivel}</p>
  `;

  container.appendChild(card);

  if (!isLast) {
    const arrow = document.createElement('div');
    arrow.classList.add('evolution-arrow');
    arrow.innerHTML = '➯';
    container.appendChild(arrow);
  }
}


// Função que cria as linhas evolutivas automaticamente
async function createEvolutionLines() {
  const pokemons = [];
  for (let i = 1; i <= 151; i++) {
    const p = await fetchPokemonData(i);
    if (p) pokemons.push(p);
  }

  // Agrupar Pokémon por URL de evolução
  const linesMap = {};
  pokemons.forEach(pokemon => {
    const chainUrl = pokemon.speciesUrl;
    if (!linesMap[chainUrl]) linesMap[chainUrl] = [];
    linesMap[chainUrl].push(pokemon);
  });

  // Criar os containers das linhas evolutivas
  Object.values(linesMap).forEach(line => {
    const lineDiv = document.createElement('div');
    lineDiv.classList.add('evolution-line');

    // Ordenar pela ID dentro da linha
    line.sort((a, b) => a.id - b.id);

    line.forEach((pokemon, index) => {
      const isLast = index === line.length - 1;
      createPokemonCard(pokemon, lineDiv, isLast);
    });

    pokedexContainer.appendChild(lineDiv);
  });
}


createEvolutionLines();