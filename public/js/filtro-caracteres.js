
document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.querySelector(
        "#form-login, #form-cadastro, #form-login-adm"
    );

    if (!formulario) return;

    const nome = formulario.querySelector("#nome");
    const email = formulario.querySelector("#email");
    const senha = formulario.querySelector("#senha");

    const erroNome = formulario.querySelector("#erro-nome");
    const erroEmail = formulario.querySelector("#erro-email");
    const erroSenha = formulario.querySelector("#erro-senha");

    function mostrarErro(campoErro, mensagem) {
        if (campoErro) {
            campoErro.textContent = mensagem;
        }
    }

    function nomeValido(valor) {
        return /^[a-zA-ZÀ-ÿ\s'-]+$/.test(valor.trim())
            && valor.trim().length >= 2;
    }

    function emailValido(valor) {
        return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(valor);
    }

    // Validação do nome, apenas na tela de cadastro
    if (nome) {
        nome.addEventListener("input", function () {
            if (!this.value.trim()) {
                mostrarErro(erroNome, "Digite seu nome.");
            } else if (!nomeValido(this.value)) {
                mostrarErro(
                    erroNome,
                    "O nome deve ter pelo menos 2 caracteres e conter apenas letras."
                );
            } else {
                mostrarErro(erroNome, "");
            }
        });
    }

    // Validação do e-mail
    if (email) {
        email.addEventListener("input", function () {
            if (/\s/.test(this.value)) {
                const inicio = this.selectionStart;
                this.value = this.value.replace(/\s/g, "");
                this.setSelectionRange(
                    Math.min(inicio, this.value.length),
                    Math.min(inicio, this.value.length)
                );
            }

            if (!this.value) {
                mostrarErro(erroEmail, "");
            } else if (!emailValido(this.value)) {
                mostrarErro(
                    erroEmail,
                    "Digite um e-mail válido. Exemplo: nome@email.com"
                );
            } else {
                mostrarErro(erroEmail, "");
            }
        });
    }

    // Validação da senha
    if (senha) {
        senha.addEventListener("input", function () {
            if (formulario.id === "form-cadastro") {
                if (this.value.length < 8) {
                    mostrarErro(
                        erroSenha,
                        "A senha precisa ter pelo menos 8 caracteres."
                    );
                } else {
                    mostrarErro(erroSenha, "");
                }
            } else {
                mostrarErro(erroSenha, "");
            }
        });
    }

    // Verificação ao enviar o formulário
    formulario.addEventListener("submit", function (evento) {
        let valido = true;

        if (nome && !nomeValido(nome.value)) {
            mostrarErro(
                erroNome,
                "Digite um nome com pelo menos 2 caracteres, usando apenas letras."
            );
            valido = false;
        }

        if (email && !emailValido(email.value)) {
            mostrarErro(erroEmail, "Digite um e-mail válido.");
            valido = false;
        }

        if (senha && !senha.value.trim()) {
            mostrarErro(erroSenha, "Digite sua senha.");
            valido = false;
        } else if (
            senha &&
            formulario.id === "form-cadastro" &&
            senha.value.length < 8
        ) {
            mostrarErro(
                erroSenha,
                "A senha precisa ter pelo menos 8 caracteres."
            );
            valido = false;
        }

        if (!valido) {
            evento.preventDefault();
        }
    });
});
