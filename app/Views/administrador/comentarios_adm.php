<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gerenciar Comentários</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/comentarios_adm.css">
</head>

<body>

<?php include '../App/Views/administrador/menu_adm.php'; ?>

<main class="conteudo">

    <!-- CABEÇALHO -->
    <section class="cabecalho-pagina">

        <h1>Gerenciar Comentários</h1>

        <p>Visualize os comentários e responda aos usuários.</p>

    </section>


    <!-- FILTROS -->
    <section class="filtros">

        <!-- CALENDÁRIO -->
        <input
            type="date"
            class="campo-data"
        >

        <!-- HORA -->
        <input
            type="time"
            class="campo-hora"
            step="1"
        >

    </section>


    <!-- TABELA -->
    <section class="tabela-container">

        <table class="tabela-comentarios">

            <thead>

                <tr>
                    <th>Usuário</th>
                    <th>Comentário</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>

            </thead>

            <tbody>


                <!-- USUÁRIO 1 -->
                <tr>

                    <td>
                        Nome Usuario1
                    </td>

                    <td>
                        <span>xxxxxxxxxxxxxxxx</span>
                        <span>xxxxxxxxxxxxxxxx</span>
                    </td>

                    <td class="data-hora">
                        <span>dd/mm/aaaa</span>
                        <span>hh:mm:ss</span>
                    </td>

                    <td>

                        <div class="acoes-container">

                            <button
                                type="button"
                                class="botao-acoes"
                                onclick="abrirMenu(this)"
                            >
                                •••
                            </button>

                            <div class="menu-acoes">

                                <a href="<?=URL?>/administrador/responder_comentario">
                                    Responder Comentário
                                </a>

                                <a href="<?=URL?>/administrador/excluir_comentario">
                                    Excluir Comentário
                                </a>

                            </div>

                        </div>

                    </td>

                </tr>


                <!-- USUÁRIO 2 -->
                <tr>

                    <td>
                        Nome Usuario2
                    </td>

                    <td>
                        <span>xxxxxxxxxxxxxxxx</span>
                        <span>xxxxxxxxxxxxxxxx</span>
                    </td>

                    <td class="data-hora">
                        <span>dd/mm/aaaa</span>
                        <span>hh:mm:ss</span>
                    </td>

                    <td>

                        <div class="acoes-container">

                            <button
                                type="button"
                                class="botao-acoes"
                                onclick="abrirMenu(this)"
                            >
                                •••
                            </button>

                            <div class="menu-acoes">

                                <a href="<?=URL?>/administrador/responder_comentario">
                                    Responder Comentário
                                </a>

                                <a href="<?=URL?>/administrador/excluir_comentario">
                                    Excluir Comentário
                                </a>

                            </div>

                        </div>

                    </td>

                </tr>


                <!-- USUÁRIO 3 -->
                <tr>

                    <td>
                        Nome Usuario3
                    </td>

                    <td>
                        <span>xxxxxxxxxxxxxxxx</span>
                        <span>xxxxxxxxxxxxxxxx</span>
                    </td>

                    <td class="data-hora">
                        <span>dd/mm/aaaa</span>
                        <span>hh:mm:ss</span>
                    </td>

                    <td>

                        <div class="acoes-container">

                            <button
                                type="button"
                                class="botao-acoes"
                                onclick="abrirMenu(this)"
                            >
                                •••
                            </button>

                            <div class="menu-acoes">

                                <a href="<?=URL?>/administrador/responder_comentario">
                                    Responder Comentário
                                </a>

                                <a href="<?=URL?>/administrador/excluir_comentario">
                                    Excluir Comentário
                                </a>

                            </div>

                        </div>

                    </td>

                </tr>


                <!-- USUÁRIO 4 -->
                <tr>

                    <td>
                        Nome Usuario4
                    </td>

                    <td>
                        <span>xxxxxxxxxxxxxxxx</span>
                        <span>xxxxxxxxxxxxxxxx</span>
                    </td>

                    <td class="data-hora">
                        <span>dd/mm/aaaa</span>
                        <span>hh:mm:ss</span>
                    </td>

                    <td>

                        <div class="acoes-container">

                            <button
                                type="button"
                                class="botao-acoes"
                                onclick="abrirMenu(this)"
                            >
                                •••
                            </button>

                            <div class="menu-acoes">

                                <a href="<?=URL?>/administrador/responder_comentario">
                                    Responder Comentário
                                </a>

                                <a href="<?=URL?>/administrador/excluir_comentario">
                                    Excluir Comentário
                                </a>

                            </div>

                        </div>

                    </td>

                </tr>


                <!-- USUÁRIO 5 -->
                <tr>

                    <td>
                        Nome Usuario5
                    </td>

                    <td>
                        <span>xxxxxxxxxxxxxxxx</span>
                        <span>xxxxxxxxxxxxxxxx</span>
                    </td>

                    <td class="data-hora">
                        <span>dd/mm/aaaa</span>
                        <span>hh:mm:ss</span>
                    </td>

                    <td>

                        <div class="acoes-container">

                            <button
                                type="button"
                                class="botao-acoes"
                                onclick="abrirMenu(this)"
                            >
                                •••
                            </button>

                            <div class="menu-acoes">

                                <a href="<?=URL?>/administrador/responder_comentario">
                                    Responder Comentário
                                </a>

                                <a href="<?=URL?>/administrador/excluir_comentario">
                                    Excluir Comentário
                                </a>

                            </div>

                        </div>

                    </td>

                </tr>


                <!-- USUÁRIO 6 -->
                <tr>

                    <td>
                        Nome Usuario6
                    </td>

                    <td>
                        <span>xxxxxxxxxxxxxxxx</span>
                        <span>xxxxxxxxxxxxxxxx</span>
                    </td>

                    <td class="data-hora">
                        <span>dd/mm/aaaa</span>
                        <span>hh:mm:ss</span>
                    </td>

                    <td>

                        <div class="acoes-container">

                            <button
                                type="button"
                                class="botao-acoes"
                                onclick="abrirMenu(this)"
                            >
                                •••
                            </button>

                            <div class="menu-acoes">

                                <a href="<?=URL?>/administrador/responder_comentario">
                                    Responder Comentário
                                </a>

                                <a href="<?=URL?>/administrador/excluir_comentario">
                                    Excluir Comentário
                                </a>

                            </div>

                        </div>

                    </td>

                </tr>

            </tbody>

        </table>

    </section>

</main>


<?php include '../App/Views/administrador/footer_adm.php'; ?>


<script>

function abrirMenu(botao) {

    const container = botao.parentElement;

    document.querySelectorAll('.acoes-container').forEach(function(item) {

        if (item !== container) {
            item.classList.remove('ativo');
        }

    });

    container.classList.toggle('ativo');
}


document.addEventListener('click', function(event) {

    if (!event.target.closest('.acoes-container')) {

        document.querySelectorAll('.acoes-container').forEach(function(item) {
            item.classList.remove('ativo');
        });

    }

});

</script>

</body>
</html>