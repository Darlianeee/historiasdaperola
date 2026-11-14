
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres da página -->
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título da página -->
    <title>Detalhe Notificação</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/detalhe_notificacao_adm.css">
</head>

<body>

    <!-- Inclui o menu de navegação do administrador -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal do conteúdo da página -->
    <main class="content">

        <!-- Cabeçalho com o título e a descrição da página -->
        <header class="page-header">

            <div class="title-group">

                <div class="title-row">
                    <!-- Elemento visual utilizado ao lado do título -->
                    <span class="title-mark"></span>

                    <!-- Título principal da página -->
                    <h1>Detalhes da Notificação</h1>
                </div>

                <!-- Texto explicativo sobre a página -->
                <p class="subtitle">
                    Acompanhe os detalhes da sua notificação.
                </p>

            </div>

        </header>

        <!-- Seção que apresenta as informações da notificação -->
        <section class="detail-panel">

            <div class="notification-detail-card">

                <!-- Área com o título e a data da notificação -->
                <div class="message-info">

                    <!-- Exibe o título da notificação, protegendo o conteúdo -->
                    <h2><?= Html::e($notificacao->noti_titulo) ?></h2>

                    <!-- Exibe a data e o horário da notificação no formato brasileiro -->
                    <div class="message-date">
                        <strong>Data:</strong> <?= Html::e(Html::data($notificacao->noti_data_hora, 'd/m/Y H:i')) ?>
                    </div>

                </div>

                <!-- Área que apresenta a mensagem completa da notificação -->
                <div class="message-content">

                    <p>
                        <!-- Exibe a mensagem, mantendo as quebras de linha e protegendo o conteúdo -->
                        <?= nl2br(Html::e($notificacao->noti_mensagem)) ?>
                    </p>

                </div>

                <!-- Área com os botões de navegação da página -->
                <div class="detail-actions">

                    <!-- Permite retornar à lista de notificações do administrador -->
                    <a href="<?= URL ?>/administrador/notificacoes_adm" class="btn btn-secondary">
                        Voltar às notificações
                    </a>

                    <!-- Verifica se a notificação está relacionada a alguma história -->
                    <?php if (!empty($historiaId)): ?>

                        <!-- Exibe o botão para acessar a história relacionada à notificação -->
                        <a href="<?= URL ?>/administrador/historias_adm?id=<?= (int) $historiaId ?><?= ($notificacao->noti_titulo === 'Novo comentário' ? '#comentarios' : '') ?>" class="btn btn-primary">
                            Ver história
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </section>

    </main>

    <!-- Inclui o rodapé do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas configurações da página -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
