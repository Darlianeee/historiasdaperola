
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres da página -->
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título da página -->
    <title>Editar Perfil</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/editar_perfil_adm.css">
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
                    <h1>Editar Perfil</h1>
                </div>

                <!-- Texto explicativo sobre a funcionalidade -->
                <p class="subtitle">
                    Altere seus dados.
                </p>
            </div>
        </header>

        <!-- Seção que contém as informações e opções de edição do perfil -->
        <section class="profile-card">

            <!-- Título da área de edição dos dados pessoais -->
            <h2>Editar Meus Dados</h2>

            <!-- Exibe mensagens temporárias do sistema, como avisos de sucesso ou erro -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário responsável por enviar os dados e a foto atualizada do perfil -->
            <form method="post" action="<?= URL ?>/administrador/editar_perfil_adm" enctype="multipart/form-data">

                <!-- Organiza a área da foto e as informações pessoais do administrador -->
                <div class="profile-grid">

                    <!-- Área lateral destinada à foto de perfil e aos botões de ação -->
                    <div class="profile-aside">

                        <!-- Moldura que apresenta a foto de perfil do administrador -->
                        <div class="avatar-frame">

                            <!-- Exibe a foto de perfil atual do administrador -->
                            <img id="previewFoto" src="<?= Html::e(Html::fotoPerfil($pessoa->pess_foto_perfil)) ?>" alt="Imagem ilustrativa de uma pessoa, usada como foto de perfil do administrador">

                            <!-- Permite abrir o seletor de arquivos para escolher uma nova foto -->
                            <label for="fotoPerfil" class="avatar-edit" title="Alterar foto">

                                <!-- Ícone de câmera que representa a opção de alterar a foto -->
                                <svg viewBox="0 0 24 24" aria-hidden="true">

                                    <!-- Desenha o corpo da câmera -->
                                    <path d="M9 3L7.5 5H5C3.9 5 3 5.9 3 7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V7C21 5.9 20.1 5 19 5H16.5L15 3H9Z" />

                                    <!-- Desenha a lente da câmera -->
                                    <circle cx="12" cy="12.5" r="3.5" />

                                </svg>

                            </label>

                            <!-- Campo para selecionar uma imagem nos formatos permitidos -->
                            <input type="file" id="fotoPerfil" name="fotoPerfil" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" hidden>

                        </div>

                        <!-- Área que reúne os botões de ação do perfil -->
                        <div class="profile-actions">

                            <!-- Envia o formulário para salvar as alterações realizadas no perfil -->
                            <button type="submit" class="profile-btn profile-btn-primary">
                                Salvar Alterações
                            </button>

                            <!-- Direciona para a página de alteração de senha -->
                            <a href="<?= URL ?>/administrador/alterar_senha_adm" class="profile-btn profile-btn-secondary">
                                Alterar senha
                            </a>

                        </div>

                    </div>

                    <!-- Área que apresenta os campos com os dados pessoais do administrador -->
                    <div class="info-grid">

                        <!-- Campo destinado à edição do nome -->
                        <div class="info-item">

                            <!-- Área que apresenta o ícone correspondente ao nome -->
                            <span class="info-icon">

                                <!-- Exibe o ícone de identificação do usuário -->
                                <img src="<?= URL ?>/public/img/icone_nome.png" alt="Ícone verde representando a silhueta de uma pessoa, indicando o nome completo do usuário">

                            </span>

                            <!-- Área que contém o rótulo e o campo de nome -->
                            <div class="info-content">

                                <!-- Identifica o campo de nome -->
                                <p class="info-label">
                                    Nome
                                </p>

                                <!-- Permite editar o nome do administrador, limitado a 100 caracteres -->
                                <input class="info-input" type="text" name="nome" maxlength="100" required value="<?= Html::e($pessoa->pess_nome) ?>">

                            </div>

                        </div>

                        <!-- Campo destinado à exibição do e-mail do administrador -->
                        <div class="info-item">

                            <!-- Área que apresenta o ícone correspondente ao e-mail -->
                            <span class="info-icon">

                                <!-- Exibe o ícone de envelope que representa o endereço de e-mail -->
                                <img src="<?= URL ?>/public/img/icone_email.png" alt="Ícone verde de um envelope, representando o endereço de e-mail do administrador">

                            </span>

                            <!-- Área que contém o rótulo e o campo de e-mail -->
                            <div class="info-content">

                                <!-- Identifica o campo de e-mail -->
                                <p class="info-label">
                                    E-mail
                                </p>

                                <!-- Exibe o e-mail cadastrado sem permitir sua edição -->
                                <input class="info-input" type="email" value="<?= Html::e($pessoa->emai_nome) ?>" readonly aria-readonly="true">

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </section>

    </main>

    <!-- Inclui o rodapé do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pela pré-visualização da foto de perfil -->
    <script src="<?= URL ?>/public/js/foto_perfil.js"></script>

    <!-- Importa o JavaScript responsável pelas configurações da página -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
