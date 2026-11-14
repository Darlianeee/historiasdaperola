
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres da página -->
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título da página -->
    <title>Excluir Notificação</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/excluir_notificacao_adm.css">
</head>

<body>

    <!-- Inclui o menu de navegação do administrador -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal do conteúdo da página -->
    <main class="conteudo">

        <!-- Exibe o título da página -->
        <div class="titulo">
            <h1>Excluir Notificação</h1>
        </div>

        <!-- Apresenta uma mensagem perguntando se o administrador deseja excluir a notificação -->
        <p class="descricao">
            Deseja realmente excluir esta notificação?
        </p>

        <!-- Camada utilizada para apresentar a janela de confirmação -->
        <div class="overlay">

            <!-- Janela de confirmação da exclusão -->
            <div class="modal">

                <!-- Título da janela de confirmação -->
                <h2>
                    Deseja realmente excluir esta notificação?
                </h2>

                <!-- Exibe o título da notificação que será excluída e um aviso sobre a ação -->
                <p>
                    <strong><?= Html::e($notificacao->noti_titulo) ?></strong><br>
                    A notificação será apagada permanentemente,
                    exclua se tiver certeza dessa decisão.
                </p>

                <!-- Formulário responsável por enviar a solicitação de exclusão -->
                <form class="botoes" method="post" action="<?= URL ?>/administrador/excluir_notificacao_adm">

                    <!-- Armazena o ID da notificação para identificar qual registro será excluído -->
                    <input type="hidden" name="id" value="<?= (int) $notificacao->noti_id ?>">

                    <!-- Botão que permite cancelar a exclusão e retornar à lista de notificações -->
                    <button type="button" class="cancelar">
                        <a href="<?= URL ?>/administrador/notificacoes_adm">
                            Cancelar
                        </a>
                    </button>

                    <!-- Botão que confirma e envia o formulário para excluir a notificação -->
                    <button type="submit" class="excluir">
                        Excluir
                    </button>

                </form>

            </div>

        </div>

    </main>

    <!-- Inclui o rodapé do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas configurações da página -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
