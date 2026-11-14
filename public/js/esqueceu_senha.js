// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener("DOMContentLoaded", function () {

    // Busca os elementos da página que serão utilizados.
    const formulario = document.getElementById("form-esqueceu-senha");
    const email = document.getElementById("email");
    const erroEmail = document.getElementById("erro-email");
    const botao = document.getElementById("botao-enviar");

    // Função que verifica se o e-mail possui um formato válido.
    // A expressão também permite caracteres como _, %, + e -.
    function emailValido(valor) {
        return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(valor);
    }

    // Verifica o conteúdo do campo sempre que o usuário digitar.
    email.addEventListener("input", function () {

        // Guarda a posição atual do cursor no campo.
        const inicio = this.selectionStart;

        // Remove os caracteres que não são permitidos no campo de e-mail.
        this.value = this.value.replace(/[^a-zA-Z0-9.@_%+-]/g, "");

        // Mantém o cursor na posição correta após a remoção dos caracteres.
        if (inicio !== null) {
            const posicao = Math.min(inicio, this.value.length);
            this.setSelectionRange(posicao, posicao);
        }

        // Verifica se o campo foi preenchido e se o e-mail é válido.
        if (this.value && !emailValido(this.value)) {

            // Exibe uma mensagem caso o formato do e-mail esteja incorreto.
            erroEmail.textContent =
                "Digite um e-mail válido. Exemplo: nome@email.com";
        } else {

            // Limpa a mensagem quando o campo estiver vazio
            // ou quando o e-mail estiver em um formato válido.
            erroEmail.textContent = "";
        }
    });

    // Verifica os dados antes de permitir o envio do formulário.
    formulario.addEventListener("submit", function (evento) {

        // Impede o envio caso o e-mail não tenha um formato válido.
        if (!emailValido(email.value)) {
            evento.preventDefault();

            // Exibe uma mensagem informando o formato esperado.
            erroEmail.textContent =
                "Digite um e-mail válido. Exemplo: nome@email.com";

            // Coloca o cursor novamente no campo de e-mail.
            email.focus();

            // Encerra a execução caso o e-mail seja inválido.
            return;
        }

        // Desativa o botão para evitar vários cliques durante o envio.
        // Também altera o texto para informar que o e-mail está sendo enviado.
        botao.disabled = true;
        botao.textContent = "Enviando...";
    });

    // Identifica quando o usuário retorna à página pelo botão "voltar"
    // do navegador.
    window.addEventListener("pageshow", function (evento) {

        // Verifica se a página foi recuperada do histórico do navegador.
        if (evento.persisted) {

            // Reativa o botão de envio.
            botao.disabled = false;

            // Restaura o texto original do botão.
            botao.textContent = "Enviar";
        }
    });
});