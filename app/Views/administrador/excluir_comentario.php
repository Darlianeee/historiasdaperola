<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Excluir Comentário</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/excluir_comentario.css">
</head>

<body>

    <?php include '../App/Views/administrador/menu_adm.php'; ?>

    <main class="conteudo">

        <div class="titulo">
            <h1>Excluir Comentário</h1>
        </div>

        <p class="descricao">
            Deseja realmente excluir este comentário?
        </p>

        <div class="overlay">

            <div class="modal">

                <h2>
                    Deseja realmente excluir este comentário?
                </h2>

                <p>
                    O comentário será apagado permanentemente,
                    exclua se tiver certeza dessa decisão.
                </p>

                <div class="botoes">

                    <button type="button" class="cancelar">
                        <a href="<?=URL?>/administrador/comentarios_adm">
                            Cancelar
                        </a>
                    </button>

                    <button type="button" class="excluir">
                        <a href="<?=URL?>/administrador/comentarios_adm">
                            Excluir
                        </a>
                    </button>

                </div>

            </div>

        </div>

    </main>

    <?php include '../App/Views/administrador/footer_adm.php'; ?>

</body>

</html>