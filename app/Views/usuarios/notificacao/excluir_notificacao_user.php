<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Excluir Notificação</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?=URL?>/public/css/excluir_notificacao_user.css">
</head>

<body>

    <!-- Inclui o menu de navegação do usuário. -->
    <?php include APP . '/Views/usuarios/menu_user.php'; ?>

    <main class="conteudo">

        <!-- Exibe o título principal da página. -->
        <div class="titulo">
            <h1>Excluir Notificação</h1>
        </div>

        <!-- Apresenta uma mensagem perguntando se o usuário deseja continuar. -->
        <p class="descricao">
            Deseja realmente excluir esta notificação?
        </p>

        <!-- Camada utilizada para exibir a janela de confirmação. -->
        <div class="overlay">

            <div class="modal">

                <!-- Título da janela de confirmação da exclusão. -->
                <h2>
                    Deseja realmente excluir esta notificação?
                </h2>

                <p>
                    <!-- Exibe o título da notificação que será excluída. -->
                    <strong><?= Html::e($notificacao->noti_titulo) ?></strong><br>

                    <!-- Informa que a exclusão será permanente. -->
                    A notificação será apagada permanentemente,
                    exclua se tiver certeza dessa decisão.
                </p>

                <!-- Formulário responsável por enviar a solicitação de exclusão. -->
                <form class="botoes" method="post" action="<?=URL?>/usuarios/excluir_notificacao_user">

                    <!-- Envia o ID da notificação para identificar qual será excluída. -->
                    <input type="hidden" name="id" value="<?= (int) $notificacao->noti_id ?>">

                    <!-- Botão que permite cancelar a operação e voltar à lista de notificações. -->
                    <button type="button" class="cancelar">
                        <a href="<?=URL?>/usuarios/notificacoes_user">
                            Cancelar
                        </a>
                    </button>

                    <!-- Confirma a exclusão e envia o formulário. -->
                    <button type="submit" class="excluir">
                        Excluir
                    </button>

                </form>

            </div>

        </div>

    </main>

    <!-- Inclui o rodapé compartilhado do projeto. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas configurações de acessibilidade e aparência. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>