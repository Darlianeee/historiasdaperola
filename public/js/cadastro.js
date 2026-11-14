// Aguarda o carregamento completo da página antes de executar o código.
document.addEventListener("DOMContentLoaded", function () {

    // Localiza o formulário e os campos utilizados no cadastro.
    const formulario = document.getElementById("form-cadastro");
    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const senha = document.getElementById("senha");

    // Localiza os elementos onde serão exibidas as mensagens de erro.
    const erroNome = document.getElementById("erro-nome");
    const erroEmail = document.getElementById("erro-email");
    const erroSenha = document.getElementById("erro-senha");

    // Função que verifica se o e-mail possui um formato válido.
    function emailValido(valor) {
        return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(valor);
    }

    // Função que verifica se o nome possui pelo menos 2 caracteres e contém apenas letras, espaços, apóstrofos ou hífens.
    function nomeValido(valor) {
        return /^[a-zA-ZÀ-ÿ\s'-]+$/.test(valor.trim())
            && valor.trim().length >= 2;
    }

    // Validação da senha
    // Função que verifica se a senha possui letras, números e símbolos.
    function validarSenha(valor) {

        // Verifica se existe pelo menos uma letra.
        const temLetra = /[a-zA-ZÀ-ÿ]/.test(valor);

        // Verifica se existe pelo menos um número.
        const temNumero = /[0-9]/.test(valor);

        // Verifica se existe pelo menos um símbolo.
        const temSimbolo = /[^a-zA-Z0-9À-ÿ\s]/.test(valor);

        // Verifica se a senha não possui nenhum dos três tipos de caracteres.
        if (!temLetra && !temNumero && !temSimbolo) {
            return "Adicione letras, números e símbolos.";
        }

        // Verifica se estão faltando letras e números.
        if (!temLetra && !temNumero) {
            return "Adicione letras e números.";
        }

        // Verifica se estão faltando letras e símbolos.
        if (!temLetra && !temSimbolo) {
            return "Adicione letras e símbolos.";
        }

        // Verifica se estão faltando números e símbolos.
        if (!temNumero && !temSimbolo) {
            return "Adicione números e símbolos.";
        }

        // Verifica se a senha não possui letras.
        if (!temLetra) {
            return "Adicione letras.";
        }

        // Verifica se a senha não possui números.
        if (!temNumero) {
            return "Adicione números.";
        }

        // Verifica se a senha não possui símbolos.
        if (!temSimbolo) {
            return "A senha deve ter pelo menos um símbolo.";
        }

        // Retorna uma mensagem vazia quando todos os requisitos são atendidos.
        return "";
    }

    // Validação do nome
    // Verifica o nome sempre que o usuário digitar ou apagar algum caractere.
    nome.addEventListener("input", function () {

        // Limpa a mensagem quando o campo estiver vazio.
        if (!this.value.trim()) {
            erroNome.textContent = "";

        // Exibe uma mensagem caso o nome não atenda aos requisitos.
        } else if (!nomeValido(this.value)) {
            erroNome.textContent =
                "Digite um nome com pelo menos 2 caracteres, usando apenas letras.";

        // Remove a mensagem quando o nome estiver válido.
        } else {
            erroNome.textContent = "";
        }
    });

    // Validação do e-mail
    // Verifica o e-mail sempre que o usuário digitar ou alterar seu conteúdo.
    email.addEventListener("input", function () {

        // Guarda a posição atual do cursor no campo.
        const inicio = this.selectionStart;

        // Remove caracteres que não são permitidos no endereço de e-mail.
        this.value = this.value.replace(/[^a-zA-Z0-9.@_%+-]/g, "");

        // Mantém o cursor na posição correta após a remoção dos caracteres.
        if (inicio !== null) {
            const posicao = Math.min(inicio, this.value.length);
            this.setSelectionRange(posicao, posicao);
        }

        // Limpa a mensagem quando o campo estiver vazio.
        if (!this.value) {
            erroEmail.textContent = "";

        // Exibe uma mensagem caso o formato do e-mail seja inválido.
        } else if (!emailValido(this.value)) {
            erroEmail.textContent =
                "E-mail inválido. Digite novamente.";

        // Remove a mensagem quando o e-mail estiver válido.
        } else {
            erroEmail.textContent = "";
        }
    });

    // Validação da senha enquanto digita
    // Verifica os requisitos da senha conforme o usuário preenche o campo.
    senha.addEventListener("input", function () {

        // Limpa a mensagem quando o campo estiver vazio.
        if (this.value.length === 0) {
            erroSenha.textContent = "";

        // Verifica se a senha possui menos de 8 caracteres.
        } else if (this.value.length < 8) {
            erroSenha.textContent =
                "A senha precisa ter pelo menos 8 caracteres.";

        // Verifica se a senha ultrapassa o limite de 30 caracteres.
        } else if (this.value.length > 30) {
            erroSenha.textContent =
                "A senha deve ter no máximo 30 caracteres.";

        // Verifica se a senha possui letras, números e símbolos.
        } else {
            erroSenha.textContent = validarSenha(this.value);
        }
    });

    // Mostrar e ocultar senha

    // Localiza o botão de visualização da senha e o risco do ícone do olho.
    const mostrarSenha = document.getElementById("mostrar-senha");
    const riscoOlho = document.getElementById("olho-risco");

    // Verifica se os elementos necessários existem na página.
    if (senha && mostrarSenha && riscoOlho) {

        // Adiciona um evento para mostrar ou ocultar a senha ao clicar no botão.
        mostrarSenha.addEventListener("click", function () {

            // Verifica se a senha está atualmente oculta.
            const mostrar = senha.type === "password";

            // Alterna o campo entre senha oculta e texto visível.
            senha.type = mostrar ? "text" : "password";

            // Altera a exibição do risco sobre o ícone do olho.
            riscoOlho.style.display = mostrar ? "block" : "none";

            // Atualiza a descrição do botão para acessibilidade.
            mostrarSenha.setAttribute(
                "aria-label",
                mostrar ? "Ocultar senha" : "Mostrar senha"
            );
        });
    }

    // Validação antes de enviar o formulário

    // Verifica todos os campos novamente quando o usuário tenta concluir o cadastro.
    formulario.addEventListener("submit", function (evento) {

        // Variável que indica se todos os campos estão válidos.
        let valido = true;

        // Verifica se o nome atende aos requisitos.
        if (!nomeValido(nome.value)) {
            erroNome.textContent =
                "Digite um nome com pelo menos 2 caracteres, usando apenas letras.";
            valido = false;
        } else {
            erroNome.textContent = "";
        }

        // Verifica se o e-mail possui um formato válido.
        if (!emailValido(email.value)) {
            erroEmail.textContent =
                "E-mail inválido. Digite novamente.";
            valido = false;
        } else {
            erroEmail.textContent = "";
        }

        // Verifica se a senha possui entre 8 e 30 caracteres.
        if (senha.value.length < 8 || senha.value.length > 30) {
            erroSenha.textContent =
                "A senha precisa ter entre 8 e 30 caracteres.";
            valido = false;
        } else {

            // Verifica se a senha também possui letras, números e símbolos.
            erroSenha.textContent = validarSenha(senha.value);

            // Impede o envio caso algum requisito da senha não seja atendido.
            if (erroSenha.textContent !== "") {
                valido = false;
            }
        }

        // Impede o envio do formulário caso algum campo seja inválido.
        if (!valido) {
            evento.preventDefault();
        }
    });
});