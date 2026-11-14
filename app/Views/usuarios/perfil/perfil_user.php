<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Meu Perfil</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/perfil_usuario.css">
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

                    <h1>Meu Perfil</h1>
                </div>

                <p class="subtitle">Visualize e gerencie suas informações pessoais.</p>
            </div>
        </header>

        <!-- Exibe mensagens de sucesso ou erro, caso existam. -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Área principal que apresenta os dados do perfil do usuário. -->
        <section class="profile-card">

            <h2>Meus Dados</h2>

            <!-- Organiza as informações do perfil em duas áreas. -->
            <div class="profile-grid">

                <!-- Área lateral que apresenta a foto e os botões de ação. -->
                <div class="profile-aside">

                    <div class="avatar-frame">

                        <!-- Exibe a foto de perfil cadastrada pelo usuário. -->
                        <img src="<?= Html::e(Html::fotoPerfil($pessoa->pess_foto_perfil)) ?>" alt="Imagem ilustrativa de uma pessoa, usada como foto de perfil do usuário">
                    </div>

                    <!-- Área com os botões para gerenciar as informações da conta. -->
                    <div class="profile-actions">

                        <!-- Direciona o usuário para a página de edição do perfil. -->
                        <a href="<?= URL ?>/usuarios/editar_perfil_user" class="profile-btn profile-btn-primary">
                            Editar perfil
                        </a>

                        <!-- Direciona o usuário para a página de alteração de senha. -->
                        <a href="<?= URL ?>/usuarios/alterar_senha_user" class="profile-btn profile-btn-secondary">
                            Alterar senha
                        </a>

                    </div>

                </div>

                <!-- Área responsável por apresentar os dados pessoais do usuário. -->
                <div class="info-grid">

                    <!-- Bloco que apresenta o nome cadastrado. -->
                    <div class="info-item">

                        <span class="info-icon">

                            <!-- Exibe o ícone que representa o nome do usuário. -->
                            <img src="<?= URL ?>/public/img/icone_nome.png" alt="Ícone verde representando a silhueta de uma pessoa, indicando o nome completo do usuário">
                        </span>

                        <div class="info-content">

                            <!-- Identifica a informação apresentada. -->
                            <p class="info-label">Nome</p>

                            <!-- Exibe o nome cadastrado pelo usuário. -->
                            <p class="info-value"><?= Html::e($pessoa->pess_nome) ?></p>
                        </div>
                    </div>

                    <!-- Bloco que apresenta o e-mail cadastrado. -->
                    <div class="info-item">

                        <span class="info-icon">

                            <!-- Exibe o ícone que representa o endereço de e-mail. -->
                            <img src="<?= URL ?>/public/img/icone_email.png" alt="Ícone verde de um envelope, representando o endereço de e-mail do usuário">
                        </span>

                        <div class="info-content">

                            <!-- Identifica a informação apresentada. -->
                            <p class="info-label">E-mail</p>

                            <!-- Exibe o endereço de e-mail cadastrado pelo usuário. -->
                            <p class="info-value"><?= Html::e($pessoa->emai_nome) ?></p>
                        </div>
                    </div>

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