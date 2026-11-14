<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Editar Perfil</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/editar_perfil_user.css">
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

                    <h1>Editar Perfil</h1>
                </div>

                <p class="subtitle">
                    Altere seus dados.
                </p>
            </div>
        </header>

        <!-- Área principal que contém as informações do perfil do usuário. -->
        <section class="profile-card">

            <h2>Editar Meus Dados</h2>

            <!-- Exibe mensagens de sucesso ou erro, caso existam. -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário responsável por enviar as alterações do perfil.
                 O multipart/form-data permite o envio de arquivos, como a foto. -->
            <form method="post" action="<?= URL ?>/usuarios/editar_perfil_user" enctype="multipart/form-data">

                <!-- Organiza as informações do perfil em duas áreas. -->
                <div class="profile-grid">

                    <!-- Área lateral que apresenta a foto e os botões de ação. -->
                    <div class="profile-aside">

                        <div class="avatar-frame">

                            <!-- Exibe a foto de perfil atual do usuário. -->
                            <img id="previewFoto" src="<?= Html::e(Html::fotoPerfil($pessoa->pess_foto_perfil)) ?>" alt="Imagem ilustrativa de uma pessoa, usada como foto de perfil do administrador">

                            <!-- Rótulo que permite abrir a seleção de uma nova foto. -->
                            <label for="fotoPerfil" class="avatar-edit" title="Alterar foto">

                                <!-- Ícone de câmera utilizado para representar a alteração da foto. -->
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M9 3L7.5 5H5C3.9 5 3 5.9 3 7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V7C21 5.9 20.1 5 19 5H16.5L15 3H9Z" />
                                    <circle cx="12" cy="12.5" r="3.5" />
                                </svg>
                            </label>

                            <!-- Campo utilizado para selecionar uma nova foto de perfil.
                                 Aceita arquivos nos formatos JPG, JPEG, PNG e WEBP. -->
                            <input type="file" id="fotoPerfil" name="fotoPerfil" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" hidden>
                        </div>

                        <!-- Área com os botões para salvar as alterações ou alterar a senha. -->
                        <div class="profile-actions">

                            <!-- Envia o formulário para salvar os dados modificados. -->
                            <button type="submit" class="profile-btn profile-btn-primary">
                                Salvar Alterações
                            </button>

                            <!-- Direciona o usuário para a página de alteração de senha. -->
                            <a href="<?= URL ?>/usuarios/alterar_senha_user" class="profile-btn profile-btn-secondary">
                                Alterar senha
                            </a>
                        </div>
                    </div>

                    <!-- Área que apresenta os dados pessoais do usuário. -->
                    <div class="info-grid">

                        <!-- Campo destinado à exibição e alteração do nome. -->
                        <div class="info-item">

                            <span class="info-icon">

                                <!-- Exibe o ícone que representa o nome do usuário. -->
                                <img src="<?= URL ?>/public/img/icone_nome.png" alt="Ícone verde representando a silhueta de uma pessoa, indicando o nome completo do usuário">
                            </span>

                            <div class="info-content">

                                <!-- Identifica o campo de nome. -->
                                <p class="info-label">
                                    Nome
                                </p>

                                <!-- Permite alterar o nome, com limite de 100 caracteres. -->
                                <input class="info-input" type="text" name="nome" maxlength="100" required value="<?= Html::e($pessoa->pess_nome) ?>">
                            </div>
                        </div>

                        <!-- Campo destinado à exibição do e-mail cadastrado. -->
                        <div class="info-item">

                            <span class="info-icon">

                                <!-- Exibe o ícone que representa o endereço de e-mail. -->
                                <img src="<?= URL ?>/public/img/icone_email.png" alt="Ícone verde de um envelope, representando o endereço de e-mail do usuário">
                            </span>

                            <div class="info-content">

                                <!-- Identifica o campo de e-mail. -->
                                <p class="info-label">
                                    E-mail
                                </p>

                                <!-- Exibe o e-mail cadastrado, sem permitir sua edição. -->
                                <input class="info-input" type="email" value="<?= Html::e($pessoa->emai_nome) ?>" readonly aria-readonly="true">

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </section>

    </main>

    <!-- Inclui o rodapé compartilhado do projeto. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pela pré-visualização da foto selecionada. -->
    <script src="<?= URL ?>/public/js/foto_perfil.js"></script>

    <!-- Importa o JavaScript responsável pelas configurações de acessibilidade e aparência. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>