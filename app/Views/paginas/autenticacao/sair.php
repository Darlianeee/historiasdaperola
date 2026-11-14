
<?php
// Identifica o perfil para exibir o menu correto e definir o destino de Cancelar.
$administrador = Sessao::ehAdministrador();

// Define para qual página o usuário será direcionado ao clicar em Cancelar.
$paginaInicio = $administrador
    ? 'administrador/inicio_adm'
    : 'usuarios/inicio_user';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Configuração básica e folhas de estilo da tela de saída. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>TELA SAIR</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/sair.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
</head>

<body>

    <?php
    // Verifica o perfil e inclui o menu correspondente.
    if ($administrador) {
        include APP . '/Views/administrador/menu_adm.php';
    } else {
        include APP . '/Views/usuarios/menu_user.php';
    }
    ?>

    <!-- Área principal da tela de confirmação de saída. -->
    <main class="conteudo">

        <!-- Título da página. -->
        <div class="titulo">
            <h1>Sair</h1>
        </div>

        <!-- Apresenta a pergunta inicial para confirmar o encerramento da sessão. -->
        <p class="descricao">
            Deseja realmente encerrar sua sessão?
        </p>

        <!-- Área que organiza o cartão de confirmação de saída. -->
        <div class="overlay">

            <div class="modal">

                <!-- Exibe o ícone utilizado para representar a saída do sistema. -->
                <div class="icone-saida">
                    <img
                        src="<?= URL ?>/public/img/logo_saida.png"
                        alt="Ícone de saída"
                        class="icon-saida"
                    >
                </div>

                <h2>Deseja realmente sair?</h2>

                <!-- Informa ao usuário o que acontecerá após confirmar a saída. -->
                <p>
                    Sua sessão será encerrada e você será redirecionado
                    para a página de login.
                </p>

                <!-- Área que contém as opções para cancelar ou confirmar a saída. -->
                <div class="botoes">

                    <!-- Retorna o usuário à página inicial correspondente ao seu perfil. -->
                    <a
                        href="<?= URL ?>/<?= $paginaInicio ?>"
                        class="cancelar"
                    >
                        Cancelar
                    </a>

                    <!-- Direciona para a rota responsável por encerrar a sessão do usuário. -->
                    <a
                        href="<?= URL ?>/paginas/logout"
                        class="Sair"
                    >
                        Sair
                    </a>

                </div>

            </div>

        </div>

    </main>

    <!-- Inclui o rodapé compartilhado entre as páginas do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas funcionalidades das configurações de aparência e acessibilidade. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>

</body>

</html>
