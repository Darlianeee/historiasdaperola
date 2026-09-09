<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        rel="stylesheet"
        href="<?=URL?>/public/css/notificacoes_user.css"
    >

    <title>Notificações</title>

</head>


<body>


<?php include '../App/Views/usuarios/menu_user.php'; ?>


<main class="container">


    <!-- =====================================================
         CABEÇALHO
    ====================================================== -->

    <section class="cabecalho">

        <h1>Notificações</h1>

        <p>
            Acompanhe suas notificações.
        </p>

    </section>



    <!-- =====================================================
         FILTROS
    ====================================================== -->

    <section class="topo">


        <button class="botao">
            Todas
        </button>


        <button class="botao">
            Não Lidas
        </button>


        <button class="botao">
            Lidas
        </button>


        <div class="buscar">

            <img
                src="<?=URL?>/public/img/LUPA2.png"
                alt="Pesquisar"
                class="icon-Lupa"
            >

            <input
                type="text"
                placeholder="Buscar notificações..."
            >

        </div>


        <input
            type="date"
            class="data"
        >


    </section>



    <!-- =====================================================
         LISTA DE NOTIFICAÇÕES
    ====================================================== -->


    <section class="lista-notificacoes">



        <!-- =================================================
             NOTIFICAÇÃO 1
        ================================================== -->

        <article class="notificacao">


            <div class="icone comentario">

                <img
                    src="<?=URL?>/public/img/comen.png"
                    alt="Comentário"
                    class="icon-comentario"
                >

            </div>



            <div class="texto">

                <h3>
                    XXXXXXXX respondeu seu comentário.
                </h3>

                <p>
                    Seu comentário sobre “xxxxxxxx” foi respondido pelo administrador.
                </p>

                <span>
                    Há x dias
                </span>

            </div>



            <!-- MENU DOS 3 PONTOS -->

            <div class="notification-action">


                <input
                    type="checkbox"
                    id="menu-1"
                    class="menu-toggle"
                >


                <label
                    for="menu-1"
                    class="menu-dots"
                    aria-label="Abrir opções"
                >

                    <img
                        src="<?=URL?>/public/img/pontoo.png"
                        alt="Opções"
                        class="icon-ponto"
                    >

                </label>



                <div class="dropdown-menu">


                    <a href="<?=URL?>/usuarios/detalhes_notificacao_user" class="detalhes-link">
                        Ver detalhes
                    </a>


                    <a href="<?=URL?>/usuarios/notificacoes_user" class="marcar-lida-link">
                        Marcar como lida
                    </a>


                    <a
                        href="<?=URL?>/usuarios/excluir_notificacao_user"
                        class="delete-btn"
                    >
                        Excluir
                    </a>


                </div>


            </div>


        </article>



        <!-- =================================================
             NOTIFICAÇÃO 2
        ================================================== -->

        <article class="notificacao">


            <div class="icone livro">

                <img
                    src="<?=URL?>/public/img/livro.png"
                    alt="Livro"
                    class="icon-livro"
                >

            </div>



            <div class="texto">

                <h3>
                    Nova lenda adicionada!
                </h3>

                <p>
                    Uma nova lenda foi publicada: "XXXXXXXXXX"
                </p>

                <span>
                    Há x dias
                </span>

            </div>



            <div class="notification-action">


                <input
                    type="checkbox"
                    id="menu-2"
                    class="menu-toggle"
                >


                <label
                    for="menu-2"
                    class="menu-dots"
                    aria-label="Abrir opções"
                >

                    <img
                        src="<?=URL?>/public/img/pontoo.png"
                        alt="Opções"
                        class="icon-ponto"
                    >

                </label>



                <div class="dropdown-menu">


                    <a href="<?=URL?>/usuarios/detalhes_notificacao_user" class="detalhes-link">
                        Ver detalhes
                    </a>


                    <a href="<?=URL?>/usuarios/notificacoes_user" class="marcar-lida-link">
                        Marcar como lida
                    </a>


                    <a
                        href="<?=URL?>/usuarios/excluir_notificacao_user"
                        class="delete-btn"
                    >
                        Excluir
                    </a>


                </div>


            </div>


        </article>



        <!-- =================================================
             NOTIFICAÇÃO 3
        ================================================== -->

        <article class="notificacao">


            <div class="icone comentario">

                <img
                    src="<?=URL?>/public/img/comen.png"
                    alt="Comentário"
                    class="icon-comentario"
                >

            </div>



            <div class="texto">

                <h3>
                    XXXXXXXX respondeu seu comentário.
                </h3>

                <p>
                    Seu comentário sobre “xxxxxxxx” foi respondido pelo administrador.
                </p>

                <span>
                    Há x dias
                </span>

            </div>



            <div class="notification-action">


                <input
                    type="checkbox"
                    id="menu-3"
                    class="menu-toggle"
                >


                <label
                    for="menu-3"
                    class="menu-dots"
                    aria-label="Abrir opções"
                >

                    <img
                        src="<?=URL?>/public/img/pontoo.png"
                        alt="Opções"
                        class="icon-ponto"
                    >

                </label>



                <div class="dropdown-menu">


                    <a href="<?=URL?>/usuarios/detalhes_notificacao_user" class="detalhes-link">
                        Ver detalhes
                    </a>


                    <a href="<?=URL?>/usuarios/notificacoes_user" class="marcar-lida-link">
                        Marcar como lida
                    </a>


                    <a
                        href="<?=URL?>/usuarios/excluir_notificacao_user"
                        class="delete-btn"
                    >
                        Excluir
                    </a>


                </div>


            </div>


        </article>



        <!-- =================================================
             NOTIFICAÇÃO 4
        ================================================== -->

        <article class="notificacao">


            <div class="icone livro">

                <img
                    src="<?=URL?>/public/img/livro.png"
                    alt="Livro"
                    class="icon-livro"
                >

            </div>



            <div class="texto">

                <h3>
                    Nova lenda adicionada!
                </h3>

                <p>
                    Uma nova lenda foi publicada: “xxxxxxxxxxx”
                </p>

                <span>
                    Há x dias
                </span>

            </div>



            <div class="notification-action">


                <input
                    type="checkbox"
                    id="menu-4"
                    class="menu-toggle"
                >


                <label
                    for="menu-4"
                    class="menu-dots"
                    aria-label="Abrir opções"
                >

                    <img
                        src="<?=URL?>/public/img/pontoo.png"
                        alt="Opções"
                        class="icon-ponto"
                    >

                </label>



                <div class="dropdown-menu">


                    <a href="<?=URL?>/usuarios/detalhes_notificacao_user" class="detalhes-link">
                        Ver detalhes
                    </a>


                    <a href="<?=URL?>/usuarios/notificacoes_user" class="marcar-lida-link">
                        Marcar como lida
                    </a>


                    <a
                        href="<?=URL?>/usuarios/excluir_notificacao_user"
                        class="delete-btn"
                    >
                        Excluir
                    </a>


                </div>


            </div>


        </article>


    </section>


</main>

<?php include '../App/Views/usuarios/footer_user.php'; ?>

</body>

</html>