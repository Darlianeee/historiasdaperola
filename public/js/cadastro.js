document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("form-cadastro");
    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const senha = document.getElementById("senha");

    const erroNome = document.getElementById("erro-nome");
    const erroEmail = document.getElementById("erro-email");
    const erroSenha = document.getElementById("erro-senha");

    function emailValido(valor) {
        return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(valor);
    }

    function nomeValido(valor) {
        return /^[a-zA-ZÀ-ÿ\s'-]+$/.test(valor.trim())
            && valor.trim().length >= 2;
    }

    // Validação da senha
    function validarSenha(valor) {
        const temLetra = /[a-zA-ZÀ-ÿ]/.test(valor);
        const temNumero = /[0-9]/.test(valor);
        const temSimbolo = /[^a-zA-Z0-9À-ÿ\s]/.test(valor);

        if (!temLetra && !temNumero && !temSimbolo) {
            return "Adicione letras, números e símbolos.";
        }

        if (!temLetra && !temNumero) {
            return "Adicione letras e números.";
        }

        if (!temLetra && !temSimbolo) {
            return "Adicione letras e símbolos.";
        }

        if (!temNumero && !temSimbolo) {
            return "Adicione números e símbolos.";
        }

        if (!temLetra) {
            return "Adicione letras.";
        }

        if (!temNumero) {
            return "Adicione números.";
        }

        if (!temSimbolo) {
            return "A senha deve ter pelo menos um símbolo.";
        }

        return "";
    }

    // Validação do nome
    nome.addEventListener("input", function () {
        if (!this.value.trim()) {
            erroNome.textContent = "";
        } else if (!nomeValido(this.value)) {
            erroNome.textContent =
                "Digite um nome com pelo menos 2 caracteres, usando apenas letras.";
        } else {
            erroNome.textContent = "";
        }
    });

    // Validação do e-mail
    email.addEventListener("input", function () {
        const inicio = this.selectionStart;

        this.value = this.value.replace(/[^a-zA-Z0-9.@_%+-]/g, "");

        if (inicio !== null) {
            const posicao = Math.min(inicio, this.value.length);
            this.setSelectionRange(posicao, posicao);
        }

        if (!this.value) {
            erroEmail.textContent = "";
        } else if (!emailValido(this.value)) {
            erroEmail.textContent =
                "E-mail inválido. Digite novamente.";
        } else {
            erroEmail.textContent = "";
        }
    });

    // Validação da senha enquanto digita
    senha.addEventListener("input", function () {
        if (this.value.length === 0) {
            erroSenha.textContent = "";
        } else if (this.value.length < 8) {
            erroSenha.textContent =
                "A senha precisa ter pelo menos 8 caracteres.";
        } else if (this.value.length > 30) {
            erroSenha.textContent =
                "A senha deve ter no máximo 30 caracteres.";
        } else {
            erroSenha.textContent = validarSenha(this.value);
        }
    });

    // Mostrar e ocultar senha
    const mostrarSenha = document.getElementById("mostrar-senha");
    const riscoOlho = document.getElementById("olho-risco");

    if (senha && mostrarSenha && riscoOlho) {
        mostrarSenha.addEventListener("click", function () {
            const mostrar = senha.type === "password";

            senha.type = mostrar ? "text" : "password";
            riscoOlho.style.display = mostrar ? "block" : "none";

            mostrarSenha.setAttribute(
                "aria-label",
                mostrar ? "Ocultar senha" : "Mostrar senha"
            );
        });
    }

    // Validação antes de enviar o formulário
    formulario.addEventListener("submit", function (evento) {
        let valido = true;

        if (!nomeValido(nome.value)) {
            erroNome.textContent =
                "Digite um nome com pelo menos 2 caracteres, usando apenas letras.";
            valido = false;
        } else {
            erroNome.textContent = "";
        }

        if (!emailValido(email.value)) {
            erroEmail.textContent =
                "E-mail inválido. Digite novamente.";
            valido = false;
        } else {
            erroEmail.textContent = "";
        }

        if (senha.value.length < 8 || senha.value.length > 30) {
            erroSenha.textContent =
                "A senha precisa ter entre 8 e 30 caracteres.";
            valido = false;
        } else {
            erroSenha.textContent = validarSenha(senha.value);

            if (erroSenha.textContent !== "") {
                valido = false;
            }
        }

        if (!valido) {
            evento.preventDefault();
        }
    });
});