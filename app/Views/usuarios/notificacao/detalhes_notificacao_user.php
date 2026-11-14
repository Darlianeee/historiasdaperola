<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Detalhe Notificação</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página e pelas configurações. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?=URL?>/public/css/detalhe_notificacao_user.css">
</head>

<body>

<!-- Inclui o menu de navegação do usuário. -->
<?php include APP . '/Views/usuarios/menu_user.php'; ?>

<main class="content">

    <!-- Cabeçalho com o título e a descrição da página. -->
    <header class="page-header">

        <div class="title-group">

            <div class="title-row">

                <!-- Elemento utilizado para a decoração do título. -->
                <span class="title-mark"></span>

                <h1>Detalhes da Notificação</h1>
            </div>

            <p class="subtitle">
                Acompanhe os detalhes da sua notificação.
            </p>

        </div>

    </header>

    <!-- Área que apresenta as informações da notificação selecionada. -->
    <section class="detail-panel">

        <div class="notification-detail-card">

            <div class="message-info">

                <!-- Exibe o título da notificação. -->
                <h2><?= Html::e($notificacao->noti_titulo) ?></h2>

                <!-- Exibe a data e o horário em que a notificação foi criada. -->
                <div class="message-date">
                    <strong>Data:</strong> <?= Html::e(Html::data($notificacao->noti_data_hora, 'd/m/Y H:i')) ?>
                </div>

            </div>

            <!-- Apresenta o conteúdo da mensagem da notificação. -->
            <div class="message-content">

                <p>
                    <?= nl2br(Html::e($notificacao->noti_mensagem)) ?>
                </p>

            </div>

            <!-- Área com os botões de navegação da página. -->
            <div class="detail-actions">

                <!-- Permite retornar à lista de notificações. -->
                <a href="<?= URL ?>/usuarios/notificacoes_user" class="btn btn-secondary">
                    Voltar às notificações
                </a>

                <!-- Verifica se a notificação está relacionada a alguma história. -->
                <?php if (!empty($historiaId)): ?>

                    <!-- Direciona o usuário para a história relacionada à notificação.
                         Se for uma notificação de novo comentário, abre diretamente a área de comentários. -->
                    <a href="<?= URL ?>/usuarios/historias_user?id=<?= (int) $historiaId ?><?= ($notificacao->noti_titulo === 'Novo comentário' ? '#comentarios' : '') ?>" class="btn btn-primary">
                        Ver história
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </section>

</main>

<!-- Inclui o rodapé compartilhado do projeto. -->
<?php include APP . '/Views/paginas/footer.php'; ?>

<!-- Importa o JavaScript responsável pelas configurações de acessibilidade e aparência. -->
<script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>
</html>