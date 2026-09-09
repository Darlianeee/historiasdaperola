<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalhe Notificação</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/detalhe_notificacao_adm.css">
</head>

<body>

<?php include '../App/Views/administrador/menu_adm.php'; ?>

<main class="content">

    <header class="page-header">

        <div class="title-group">

            <div class="title-row">
                <span class="title-mark"></span>

                <h1>Detalhes da Notificação</h1>
            </div>

            <p class="subtitle">
                Acompanhe os detalhes da sua notificação.
            </p>

        </div>

    </header>


    <section class="detail-panel">

        <div class="notification-detail-card">

            <div class="message-info">

                <h2>Título da mensagem</h2>

                <div class="message-date">
                    <strong>Data:</strong> dd/mm/aaaa
                </div>

            </div>


            <div class="message-content">

                <p>
                    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                    XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                </p>

            </div>


            <div class="detail-actions">

                <a href="notificacoes_adm" class="btn btn-primary">
                    Marcar como lida
                </a>

            </div>

        </div>

    </section>

</main>

<?php include '../App/Views/administrador/footer_adm.php'; ?>

</body>
</html>