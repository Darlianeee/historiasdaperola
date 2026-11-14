// Valida os campos de e-mail e senha antes de enviar o formulário ao servidor.

// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener("DOMContentLoaded", function () {

    // Busca os elementos do formulário de login.
    const formulario = document.getElementById("form-login");
    const email = document.getElementById("email");
    const senha = document.getElementById("senha");
    const erroEmail = document.getElementById("erro-email");
    const erroSenha = document.getElementById("erro-senha");

    // Busca os elementos responsáveis por mostrar e ocultar a senha.
    const mostrarSenha = document.getElementById("mostrar-senha");
    const riscoOlho = document.getElementById("olho-risco");

    // Verifica se todos os elementos necessários para essa funcionalidade existem.
    if (mostrarSenha && riscoOlho && senha) {

        // Identifica quando o usuário clica no botão de visualizar senha.
        mostrarSenha.addEventListener("click", function () {

            // Verifica se a senha está atualmente oculta.
            const mostrar = senha.type === "password";

            // Altera o tipo do campo para mostrar ou ocultar a senha.
            senha.type = mostrar ? "text" : "password";

            // Exibe ou oculta o risco sobre o ícone do olho.
            riscoOlho.style.display = mostrar ? "block" : "none";

            // Atualiza a descrição do botão para melhorar a acessibilidade.
            mostrarSenha.setAttribute(
                "aria-label",
                mostrar ? "Ocultar senha" : "Mostrar senha"
            );
        });
    }

    // Função responsável por verificar se o e-mail possui um formato válido.
    function emailValido(valor) {
        return /^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,}$/.test(valor);
    }

    // Verifica o conteúdo do campo de e-mail sempre que o usuário digitar.
    email.addEventListener("input", function () {

        // Remove os caracteres que não são permitidos no campo de e-mail.
        this.value = this.value.replace(/[^a-zA-Z0-9.@]/g, "");

        // Verifica se o campo foi preenchido e se o e-mail possui um formato válido.
        if (this.value && !emailValido(this.value)) {

            // Exibe uma mensagem informando o formato esperado.
            erroEmail.textContent =
                "Digite um e-mail válido. Exemplo: nome@email.com";
        } else {

            // Remove a mensagem de erro quando o e-mail estiver válido
            // ou quando o campo estiver vazio.
            erroEmail.textContent = "";
        }
    });

    // Verifica o tamanho da senha sempre que o usuário digitar.
    senha.addEventListener("input", function () {

        // Verifica se a senha possui menos de 8 caracteres.
        if (this.value.length < 8) {

            // Exibe uma mensagem informando o tamanho mínimo necessário.
            erroSenha.textContent =
                "A senha precisa ter pelo menos 8 caracteres.";
        } else {

            // Remove a mensagem quando a senha atingir o tamanho mínimo.
            erroSenha.textContent = "";
        }
    });

    // Verifica os campos antes de permitir o envio do formulário.
    formulario.addEventListener("submit", function (evento) {

        // Inicialmente, considera que os campos estão válidos.
        let valido = true;

        // Verifica novamente se o e-mail possui um formato válido.
        if (!emailValido(email.value)) {

            // Exibe uma mensagem caso o e-mail esteja incorreto.
            erroEmail.textContent = "Digite um e-mail válido.";

            // Indica que existe um campo preenchido incorretamente.
            valido = false;
        }

        // Verifica se a senha possui pelo menos 8 caracteres.
        if (senha.value.length < 8) {

            // Exibe uma mensagem caso a senha não atinja o tamanho mínimo.
            erroSenha.textContent =
                "A senha precisa ter pelo menos 8 caracteres.";

            // Indica que existe um campo preenchido incorretamente.
            valido = false;
        }

        // Verifica se algum dos campos apresentou erro.
        if (!valido) {

            // Impede o envio do formulário caso os dados sejam inválidos.
            evento.preventDefault();
        }
    });
});