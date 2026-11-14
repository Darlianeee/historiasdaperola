// Aguarda o carregamento completo do conteúdo da página antes de executar o código.
document.addEventListener('DOMContentLoaded', function () {

    // Mostrar e ocultar senha
    // Localiza todos os botões responsáveis por mostrar ou ocultar a senha.
    document.querySelectorAll('.password-toggle').forEach(function (button) {

        // Adiciona um evento para executar uma ação quando o botão for clicado.
        button.addEventListener('click', function () {

            // Localiza o campo de senha relacionado ao botão.
            const input = document.getElementById(button.dataset.target);

            // Localiza o elemento responsável pelo risco que aparece sobre o ícone do olho.
            const risco = button.querySelector('.eye-slash');

            // Interrompe a execução caso o campo de senha não seja encontrado.
            if (!input) return;

            // Verifica se a senha está oculta.
            const mostrar = input.type === 'password';

            // Alterna o campo entre senha oculta e texto visível.
            input.type = mostrar ? 'text' : 'password';

            // Atualiza a aparência do ícone conforme a senha é mostrada ou ocultada.
            if (risco) {
                risco.style.display = mostrar ? 'block' : 'none';
            }

            // Atualiza o texto de acessibilidade do botão.
            button.setAttribute(
                'aria-label',
                mostrar ? 'Ocultar senha' : 'Mostrar senha'
            );

            // Atualiza a descrição exibida quando o usuário passa o mouse sobre o botão.
            button.setAttribute(
                'title',
                mostrar ? 'Ocultar senha' : 'Mostrar senha'
            );
        });
    });

    // Campos da alteração de senha

    // Localiza o campo onde o usuário digita a nova senha.
    const senha = document.getElementById('new-password');

    // Localiza o elemento responsável por apresentar as mensagens de erro da senha.
    const erroSenha = document.getElementById('erro-nova-senha');

    // Localiza o formulário de alteração de senha.
    const formulario = document.querySelector('.password-form');

    // Validação da nova senha
    // Função que verifica se a senha atende aos requisitos definidos pelo sistema.
    function validarSenha(valor) {

        // Conta a quantidade de caracteres da senha.
        const tamanho = Array.from(valor).length;

        // Verifica se a senha possui pelo menos uma letra maiúscula.
        const temMaiuscula = /\p{Lu}/u.test(valor);

        // Verifica se a senha possui pelo menos uma letra minúscula.
        const temMinuscula = /\p{Ll}/u.test(valor);

        // Verifica se a senha possui pelo menos um número.
        const temNumero = /\p{N}/u.test(valor);

        // Verifica se a senha possui pelo menos um símbolo.
        const temSimbolo = /[^\p{L}\p{N}]/u.test(valor);

        // Verifica se a senha possui menos de 8 caracteres.
        if (tamanho < 8) {
            return "A senha precisa ter pelo menos 8 caracteres.";
        }

        // Verifica se a senha ultrapassa o limite de 30 caracteres.
        if (tamanho > 30) {
            return "A senha deve ter no máximo 30 caracteres.";
        }

        // Verifica se existe pelo menos uma letra maiúscula.
        if (!temMaiuscula) {
            return "Adicione pelo menos uma letra maiúscula.";
        }

        // Verifica se existe pelo menos uma letra minúscula.
        if (!temMinuscula) {
            return "Adicione pelo menos uma letra minúscula.";
        }

        // Verifica se existe pelo menos um número.
        if (!temNumero) {
            return "Adicione números.";
        }

        // Verifica se existe pelo menos um símbolo.
        if (!temSimbolo) {
            return "A senha deve ter pelo menos um símbolo.";
        }

        // Retorna uma mensagem vazia quando a senha atende a todos os requisitos.
        return "";
    }

    // Mensagens enquanto digita

    // Verifica se o campo de senha e o elemento de mensagem existem na página.
    if (senha && erroSenha) {

        // Executa a validação sempre que o usuário digitar ou apagar algum caractere.
        senha.addEventListener('input', function () {

            // Limpa a mensagem quando o campo estiver vazio.
            if (this.value.length === 0) {
                erroSenha.textContent = "";
            } else {

                // Exibe a mensagem correspondente caso a senha não atenda aos requisitos.
                erroSenha.textContent = validarSenha(this.value);
            }
        });
    }

    // Validação antes de enviar

    // Verifica se todos os elementos necessários para a validação existem.
    if (formulario && senha && erroSenha) {

        // Executa a validação quando o usuário tenta enviar o formulário.
        formulario.addEventListener('submit', function (evento) {

            // Verifica novamente se a senha atende a todos os requisitos.
            erroSenha.textContent = validarSenha(senha.value);

            // Impede o envio do formulário caso exista alguma mensagem de erro.
            if (erroSenha.textContent !== '') {
                evento.preventDefault();
            }
        });
    }

});