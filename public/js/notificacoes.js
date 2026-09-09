document.addEventListener("DOMContentLoaded", function () {

    const menus = document.querySelectorAll(".notification-action");

    menus.forEach(function (menu) {

        const button = menu.querySelector(".menu-dots");
        const dropdown = menu.querySelector(".dropdown-menu");

        button.addEventListener("click", function (event) {

            event.stopPropagation();

            // Fecha todos os outros menus
            document.querySelectorAll(".dropdown-menu").forEach(function (outro) {
                if (outro !== dropdown) {
                    outro.classList.remove("active");
                }
            });

            // Abre ou fecha o menu clicado
            dropdown.classList.toggle("active");
        });

    });


    // Clicar em qualquer lugar fora fecha o menu
    document.addEventListener("click", function () {

        document.querySelectorAll(".dropdown-menu").forEach(function (dropdown) {
            dropdown.classList.remove("active");
        });

    });

});