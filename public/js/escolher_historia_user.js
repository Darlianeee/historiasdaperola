// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener('DOMContentLoaded', function () {

    // Busca o campo de pesquisa, os cartões das histórias
    // e a mensagem que aparece quando não há resultados.
    const busca = document.getElementById('buscaHistoria');
    const cartoes = document.querySelectorAll('.card-item');
    const semResultados = document.getElementById('semResultados');

    // Verifica se o campo de pesquisa existe e se há cartões na página.
    // Caso contrário, encerra a execução do código.
    if (!busca || cartoes.length === 0) {
        return;
    }

    // Função responsável por padronizar o texto pesquisado.
    function normalizar(texto) {
        return (texto || '')
            // Separa os acentos das letras para facilitar a comparação.
            .normalize('NFD')

            // Remove os acentos das letras.
            .replace(/[\u0300-\u036f]/g, '')

            // Transforma todas as letras em minúsculas.
            .toLocaleLowerCase('pt-BR')

            // Remove os espaços desnecessários do início e do final.
            .trim();
    }

    // Função responsável por pesquisar e filtrar as histórias.
    function filtrarHistorias() {

        // Obtém o texto digitado e aplica a padronização.
        const textoBusca = normalizar(busca.value);

        // Conta quantas histórias correspondem à pesquisa.
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
                const correspondencia = titulos.find(function (item) {
                    return normalizar(item.texto).includes(textoBusca);
                });

                // Se encontrar uma correspondência, identifica o idioma
                // em que o título foi encontrado.
                if (correspondencia) {
                    idiomaEncontrado = correspondencia.idioma;
                }
            }

            // Organiza os títulos de acordo com cada idioma.
            const tituloPorIdioma = {
                pt: tituloPt,
                es: tituloEs,
                wari: tituloWari
            };

            // Seleciona o título correspondente ao idioma encontrado.
            // Caso não exista, utiliza o título em português.
            const tituloExibido =
                tituloPorIdioma[idiomaEncontrado] || tituloPt;

            // Verifica se algum dos títulos corresponde ao texto pesquisado.
            // Se o campo estiver vazio, todas as histórias serão exibidas.
            const correspondeTitulo =
                textoBusca === '' ||
                titulos.some(function (item) {
                    return normalizar(item.texto).includes(textoBusca);
                });

            // Oculta os cartões que não correspondem à pesquisa.
            cartao.hidden = !correspondeTitulo;

            // Executa as próximas ações somente se a história corresponder
            // ao texto pesquisado.
            if (correspondeTitulo) {

                // Exibe o título da história no idioma encontrado.
                tituloCard.textContent = tituloExibido;

                // Localiza o botão utilizado para acessar a história.
                const linkLeitura = cartao.querySelector('.btn-ler');

                // Verifica se o botão de leitura existe.
                if (linkLeitura) {

                    // Obtém o endereço atual do link.
                    const url = new URL(linkLeitura.href);

                    // Adiciona ou atualiza o parâmetro "lang" na URL,
                    // indicando o idioma correto da história.
                    url.searchParams.set('lang', idiomaEncontrado);

                    // Atualiza o endereço do botão de leitura.
                    linkLeitura.href = url.href;
                }

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

    // Executa a filtragem assim que a página carrega.
    // Isso também permite identificar o idioma quando a página
    // é carregada após uma pesquisa enviada pelo formulário.
    filtrarHistorias();

});