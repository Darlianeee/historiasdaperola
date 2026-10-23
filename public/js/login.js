document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("form-login");
    const email = document.getElementById("email");
    const senha = document.getElementById("senha");
    const erroEmail = document.getElementById("erro-email");
    const erroSenha = document.getElementById("erro-senha");

    function emailValido(valor) {
        return /^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,}$/.test(valor);
    }

    email.addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-Z0-9.@]/g, "");

        if (this.value && !emailValido(this.value)) {
            erroEmail.textContent =
                "Digite um e-mail válido. Exemplo: nome@email.com";
        } else {
            erroEmail.textContent = "";
        }
    });

    senha.addEventListener("input", function () {
        if (this.value.length < 8) {
            erroSenha.textContent =
                "A senha precisa ter pelo menos 8 caracteres.";
        } else {
            erroSenha.textContent = "";
        }
    });

    formulario.addEventListener("submit", function (evento) {
        let valido = true;

        if (!emailValido(email.value)) {
            erroEmail.textContent = "Digite um e-mail válido.";
            valido = false;
        }

        if (senha.value.length < 8) {
            erroSenha.textContent =
                "A senha precisa ter pelo menos 8 caracteres.";
            valido = false;
        }

        if (!valido) {
            evento.preventDefault();
        }
    });
});