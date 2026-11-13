document.addEventListener('DOMContentLoaded', function () {

    // Mostrar e ocultar senha
    document.querySelectorAll('.password-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.target);
            const risco = button.querySelector('.eye-slash');

            if (!input) return;

            const mostrar = input.type === 'password';
            input.type = mostrar ? 'text' : 'password';

            if (risco) {
                risco.style.display = mostrar ? 'block' : 'none';
            }

            button.setAttribute(
                'aria-label',
                mostrar ? 'Ocultar senha' : 'Mostrar senha'
            );

            button.setAttribute(
                'title',
                mostrar ? 'Ocultar senha' : 'Mostrar senha'
            );
        });
    });

    // Campos da alteração de senha
    const senha = document.getElementById('new-password');
    const erroSenha = document.getElementById('erro-nova-senha');
    const formulario = document.querySelector('.password-form');

    // Validação da nova senha
    function validarSenha(valor) {
        const tamanho = Array.from(valor).length;
        const temMaiuscula = /\p{Lu}/u.test(valor);
        const temMinuscula = /\p{Ll}/u.test(valor);
        const temNumero = /\p{N}/u.test(valor);
        const temSimbolo = /[^\p{L}\p{N}]/u.test(valor);

        if (tamanho < 8) {
            return "A senha precisa ter pelo menos 8 caracteres.";
        }

        if (tamanho > 30) {
            return "A senha deve ter no máximo 30 caracteres.";
        }

        if (!temMaiuscula) {
            return "Adicione pelo menos uma letra maiúscula.";
        }

        if (!temMinuscula) {
            return "Adicione pelo menos uma letra minúscula.";
        }

        if (!temNumero) {
            return "Adicione números.";
        }

        if (!temSimbolo) {
            return "A senha deve ter pelo menos um símbolo.";
        }

        return "";
    }

    // Mensagens enquanto digita
    if (senha && erroSenha) {
        senha.addEventListener('input', function () {
            if (this.value.length === 0) {
                erroSenha.textContent = "";
            } else {
                erroSenha.textContent = validarSenha(this.value);
            }
        });
    }

    // Validação antes de enviar
    if (formulario && senha && erroSenha) {
        formulario.addEventListener('submit', function (evento) {
            erroSenha.textContent = validarSenha(senha.value);

            if (erroSenha.textContent !== '') {
                evento.preventDefault();
            }
        });
    }

});