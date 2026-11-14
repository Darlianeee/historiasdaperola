// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener('DOMContentLoaded', function () {

    // Busca os botões utilizados para alternar entre os idiomas
    // e o formulário de cadastro da história.
    const botoesIdioma = document.querySelectorAll('.idiomas button');
    const formulario = document.getElementById('formHistoria');

    // Busca os campos responsáveis pelo preenchimento da história.
    const campoTitulo = document.getElementById('titulo');
    const campoLegenda = document.getElementById('legenda');
    const campoTexto = document.getElementById('texto');

    // Busca os elementos que exibem os nomes dos campos.
    const labelTitulo = document.getElementById('labelTitulo');
    const labelLegenda = document.getElementById('labelLegenda');
    const labelTexto = document.getElementById('labelTexto');

    // Cria um objeto para armazenar os dados de cada idioma.
    // Cada idioma possui um espaço para guardar o título,
    // a legenda da imagem e o texto da história.
    const dados = {
        pt: { titulo: '', legenda: '', texto: '' },
        es: { titulo: '', legenda: '', texto: '' },
        wari: { titulo: '', legenda: '', texto: '' }
    };

    // Armazena as informações específicas de cada idioma,
    // como o nome que será exibido e os textos de orientação dos campos.
    const idiomas = {
        pt: {
            nome: 'Português',
            titulo: 'Digite o título em português...',
            legenda: 'Digite a legenda da imagem em português...',
            texto: 'Digite o texto em português...'
        },
        es: {
            nome: 'Espanhol',
            titulo: 'Escribe el título en español...',
            legenda: 'Escribe la leyenda de la imagen en español...',
            texto: 'Escribe la historia en español...'
        },
        wari: {
            nome: "Wari' Oro Nao",
            titulo: "Digite o título em Wari' Oro Nao...",
            legenda: "Digite a legenda da imagem em Wari' Oro Nao...",
            texto: "Digite a história em Wari' Oro Nao..."
        }
    };

    // Define o português como idioma inicial do formulário.
    let idiomaAtual = 'pt';

    // Função responsável por guardar os dados preenchidos
    // nos campos do idioma que está sendo utilizado.
    function guardarCampos() {

        // Armazena os valores atuais no objeto correspondente ao idioma.
        dados[idiomaAtual].titulo = campoTitulo.value;
        dados[idiomaAtual].legenda = campoLegenda.value;
        dados[idiomaAtual].texto = campoTexto.value;
    }

    // Função responsável por trocar o idioma exibido no formulário.
    function trocarIdioma(novoIdioma) {

        // Verifica se o idioma solicitado existe no objeto de dados.
        // Caso não exista, encerra a função.
        if (!dados[novoIdioma]) {
            return;
        }

        // Guarda os dados do idioma atual antes de realizar a troca.
        guardarCampos();

        // Atualiza a variável com o novo idioma selecionado.
        idiomaAtual = novoIdioma;

        // Recupera e exibe os dados que já foram preenchidos
        // no idioma selecionado.
        campoTitulo.value = dados[novoIdioma].titulo;
        campoLegenda.value = dados[novoIdioma].legenda;
        campoTexto.value = dados[novoIdioma].texto;

        // Atualiza os nomes dos campos de acordo com o idioma selecionado.
        labelTitulo.textContent =
            'Título (' + idiomas[novoIdioma].nome + ')';

        labelLegenda.textContent =
            'Legenda da imagem (' + idiomas[novoIdioma].nome + ')';

        labelTexto.textContent =
            'Texto (' + idiomas[novoIdioma].nome + ')';

        // Atualiza os textos de orientação que aparecem dentro dos campos.
        campoTitulo.placeholder = idiomas[novoIdioma].titulo;
        campoLegenda.placeholder = idiomas[novoIdioma].legenda;
        campoTexto.placeholder = idiomas[novoIdioma].texto;

        // Define os campos como obrigatórios somente quando
        // o idioma selecionado for o português.
        campoTitulo.required = novoIdioma === 'pt';
        campoLegenda.required = novoIdioma === 'pt';
        campoTexto.required = novoIdioma === 'pt';

        // Percorre os botões e atualiza a classe "ativo"
        // para destacar visualmente o idioma selecionado.
        botoesIdioma.forEach(function (botao) {
            botao.classList.toggle(
                'ativo',
                botao.dataset.idioma === novoIdioma
            );
        });
    }

    // Percorre os botões de idioma para adicionar o evento de clique.
    botoesIdioma.forEach(function (botao) {

        // Identifica quando o usuário seleciona um dos idiomas.
        botao.addEventListener('click', function () {

            // Realiza a troca utilizando o idioma definido
            // no atributo data-idioma do botão.
            trocarIdioma(botao.dataset.idioma);
        });
    });

    // Verifica os dados preenchidos antes de permitir o envio do formulário.
    formulario.addEventListener('submit', function (evento) {

        // Guarda os últimos dados digitados antes de realizar as verificações.
        guardarCampos();

        // Recupera os dados preenchidos na versão em português.
        const portugues = dados.pt;

        // Verifica se o título, a legenda ou o texto em português
        // estão vazios após a remoção dos espaços das extremidades.
        if (
            portugues.titulo.trim() === '' ||
            portugues.legenda.trim() === '' ||
            portugues.texto.trim() === ''
        ) {

            // Impede o envio do formulário caso algum campo obrigatório
            // da versão em português não tenha sido preenchido.
            evento.preventDefault();

            // Exibe um aviso informando quais campos precisam ser preenchidos.
            alert(
                'Preencha o título, a legenda e o texto em português antes de salvar.'
            );

            // Retorna o formulário para a versão em português.
            trocarIdioma('pt');
            return;
        }

        // Percorre os idiomas adicionais para verificar
        // se seus campos foram preenchidos corretamente.
        for (const codigo of ['es', 'wari']) {

            // Recupera os dados do idioma que está sendo verificado.
            const campos = dados[codigo];

            // Verifica se pelo menos um dos três campos foi preenchido.
            const algumPreenchido =
                campos.titulo.trim() !== '' ||
                campos.legenda.trim() !== '' ||
                campos.texto.trim() !== '';

            // Verifica se os três campos foram preenchidos.
            const todosPreenchidos =
                campos.titulo.trim() !== '' &&
                campos.legenda.trim() !== '' &&
                campos.texto.trim() !== '';

            // Se algum campo foi preenchido, mas os outros não,
            // impede o envio do formulário.
            if (algumPreenchido && !todosPreenchidos) {

                // Impede o envio até que os campos sejam corrigidos.
                evento.preventDefault();

                // Informa que a versão no idioma selecionado
                // precisa estar completa ou totalmente vazia.
                alert(
                    'Se quiser cadastrar a versão em ' +
                    idiomas[codigo].nome +
                    ', preencha o título, a legenda e o texto. ' +
                    'Se ainda não tiver essa versão, deixe os três campos vazios.'
                );

                // Direciona o formulário para o idioma que apresentou o erro.
                trocarIdioma(codigo);
                return;
            }
        }

        // Percorre todos os idiomas para transferir os dados armazenados
        // para os campos ocultos do formulário.
        for (const codigo of ['pt', 'es', 'wari']) {

            // Insere o título de cada idioma no seu respectivo campo oculto.
            // O trim() remove os espaços desnecessários das extremidades.
            document.getElementById('titulo_' + codigo).value =
                dados[codigo].titulo.trim();

            // Insere a legenda da imagem no campo oculto correspondente.
            document.getElementById('legenda_' + codigo).value =
                dados[codigo].legenda.trim();

            // Insere o texto da história no campo oculto correspondente.
            document.getElementById('texto_' + codigo).value =
                dados[codigo].texto.trim();
        }
    });

    // Inicia o formulário exibindo os campos em português.
    trocarIdioma('pt');
});