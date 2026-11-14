// Interações simples da tela de histórias do administrador.

// Cria uma função que é executada imediatamente após sua definição.
(() => {

    // Ativa o modo estrito do JavaScript,
    // ajudando a evitar alguns erros durante a execução do código.
    'use strict';

    // Seleciona todos os botões de idioma que estão dentro
    // do elemento com a classe "botoes-idiomas".
    const botoesIdioma = document.querySelectorAll(
        '.botoes-idiomas .btn-idioma'
    );

    // Percorre todos os botões de idioma encontrados.
    botoesIdioma.forEach((botao) => {

        // Define o atributo de acessibilidade "aria-pressed"
        // de acordo com o estado atual do botão.
        botao.setAttribute(

            // Indica se o botão está selecionado ou não.
            'aria-pressed',

            // Se o botão possuir a classe "ativo", recebe "true".
            // Caso contrário, recebe "false".
            botao.classList.contains('ativo') ? 'true' : 'false'
        );
    });

})();