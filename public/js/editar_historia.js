// Aguarda o carregamento completo da página antes de executar o código.
document.addEventListener('DOMContentLoaded', function () {

    // Localiza o formulário utilizado para editar a história.
    const formulario = document.getElementById('formEditarHistoria');

    // Localiza o campo utilizado para selecionar o idioma da história.
    const seletorIdioma = document.getElementById('lingua');

    // Localiza os campos de título, legenda e texto da história.
    const campoTitulo = document.getElementById('titulo');
    const campoLegenda = document.getElementById('legenda');
    const campoTexto = document.getElementById('texto');

    // Localiza os textos que identificam cada campo do formulário.
    const labelTitulo = document.getElementById('labelTitulo');
    const labelLegenda = document.getElementById('labelLegenda');
    const labelTexto = document.getElementById('labelTexto');

    // Localiza o botão utilizado para substituir a imagem.
    const btnSubstituir = document.getElementById('btnSubstituir');

    // Localiza o campo responsável pelo envio da nova imagem.
    const campoImagem = document.getElementById('imagem');

    // Localiza o elemento que apresenta a pré-visualização da imagem.
    const imagemPreview = document.getElementById('imagemPreview');

    // Armazena os nomes dos idiomas e os textos que aparecem como sugestão nos campos.
    const idiomas = {

        // Configurações dos campos em português.
        pt: {
            nome: 'Português',
            titulo: 'Título da história...',
            legenda: 'Legenda da imagem...',
            texto: 'Texto da história...'
        },

        // Configurações dos campos em espanhol.
        es: {
            nome: 'Espanhol',
            titulo: 'Título de la historia...',
            legenda: 'Leyenda de la imagen...',
            texto: 'Texto de la historia...'
        },

        // Configurações dos campos em Wari' Oro Nao.
        wari: {
            nome: "Wari' Oro Nao",
            titulo: "Título em Wari' Oro Nao...",
            legenda: "Legenda da imagem em Wari' Oro Nao...",
            texto: "Texto da história em Wari' Oro Nao..."
        }
    };

    // Define os códigos dos idiomas disponíveis no sistema.
    const codigos = ['pt', 'es', 'wari'];

    // Cria um objeto que armazenará os dados de cada idioma.
    const dados = {};

    // Guarda o idioma que está sendo editado no momento.
    let idiomaAtual = null;

    // Percorre todos os idiomas disponíveis para carregar seus dados iniciais.
    codigos.forEach(function (codigo) {

        // Busca os valores dos campos de cada idioma e armazena no objeto dados.
        dados[codigo] = {
            titulo: document.getElementById('titulo_' + codigo).value,
            legenda: document.getElementById('legenda_' + codigo).value,
            texto: document.getElementById('texto_' + codigo).value
        };
    });

    // Função responsável por guardar os dados preenchidos no idioma atual.
    function guardarCampos() {

        // Interrompe a função caso nenhum idioma esteja selecionado.
        if (idiomaAtual === null) {
            return;
        }

        // Atualiza os dados do idioma atual com os valores digitados nos campos.
        dados[idiomaAtual].titulo = campoTitulo.value;
        dados[idiomaAtual].legenda = campoLegenda.value;
        dados[idiomaAtual].texto = campoTexto.value;
    }

    // Função responsável por trocar o idioma exibido no formulário.
    function trocarIdioma(novoIdioma) {

        // Verifica se o idioma selecionado existe nas configurações disponíveis.
        if (!idiomas[novoIdioma]) {
            return;
        }

        // Guarda os dados do idioma anterior antes de realizar a troca.
        guardarCampos();

        // Atualiza a variável com o novo idioma selecionado.
        idiomaAtual = novoIdioma;

        // Preenche os campos com os dados armazenados no idioma escolhido.
        campoTitulo.value = dados[novoIdioma].titulo;
        campoLegenda.value = dados[novoIdioma].legenda;
        campoTexto.value = dados[novoIdioma].texto;

        // Atualiza os títulos dos campos conforme o idioma selecionado.
        labelTitulo.textContent = 'Título (' + idiomas[novoIdioma].nome + ')';
        labelLegenda.textContent = 'Legenda da imagem (' + idiomas[novoIdioma].nome + ')';
        labelTexto.textContent = 'Texto (' + idiomas[novoIdioma].nome + ')';

        // Atualiza os textos de orientação exibidos dentro dos campos vazios.
        campoTitulo.placeholder = idiomas[novoIdioma].titulo;
        campoLegenda.placeholder = idiomas[novoIdioma].legenda;
        campoTexto.placeholder = idiomas[novoIdioma].texto;

        // Define os campos em português como obrigatórios.
        campoTitulo.required = novoIdioma === 'pt';
        campoLegenda.required = novoIdioma === 'pt';
        campoTexto.required = novoIdioma === 'pt';

        // Atualiza o seletor para mostrar o idioma que está sendo editado.
        seletorIdioma.value = novoIdioma;
    }

    // Executa a troca de idioma quando o usuário seleciona outra opção.
    seletorIdioma.addEventListener('change', function () {

        // Envia o idioma selecionado para a função responsável pela troca.
        trocarIdioma(seletorIdioma.value);
    });

    // Permite abrir o campo de seleção de imagem ao clicar no botão de substituir.
    btnSubstituir.addEventListener('click', function () {

        // Simula um clique no campo de seleção de arquivo.
        campoImagem.click();
    });

    // Executa uma ação quando o usuário seleciona uma nova imagem.
    campoImagem.addEventListener('change', function () {

        // Obtém o arquivo de imagem selecionado.
        const arquivo = campoImagem.files[0];

        // Verifica se algum arquivo foi selecionado.
        if (arquivo) {

            // Cria um endereço temporário para exibir a imagem na pré-visualização.
            imagemPreview.src = URL.createObjectURL(arquivo);
        }
    });

    // Realiza as validações antes de enviar o formulário.
    formulario.addEventListener('submit', function (evento) {

        // Guarda os últimos dados digitados antes de iniciar as verificações.
        guardarCampos();

        // Percorre todos os idiomas para verificar se os campos foram preenchidos corretamente.
        for (const codigo of codigos) {

            // Obtém os dados correspondentes ao idioma analisado.
            const campos = dados[codigo];

            // Verifica se pelo menos um dos três campos possui conteúdo.
            const algumPreenchido =
                campos.titulo.trim() !== '' ||
                campos.legenda.trim() !== '' ||
                campos.texto.trim() !== '';

            // Verifica se os três campos estão preenchidos.
            const todosPreenchidos =
                campos.titulo.trim() !== '' &&
                campos.legenda.trim() !== '' &&
                campos.texto.trim() !== '';

            // Verifica se todos os campos obrigatórios em português foram preenchidos.
            if (codigo === 'pt' && !todosPreenchidos) {

                // Impede o envio do formulário caso algum campo esteja vazio.
                evento.preventDefault();

                // Informa ao usuário quais informações precisam ser preenchidas.
                alert('Preencha o título, a legenda e o texto em português.');

                // Retorna o formulário para o idioma português.
                trocarIdioma('pt');
                return;
            }

            // Verifica se algum campo de outro idioma foi preenchido, mas os três não foram completados.
            if (codigo !== 'pt' && algumPreenchido && !todosPreenchidos) {

                // Impede o envio do formulário.
                evento.preventDefault();

                // Informa que todos os campos do idioma precisam ser preenchidos ou deixados vazios.
                alert('Preencha todos os campos de ' + idiomas[codigo].nome + ' ou deixe os três vazios.');

                // Retorna o formulário para o idioma que apresenta o preenchimento incompleto.
                trocarIdioma(codigo);
                return;
            }
        }

        // Percorre novamente os idiomas para atualizar os campos que serão enviados ao servidor.
        codigos.forEach(function (codigo) {

            // Copia os dados armazenados para os campos correspondentes de cada idioma.
            // Remove os espaços extras do início e do final dos textos.
            document.getElementById('titulo_' + codigo).value = dados[codigo].titulo.trim();
            document.getElementById('legenda_' + codigo).value = dados[codigo].legenda.trim();
            document.getElementById('texto_' + codigo).value = dados[codigo].texto.trim();
        });
    });

    // Inicia o formulário exibindo os campos no idioma português.
    trocarIdioma('pt');
});