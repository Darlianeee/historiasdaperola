// Cria uma função que é executada imediatamente para organizar o código e evitar conflitos com outras variáveis.
(function () {

    // Ativa o modo estrito do JavaScript, ajudando a evitar erros na execução do código.
    "use strict";

    // Define o nome utilizado para identificar as configurações salvas no armazenamento do navegador.
    const CHAVE = "acessibilidade";

    // Define as configurações padrão que serão utilizadas inicialmente ou quando as preferências forem restauradas.
    const padrao = {
        tema: "claro",
        fonte: "normal",
        contraste: false
    };

    // Função responsável por carregar as configurações salvas no navegador.
    function carregar() {
        try {

            // Busca as configurações armazenadas e transforma os dados em um objeto JavaScript.
            const dados = JSON.parse(localStorage.getItem(CHAVE));

            // Verifica se existem configurações salvas e se os dados estão em um formato válido.
            if (!dados || typeof dados !== "object") {
                return { ...padrao };
            }

            // Retorna as configurações, verificando se cada valor é permitido pelo sistema.
            return {
                // Verifica se o tema salvo é claro ou escuro. Caso contrário, utiliza o tema padrão.
                tema: ["claro", "escuro"].includes(dados.tema)
                    ? dados.tema : padrao.tema,

                // Verifica se o tamanho da fonte está entre as opções disponíveis.
                fonte: ["normal", "grande", "muito-grande"].includes(dados.fonte)
                    ? dados.fonte : padrao.fonte,

                // Verifica se o alto contraste está ativado.
                contraste: dados.contraste === true
            };

        // Caso ocorra algum erro ao carregar os dados, utiliza as configurações padrão.
        } catch (erro) {
            return { ...padrao };
        }
    }

    // Carrega as configurações do navegador e armazena os valores na variável config.
    let config = carregar();

    // Função responsável por salvar as configurações atuais no navegador.
    function salvar() {
        try {

            // Transforma as configurações em texto JSON e armazena no localStorage.
            localStorage.setItem(CHAVE, JSON.stringify(config));

        // Exibe uma mensagem no console caso não seja possível salvar as configurações.
        } catch (erro) {
            console.error("Não foi possível salvar as configurações.", erro);
        }
    }

    // Função que aplica as configurações selecionadas na página.
    function aplicar() {

        // Acessa o elemento principal do documento HTML.
        const html = document.documentElement;

        // Adiciona ou remove a classe responsável pelo tema escuro.
        html.classList.toggle(
            "acessibilidade-escuro",
            config.tema === "escuro"
        );

        // Adiciona ou remove a classe responsável pelo alto contraste.
        html.classList.toggle(
            "acessibilidade-alto-contraste",
            config.contraste
        );

        // Remove as classes anteriores de tamanho de fonte para evitar que mais de uma fique ativa.
        html.classList.remove(
            "acessibilidade-fonte-normal",
            "acessibilidade-fonte-grande",
            "acessibilidade-fonte-muito-grande"
        );

        // Adiciona a classe correspondente ao tamanho de fonte selecionado.
        html.classList.add("acessibilidade-fonte-" + config.fonte);

        // Localiza todos os botões responsáveis pela alteração do tema.
        document.querySelectorAll("[data-acessibilidade-tema]").forEach(function (botao) {

            // Atualiza o atributo aria-pressed para indicar qual tema está selecionado.
            botao.setAttribute(
                "aria-pressed",
                String(botao.dataset.acessibilidadeTema === config.tema)
            );
        });

        // Localiza todos os botões responsáveis pela alteração do tamanho da fonte.
        document.querySelectorAll("[data-acessibilidade-fonte]").forEach(function (botao) {

            // Indica qual tamanho de fonte está selecionado.
            botao.setAttribute(
                "aria-pressed",
                String(botao.dataset.acessibilidadeFonte === config.fonte)
            );
        });

        // Localiza os botões responsáveis pelo alto contraste.
        document.querySelectorAll("[data-acessibilidade-contraste]").forEach(function (botao) {

            // Atualiza o atributo para indicar se o alto contraste está ativado ou desativado.
            botao.setAttribute("aria-pressed", String(config.contraste));
        });
    }

    // Função responsável por alterar o tema da página.
    function definirTema(tema) {

        // Verifica se o tema informado corresponde a uma das opções disponíveis.
        if (!["claro", "escuro"].includes(tema)) return;

        // Atualiza o tema selecionado.
        config.tema = tema;

        // Salva a alteração no navegador.
        salvar();

        // Aplica o novo tema na página.
        aplicar();
    }

    // Função responsável por alterar o tamanho da fonte.
    function definirFonte(fonte) {

        // Verifica se o tamanho informado está entre as opções permitidas.
        if (!["normal", "grande", "muito-grande"].includes(fonte)) return;

        // Atualiza o tamanho da fonte selecionado.
        config.fonte = fonte;

        // Salva a alteração no navegador.
        salvar();

        // Aplica o novo tamanho de fonte na página.
        aplicar();
    }

    // Função que ativa ou desativa o alto contraste.
    function alternarContraste() {

        // Inverte o valor atual do contraste, ativando ou desativando o recurso.
        config.contraste = !config.contraste;

        // Salva a alteração no navegador.
        salvar();

        // Aplica a configuração atualizada na página.
        aplicar();
    }

    // Função responsável por restaurar todas as configurações para os valores iniciais.
    function restaurar() {

        // Substitui as configurações atuais pelas configurações padrão.
        config = { ...padrao };

        // Salva as configurações restauradas.
        salvar();

        // Aplica as configurações padrão na página.
        aplicar();
    }

    // Adiciona um evento que identifica os cliques realizados na página.
    document.addEventListener("click", function (evento) {

        // Identifica o elemento que recebeu o clique.
        const alvo = evento.target;

        // Verifica se o elemento clicado pertence a um elemento HTML.
        if (!(alvo instanceof Element)) return;

        // Identifica se o clique aconteceu em um botão de alteração do tema.
        const tema = alvo.closest("[data-acessibilidade-tema]");

        // Identifica se o clique aconteceu em um botão de alteração da fonte.
        const fonte = alvo.closest("[data-acessibilidade-fonte]");

        // Identifica se o clique aconteceu em um botão de alto contraste.
        const contraste = alvo.closest("[data-acessibilidade-contraste]");

        // Identifica se o clique aconteceu no botão de restaurar as configurações.
        const restaurarBotao = alvo.closest("[data-acessibilidade-restaurar]");

        // Verifica se foi selecionada alguma opção de tema.
        if (tema) {

            // Altera o tema conforme a opção selecionada.
            definirTema(tema.dataset.acessibilidadeTema);
            return;
        }

        // Verifica se foi selecionada alguma opção de tamanho de fonte.
        if (fonte) {

            // Altera o tamanho da fonte conforme a opção selecionada.
            definirFonte(fonte.dataset.acessibilidadeFonte);
            return;
        }

        // Verifica se o botão de alto contraste foi selecionado.
        if (contraste) {

            // Ativa ou desativa o alto contraste.
            alternarContraste();
            return;
        }

        // Verifica se o botão de restaurar as configurações foi selecionado.
        if (restaurarBotao) {

            // Retorna todas as configurações aos valores padrão.
            restaurar();
            return;
        }

        // Compatibilidade com botões que utilizam IDs.

        // Identifica o ID do botão ou link clicado.
        const id = alvo.closest("button, a, input")?.id;

        // Relaciona cada ID à função correspondente.
        const botoes = {

            // Seleciona o tema claro.
            "tema-claro": () => definirTema("claro"),

            // Seleciona o tema escuro.
            "tema-escuro": () => definirTema("escuro"),

            // Seleciona o tamanho normal da fonte.
            "fonte-normal": () => definirFonte("normal"),

            // Seleciona o tamanho grande da fonte.
            "fonte-grande": () => definirFonte("grande"),

            // Seleciona o tamanho muito grande da fonte.
            "fonte-muito-grande": () => definirFonte("muito-grande"),

            // Ativa ou desativa o alto contraste.
            "alto-contraste": alternarContraste,

            // Restaura todas as configurações de acessibilidade.
            "restaurar-acessibilidade": restaurar
        };

        // Verifica se o ID corresponde a alguma das opções disponíveis.
        if (id && botoes[id]) {

            // Impede o comportamento padrão do elemento, quando necessário.
            evento.preventDefault();

            // Executa a função correspondente ao botão selecionado.
            botoes[id]();
        }
    });

    // Disponibiliza as funções de acessibilidade para serem utilizadas em outras partes do sistema.
    window.Acessibilidade = {

        // Permite alterar o tema por meio de outra parte do sistema.
        definirTema: definirTema,

        // Permite alterar o tamanho da fonte.
        definirFonte: definirFonte,

        // Permite ativar ou desativar o alto contraste.
        alternarContraste: alternarContraste,

        // Permite restaurar as configurações padrão.
        restaurarConfiguracoes: restaurar,

        // Permite aplicar novamente as configurações atuais.
        aplicarConfiguracoes: aplicar
    };

    // Aplica as configurações carregadas assim que o arquivo é executado.
    aplicar();

})();