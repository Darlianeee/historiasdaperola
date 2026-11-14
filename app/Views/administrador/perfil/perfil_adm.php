
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e a configuração para diferentes tamanhos de tela -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador -->
    <title>Meu Perfil</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/perfil_adm.css">
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
                    <span class="title-mark"></span>
                    <h1>Meu Perfil</h1>
                </div>

                <p class="subtitle">Visualize e gerencie suas informações pessoais.</p>
            </div>
        </header>

        <!-- Exibe mensagens de sucesso ou erro armazenadas na sessão -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Cartão que reúne as informações do perfil do administrador -->
        <section class="profile-card">

            <h2>Meus Dados</h2>

            <!-- Organiza a foto, os botões e as informações pessoais -->
            <div class="profile-grid">

                <!-- Área que apresenta a foto e as opções de edição do perfil -->
                <div class="profile-aside">

                    <!-- Exibe a foto de perfil do administrador -->
                    <div class="avatar-frame">
                        <img src="<?= Html::e(Html::fotoPerfil($pessoa->pess_foto_perfil)) ?>" alt="Imagem ilustrativa de uma pessoa, usada como foto de perfil do administrador">
                    </div>

                    <!-- Botões que permitem acessar as opções de edição -->
                    <div class="profile-actions">

                        <!-- Direciona para a página de edição das informações pessoais -->
                        <a href="<?= URL ?>/administrador/editar_perfil_adm" class="profile-btn profile-btn-primary">
                            Editar perfil
                        </a>

                        <!-- Direciona para a página de alteração da senha -->
                        <a href="<?= URL ?>/administrador/alterar_senha_adm" class="profile-btn profile-btn-secondary">
                            Alterar senha
                        </a>

                    </div>

                </div>

                <!-- Área que apresenta os dados pessoais do administrador -->
                <div class="info-grid">

                    <!-- Exibe o nome cadastrado no sistema -->
                    <div class="info-item">
                        <span class="info-icon">
                            <img src="<?= URL ?>/public/img/icone_nome.png" alt="Ícone verde representando a silhueta de uma pessoa, indicando o nome completo do usuário">
                        </span>

                        <div class="info-content">
                            <p class="info-label">Nome</p>

                            <!-- Recupera e exibe o nome, utilizando Html::e() para proteger a saída -->
                            <p class="info-value"><?= Html::e($pessoa->pess_nome) ?></p>
                        </div>
                    </div>

                    <!-- Exibe o e-mail cadastrado no sistema -->
                    <div class="info-item">
                        <span class="info-icon">
                            <img src="<?= URL ?>/public/img/icone_email.png" alt="Ícone verde de um envelope, representando o endereço de e-mail do usuário">
                        </span>

                        <div class="info-content">
                            <p class="info-label">E-mail</p>

                            <!-- Recupera e exibe o endereço de e-mail do administrador -->
                            <p class="info-value"><?= Html::e($pessoa->emai_nome) ?></p>
                        </div>
                    </div>

                </div>

            </div>

        </section>

    </main>

    <!-- Inclui o rodapé utilizado nas páginas do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas funcionalidades da página -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
