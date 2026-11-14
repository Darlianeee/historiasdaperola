
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres da página -->
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título da página -->
    <title>Alterar Senha</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/alterar_senha_adm.css">
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
                    <h1>Alterar Senha</h1>
                </div>

                <!-- Texto explicativo sobre a funcionalidade -->
                <p class="subtitle">Modifique sua senha.</p>
            </div>
        </header>

        <!-- Seção que contém o formulário de alteração de senha -->
        <section class="password-card">

            <!-- Cabeçalho do formulário -->
            <div class="card-heading">
                <h2>Meus Dados - Alterar Senha</h2>

                <!-- Linha decorativa abaixo do título -->
                <div class="section-line"></div>
            </div>

            <!-- Exibe mensagens temporárias do sistema, como avisos de sucesso ou erro -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário responsável por enviar os dados para a alteração da senha -->
            <form class="password-form" method="post" action="<?= URL ?>/administrador/alterar_senha_adm">

                <!-- Campo destinado à senha atual do administrador -->
                <div class="password-group">
                    <label for="current-password">Digite a senha atual:</label>

                    <!-- Agrupa o campo de senha e o botão de visualização -->
                    <div class="password-input-wrapper">

                        <!-- Permite informar a senha atual para confirmar a identidade do administrador -->
                        <input
                            id="current-password"
                            name="senha_atual"
                            class="password-input"
                            type="password"
                            autocomplete="current-password"
                            required>

                        <!-- Botão utilizado para mostrar ou ocultar a senha atual -->
                        <button type="button" class="password-toggle" data-target="current-password" title="Mostrar/Ocultar senha">

                            <!-- Ícone de olho utilizado no botão de visualização -->
                            <img src="<?= URL ?>/public/img/icone_olhoo.png" alt="Mostrar senha" class="eye-icon">
                        </button>
                    </div>
                </div>

                <!-- Campo destinado à nova senha do administrador -->
                <div class="password-group">
                    <label for="new-password">Digite a nova senha:</label>

                    <!-- Elemento utilizado para apresentar mensagens de erro relacionadas à nova senha -->
                    <p id="erro-nova-senha" class="erro-senha"></p>

                    <!-- Agrupa o campo da nova senha e o botão de visualização -->
                    <div class="password-input-wrapper">

                        <!-- Permite cadastrar a nova senha, exigindo entre 8 e 30 caracteres -->
                        <input id="new-password" name="nova_senha" class="password-input" type="password" autocomplete="new-password" minlength="8" maxlength="30" required>

                        <!-- Botão utilizado para mostrar ou ocultar a nova senha -->
                        <button type="button" class="password-toggle" data-target="new-password" title="Mostrar/Ocultar senha">

                            <!-- Ícone de olho utilizado no botão de visualização -->
                            <img src="<?= URL ?>/public/img/icone_olhoo.png" alt="Mostrar senha" class="eye-icon">
                        </button>
                    </div>

                    <!-- Elemento utilizado para apresentar mensagens de erro relacionadas à nova senha -->
                    <p id="erro-nova-senha" class="erro-senha"></p>
                </div>

                <!-- Campo destinado à confirmação da nova senha -->
                <div class="password-group">
                    <label for="confirm-password">Repita a nova senha:</label>

                    <!-- Agrupa o campo de confirmação e o botão de visualização -->
                    <div class="password-input-wrapper">

                        <!-- Permite repetir a nova senha para verificar se os valores correspondem -->
                        <input
                            id="confirm-password"
                            name="confirmar_senha"
                            class="password-input"
                            type="password"
                            autocomplete="new-password"
                            minlength="8"
                            maxlength="30"
                            required>

                        <!-- Botão utilizado para mostrar ou ocultar a senha de confirmação -->
                        <button type="button" class="password-toggle" data-target="confirm-password" title="Mostrar/Ocultar senha">

                            <!-- Ícone de olho utilizado no botão de visualização -->
                            <img src="<?= URL ?>/public/img/icone_olhoo.png" alt="Mostrar senha" class="eye-icon">
                        </button>
                    </div>
                </div>

                <!-- Área que reúne o botão de envio do formulário -->
                <div class="form-actions">

                    <!-- Envia os dados preenchidos para salvar a alteração da senha -->
                    <button type="submit" class="password-btn password-btn-primary">
                        Salvar Alterações
                    </button>
                </div>

            </form>
        </section>
    </main>

    <!-- Inclui o rodapé do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas funcionalidades de alteração de senha -->
    <script src="<?= URL ?>/public/js/alterar-senha.js"></script>

    <!-- Importa o JavaScript responsável pelas configurações da página -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>

</body>

</html>
