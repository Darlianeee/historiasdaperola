// Função responsável por abrir e fechar o menu de opções de cada notificação.
function toggleMenu(event, index) {

    // Impede que o clique no botão seja interpretado como um clique fora do menu.
    event.stopPropagation();

    // Localiza o menu correspondente ao botão clicado.
    const menuAtual = document.getElementById('menu-' + index);

    // Verifica se o menu já está aberto.
    const estavaAberto = menuAtual.classList.contains('ativo');

    // Fecha todos os menus de opções que estiverem abertos.
    document.querySelectorAll('.menu-opcoes').forEach(function (menu) {
        menu.classList.remove('ativo');
    });

    // Atualiza o atributo de acessibilidade de todos os botões,
    // indicando que os menus estão fechados.
    document.querySelectorAll('.btn-opcoes').forEach(function (botao) {
        botao.setAttribute('aria-expanded', 'false');
    });

    // Se o menu clicado estava fechado, abre esse menu.
    if (!estavaAberto) {
        menuAtual.classList.add('ativo');

        // Atualiza o atributo de acessibilidade do botão clicado,
        // indicando que o menu está aberto.
        event.currentTarget.setAttribute('aria-expanded', 'true');
    }
}

// Identifica quando ocorre um clique em qualquer lugar da página.
document.addEventListener('click', function () {

    // Fecha todos os menus de opções abertos.
    document.querySelectorAll('.menu-opcoes').forEach(function (menu) {
        menu.classList.remove('ativo');
    });

    // Atualiza os botões para indicar que todos os menus estão fechados.
    document.querySelectorAll('.btn-opcoes').forEach(function (botao) {
        botao.setAttribute('aria-expanded', 'false');
    });
});

// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener('DOMContentLoaded', function () {

    // Busca o campo de pesquisa, o filtro de categorias,
    // os cartões das histórias e a mensagem de ausência de resultados.
    const busca = document.getElementById('buscaHistoria');
    const filtro = document.getElementById('filtroCategoria');
    const cartoes = document.querySelectorAll('.card-item');
    const semResultados = document.getElementById('semResultados');

    // Função responsável por padronizar os textos para facilitar a comparação.
    function normalizar(texto) {
        return (texto || '')

            // Separa os acentos das letras.
            .normalize('NFD')

            // Remove os acentos dos caracteres.
            .replace(/[\u0300-\u036f]/g, '')

            // Transforma todas as letras em minúsculas.
            .toLocaleLowerCase('pt-BR')

            // Remove os espaços desnecessários do início e do final.
            .trim();
    }

    // Função responsável por pesquisar e filtrar as histórias.
    function filtrarHistorias() {

        // Obtém o texto digitado no campo de pesquisa e o padroniza.
        const textoBusca = normalizar(busca.value);

        // Obtém a categoria selecionada pelo usuário.
        const categoriaSelecionada = filtro.value;

        // Conta a quantidade de histórias que correspondem aos filtros.
        let quantidadeVisivel = 0;

        // Percorre todos os cartões de histórias disponíveis.
        cartoes.forEach(function (cartao) {

            // Localiza o elemento que contém o título da história.
            const tituloCard = cartao.querySelector('.card-titulo');

            // Obtém os títulos da história nos idiomas disponíveis.
            // Caso algum título não exista, utiliza um texto vazio.
            const tituloPt = tituloCard.dataset.tituloPt || '';
            const tituloEs = tituloCard.dataset.tituloEs || '';
            const tituloWari = tituloCard.dataset.tituloWari || '';

            // Organiza os títulos junto com seus respectivos idiomas.
            const titulos = [
                { texto: tituloPt, idioma: 'pt' },
                { texto: tituloEs, idioma: 'es' },
                { texto: tituloWari, idioma: 'wari' }
            ];

            // Define o português como idioma padrão.
            let idiomaEncontrado = 'pt';

            // Verifica se existe algum texto digitado na pesquisa.
            if (textoBusca !== '') {

                // Procura um título que contenha o texto pesquisado.
                const correspondencia = titulos.find(item =>
                    normalizar(item.texto).includes(textoBusca)
                );

                // Se encontrar uma correspondência, identifica o idioma
                // em que o título foi encontrado.
                if (correspondencia) {
                    idiomaEncontrado = correspondencia.idioma;
                }
            }

            // Atualiza o idioma que será utilizado na página de leitura.
            // Localiza o botão responsável por abrir a história.
            const linkLeitura = cartao.querySelector('.btn-ler');

            // Verifica se o botão de leitura existe.
            if (linkLeitura) {

                // Obtém o endereço atual do link.
                const url = new URL(linkLeitura.href);

                // Adiciona ou atualiza o parâmetro "lang" na URL,
                // indicando o idioma encontrado na pesquisa.
                url.searchParams.set('lang', idiomaEncontrado);

                // Atualiza o endereço do botão de leitura.
                linkLeitura.href = url.href;
            }

            // Organiza os títulos de acordo com cada idioma.
            const tituloParaMostrar = {
                pt: tituloPt,
                es: tituloEs,
                wari: tituloWari
            };

            // Seleciona o título correspondente ao idioma encontrado.
            const tituloExibido = tituloParaMostrar[idiomaEncontrado];

            // Verifica se algum dos títulos corresponde ao texto pesquisado.
            // Se o campo estiver vazio, todas as histórias correspondem.
            const correspondeTitulo = textoBusca === '' ||
                titulos.some(function (item) {
                    return normalizar(item.texto).includes(textoBusca);
                });

            // Obtém e padroniza a categoria da história.
            const categoria = normalizar(cartao.dataset.categoria);

            // Verifica se a categoria do cartão corresponde à selecionada.
            // Se nenhuma categoria estiver selecionada, todas são aceitas.
            const correspondeCategoria =
                categoriaSelecionada === '' ||
                categoria === normalizar(categoriaSelecionada);

            // A história só será exibida se corresponder à pesquisa
            // e também à categoria selecionada.
            const mostrar = correspondeTitulo && correspondeCategoria;

            // Oculta os cartões que não correspondem aos filtros.
            cartao.hidden = !mostrar;

            // Executa as próximas ações somente para as histórias exibidas.
            if (mostrar) {

                // Atualiza o título do cartão para o idioma encontrado.
                // Caso não exista um título nesse idioma, utiliza o português.
                tituloCard.textContent = tituloExibido || tituloPt;

                // Aumenta a quantidade de histórias encontradas.
                quantidadeVisivel++;
            }
        });

        // Verifica se o elemento de mensagem de resultados existe.
        if (semResultados) {

            // Exibe a mensagem quando nenhuma história for encontrada
            // e oculta quando houver pelo menos uma correspondência.
            semResultados.hidden = quantidadeVisivel > 0;
        }
    }

    // Executa a filtragem sempre que o usuário digitar ou apagar
    // alguma informação no campo de pesquisa.
    busca.addEventListener('input', filtrarHistorias);

    // Executa a filtragem sempre que o usuário selecionar
    // uma categoria diferente.
    filtro.addEventListener('change', filtrarHistorias);
});