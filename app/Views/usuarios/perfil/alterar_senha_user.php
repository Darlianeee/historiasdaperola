<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Alterar Senha</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?=URL?>/public/css/alterar_senha_user.css">
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

                    <h1>Alterar Senha</h1>
                </div>

                <p class="subtitle">Modifique sua senha.</p>
            </div>
        </header>

        <!-- Área principal que contém o formulário de alteração de senha. -->
        <section class="password-card">

            <div class="card-heading">

                <!-- Título da seção de alteração dos dados da conta. -->
                <h2>Meus Dados - Alterar Senha</h2>

                <!-- Linha decorativa abaixo do título. -->
                <div class="section-line"></div>
            </div>

            <!-- Exibe mensagens de sucesso ou erro, caso existam. -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário responsável por enviar os dados para a alteração da senha. -->
            <form class="password-form" method="post" action="<?=URL?>/usuarios/alterar_senha_user">

                <!-- Campo para informar a senha atual do usuário. -->
                <div class="password-group">
                    <label for="current-password">Digite a senha atual:</label>

                    <div class="password-input-wrapper">

                        <!-- Recebe a senha atual para verificar a identidade do usuário. -->
                        <input id="current-password" name="senha_atual" class="password-input" type="password" autocomplete="current-password" required>

                        <!-- Botão utilizado para mostrar ou ocultar a senha digitada. -->
                        <button type="button" class="password-toggle" data-target="current-password" title="Mostrar/Ocultar senha">

                            <!-- Ícone de olho utilizado para controlar a visualização da senha. -->
                            <svg class="eye-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/><path class="eye-slash" d="M4 4 20 20" style="display:none"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Campo para informar a nova senha que será cadastrada. -->
                <div class="password-group">
                    <label for="new-password">Digite a nova senha:</label>

                    <!-- Espaço utilizado para apresentar mensagens de erro relacionadas à nova senha. -->
                    <p id="erro-nova-senha" class="erro-senha"></p>

                    <div class="password-input-wrapper">

                        <!-- Recebe a nova senha, exigindo no mínimo 8 e no máximo 30 caracteres. -->
                        <input id="new-password" name="nova_senha" class="password-input" type="password" autocomplete="new-password" minlength="8" maxlength="30" required>

                        <!-- Botão utilizado para mostrar ou ocultar a nova senha. -->
                        <button type="button" class="password-toggle" data-target="new-password" title="Mostrar/Ocultar senha">

                            <!-- Ícone de olho utilizado para controlar a visualização da senha. -->
                            <svg class="eye-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/><path class="eye-slash" d="M4 4 20 20" style="display:none"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Campo utilizado para confirmar a nova senha digitada. -->
                <div class="password-group">
                    <label for="confirm-password">Repita a nova senha:</label>

                    <div class="password-input-wrapper">

                        <!-- Recebe novamente a nova senha para verificar se os dois campos correspondem. -->
                        <input id="confirm-password" name="confirmar_senha" class="password-input" type="password" autocomplete="new-password" minlength="8" maxlength="30" required>

                        <!-- Botão utilizado para mostrar ou ocultar a senha de confirmação. -->
                        <button type="button" class="password-toggle" data-target="confirm-password" title="Mostrar/Ocultar senha">

                            <!-- Ícone de olho utilizado para controlar a visualização da senha. -->
                            <svg class="eye-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/><path class="eye-slash" d="M4 4 20 20" style="display:none"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Área que contém o botão para salvar as alterações. -->
                <div class="form-actions">

                    <!-- Envia os dados preenchidos para o controller realizar a alteração da senha. -->
                    <button type="submit" class="password-btn password-btn-primary">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </section>
    </main>

    <!-- Inclui o rodapé compartilhado do projeto. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas ações de validação e visualização das senhas. -->
    <script src="<?=URL?>/public/js/alterar-senha.js"></script>

    <!-- Importa o JavaScript responsável pelas configurações de acessibilidade e aparência. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>
</html>