// Identifica quando o usuário realiza um clique em qualquer lugar da página.
document.addEventListener('click', function (event) {

    // Seleciona todos os elementos que possuem a classe
    // "notification-action", responsáveis pelas ações das notificações.
    document.querySelectorAll('.notification-action').forEach(function (menu) {

        // Busca o checkbox responsável por controlar a abertura
        // e o fechamento do menu de opções.
        const checkbox = menu.querySelector('.menu-toggle');

        // Verifica se o checkbox existe e se o clique aconteceu
        // fora do elemento que contém o menu.
        if (checkbox && !menu.contains(event.target)) {

            // Desmarca o checkbox, fazendo com que o menu seja fechado.
            checkbox.checked = false;
        }
    });
});