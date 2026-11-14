// Aguarda o carregamento completo do HTML antes de executar o código.
document.addEventListener("DOMContentLoaded", function () {

    // Busca o botão responsável por abrir e fechar o menu
    // e o elemento que contém os links de navegação.
    const menuToggle = document.getElementById("menuToggle");
    const mainNav = document.getElementById("mainNav");

    // Verifica se os dois elementos existem na página.
    if (menuToggle && mainNav) {

        // Abre e fecha o menu pelo botão dos três risquinhos.
        menuToggle.addEventListener("click", function (event) {

            // Impede que o clique no botão seja interpretado
            // como um clique fora do menu.
            event.stopPropagation();

            // Alterna a classe "open", responsável por mostrar ou ocultar o menu.
            mainNav.classList.toggle("open");

            // Alterna a classe "active", responsável por alterar
            // a aparência do botão de menu.
            menuToggle.classList.toggle("active");
        });

        // Impede que clicar dentro do menu faça ele fechar.
        mainNav.addEventListener("click", function (event) {

            // Impede que o clique dentro do menu se propague para o documento.
            event.stopPropagation();
        });

        // Fecha o menu quando o usuário clicar fora dele.
        document.addEventListener("click", function () {

            // Remove a classe que mantém o menu aberto.
            mainNav.classList.remove("open");

            // Remove a classe que indica que o botão está ativo.
            menuToggle.classList.remove("active");
        });

    }

});