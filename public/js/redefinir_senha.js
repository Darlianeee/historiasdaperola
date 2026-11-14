document.addEventListener("DOMContentLoaded", function () {

    // Busca os elementos do formulário e os campos de senha.
    const formulario = document.getElementById("form-redefinir-senha");
    const nova = document.getElementById("nova_senha");
    const confirmar = document.getElementById("confirmar_senha");

    // Busca os espaços onde serão exibidas as mensagens de erro.
    const erroNova = document.getElementById("erro-nova-senha");
    const erroConfirmar = document.getElementById("erro-confirmar-senha");

    // Verifica se a nova senha possui pelo menos 8 caracteres.
    function conferirNova() {
        if (nova.value.length > 0 && nova.value.length < 8) {
            erroNova.textContent = "A senha precisa ter pelo menos 8 caracteres.";
            return false;
        }

        // Limpa a mensagem de erro quando a senha atende ao tamanho mínimo.
        erroNova.textContent = "";
        return nova.value.length >= 8;
    }

    // Verifica se a confirmação é igual à nova senha.
    function conferirConfirmacao() {
        if (confirmar.value.length > 0 && confirmar.value !== nova.value) {
            erroConfirmar.textContent = "As senhas não são iguais.";
            return false;
        }

        // Limpa a mensagem de erro quando as senhas são iguais.
        erroConfirmar.textContent = "";
        return confirmar.value === nova.value;
    }

    // Verifica a nova senha sempre que o usuário digita ou altera seu conteúdo.
    nova.addEventListener("input", function () {
        conferirNova();
        conferirConfirmacao();
    });

    // Verifica a confirmação sempre que o usuário digita ou altera seu conteúdo.
    confirmar.addEventListener("input", conferirConfirmacao);

    // Realiza as validações antes de permitir o envio do formulário.
    formulario.addEventListener("submit", function (evento) {
        const novaOk = conferirNova();
        const confirmarOk = conferirConfirmacao();

        // Impede o envio caso alguma das senhas não esteja correta.
        if (!novaOk || !confirmarOk) {
            evento.preventDefault();

            // Direciona o cursor para o primeiro campo que precisa ser corrigido.
            if (!novaOk) {
                nova.focus();
            } else {
                confirmar.focus();
            }
        }
    });
});