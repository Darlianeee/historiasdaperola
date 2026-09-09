<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Excluir Notificação</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/excluir_notificacao_adm.css">
</head>

<body>

    <?php include '../App/Views/administrador/menu_adm.php'; ?>

    <main class="conteudo">

        <div class="titulo">
            <h1>Excluir Notificação</h1>
        </div>

        <p class="descricao">
            Deseja realmente excluir esta notificação?
        </p>

        <div class="overlay">

            <div class="modal">

                <h2>
                    Deseja realmente excluir esta notificação?
                </h2>

                <p>
                    A notificação será apagada permanentemente,
                    exclua se tiver certeza dessa decisão.
                </p>

                <div class="botoes">

                    <button type="button" class="cancelar">
                        <a href="<?=URL?>/administrador/notificacoes_adm">
                            Cancelar
                        </a>
                    </button>

                    <button type="button" class="excluir">
                        <a href="<?=URL?>/administrador/notificacoes_adm">
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