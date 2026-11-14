
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página para diferentes tamanhos de tela. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Excluir História</title>

    <!-- Carrega os arquivos CSS responsáveis pela aparência da página e pelas configurações gerais. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/excluir_historia.css">
</head>

<body>

    <!-- Inclui o menu de navegação utilizado pelo administrador. -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal que contém as informações e a confirmação da exclusão. -->
    <main class="conteudo">

        <!-- Apresenta o título da página. -->
        <div class="titulo">
            <h1>Excluir História</h1>
        </div>

        <!-- Exibe uma breve descrição da funcionalidade. -->
        <p class="descricao">
            Remova suas histórias.
        </p>

        <!-- Camada que envolve a janela de confirmação da exclusão. -->
        <div class="overlay">

            <!-- Janela que apresenta a mensagem de confirmação e os botões de ação. -->
            <div class="modal">

                <!-- Pergunta ao administrador se realmente deseja excluir a história. -->
                <h2>
                    Deseja realmente excluir esta história?
                </h2>

                <!-- Exibe o título da história que será excluída e informa quais dados também serão removidos.
                     A função Html::e() protege o conteúdo exibido, evitando a interpretação de códigos HTML. -->
                <p>
                    <strong>"<?= Html::e($titulo) ?>"</strong> será apagada permanentemente,
                    junto com as traduções, comentários e avaliações.
                    Exclua se tiver certeza dessa decisão.
                </p>

                <!-- Formulário responsável por enviar a solicitação de exclusão ao servidor.
                     O método POST envia os dados sem colocá-los diretamente na URL. -->
                <form class="botoes" method="post" action="<?= URL ?>/administrador/excluir_historia_adm">

                    <!-- Envia o identificador da história para que o sistema saiba qual registro excluir. -->
                    <input type="hidden" name="id" value="<?= (int) $id ?>">

                    <!-- Botão que permite cancelar a operação e retornar ao gerenciamento de histórias. -->
                    <button type="button" class="cancelar">
                        <a href="<?= URL ?>/administrador/gerenciar_historia_adm">
                            Cancelar
                        </a>
                    </button>

                    <!-- Confirma a exclusão e envia o formulário para o servidor. -->
                    <button type="submit" class="excluir">
                        Excluir
                    </button>

                </form>

            </div>

        </div>

    </main>

    <!-- Inclui o rodapé padrão do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Carrega o JavaScript responsável pelas funcionalidades gerais das configurações da página. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
