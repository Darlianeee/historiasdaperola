// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener("DOMContentLoaded", function () {

    // Seleciona todos os campos que possuem o atributo name="email"
    // ou que são identificados como campos do tipo e-mail.
    const camposEmail = document.querySelectorAll(
        'input[name="email"], input[type="email"]'
    );

    // Percorre todos os campos de e-mail encontrados na página.
    camposEmail.forEach(function (campo) {

        // Função responsável por remover caracteres não permitidos.
        function limparEmail() {

            // Guarda a posição atual do cursor no campo.
            const inicio = campo.selectionStart;

            // Permite somente letras, números, ponto e @.
            // Os demais caracteres são removidos.
            campo.value = campo.value.replace(/[^a-zA-Z0-9.@]/g, "");

            // Mantém o cursor na posição correta após a limpeza do campo.
            if (inicio !== null) {
                const posicao = Math.min(inicio, campo.value.length);
                campo.setSelectionRange(posicao, posicao);
            }
        }

        // Executa a limpeza sempre que o usuário digitar alguma informação.
        campo.addEventListener("input", limparEmail);

        // Identifica quando o usuário tenta colar algum conteúdo no campo.
        campo.addEventListener("paste", function (evento) {

            // Impede que o conteúdo seja colado da maneira padrão.
            evento.preventDefault();

            // Obtém o texto copiado e remove os caracteres não permitidos.
            const texto = evento.clipboardData
                .getData("text")
                .replace(/[^a-zA-Z0-9.@]/g, "");

            // Insere o texto já limpo na posição selecionada do campo.
            // O cursor é colocado no final do texto inserido.
            campo.setRangeText(
                texto,
                campo.selectionStart,
                campo.selectionEnd,
                "end"
            );

            // Dispara novamente o evento de digitação para atualizar
            // o campo e executar as verificações necessárias.
            campo.dispatchEvent(new Event("input", {
                bubbles: true
            }));
        });
    });
});