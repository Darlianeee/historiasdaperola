<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="<?=URL?>/public/css/editar_perfil_user.css">
</head>

<body>
    <?php include '../App/Views/usuarios/menu_user.php'; ?>

    <main class="content">

        <header class="page-header">
            <div class="title-group">
                <div class="title-row">
                    <span class="title-mark"></span>
                    <h1>Editar Perfil</h1>
                </div>
                <p class="subtitle">Altere seus dados.</p>
            </div>
        </header>

        <section class="profile-card">
            <h2>Editar Meus Dados</h2>
            <form>
                <div class="profile-grid">
                    <div class="profile-aside">
                        <div class="avatar-frame">
                            <img src="<?=URL?>/img/foto_perfil.png" alt="Avatar">
                        </div>

                        <div class="profile-actions">

                            <button type="submit" class="profile-btn profile-btn-primary">
                                Salvar Alterações
                            </button>

                            <a href="<?=URL?>/usuarios/alterar_senha_user" class="profile-btn profile-btn-secondary">
                                Alterar senha
                            </a>

                        </div>

                    </div>

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-icon">
                                <img src="<?=URL?>/img/icone_nome.png" alt="Ícone de Nome">
                            </span>

                            <div class="info-content">
                                <p class="info-label">Nome Completo</p>
                                <input class="info-input" type="text" name="nome" value="Nome Completo">
                            </div>
                        </div>

                        <div class="info-item">
                            <span class="info-icon">
                                <img src="<?=URL?>/img/icone_email.png" alt="Ícone de Email">
                            </span>

                            <div class="info-content">
                                <p class="info-label">E-mail</p>
                                <input class="info-input" type="email" name="email" value="nome@ifro.edu.br">
                            </div>
                        </div>

                        <div class="info-item">
                            <span class="info-icon">
                                <img src="<?=URL?>/img/icone_matricula.png" alt="Ícone de Matrícula">
                            </span>

                            <div class="info-content">
                                <p class="info-label">SUAP</p>
                                <input class="info-input" type="text" name="suap" value="0000000000000" readonly>
                            </div>
                        </div>

                        <div class="info-item">
                            <span class="info-icon">
                                <img src="<?=URL?>/img/icone_ano.png" alt="Ícone de Ano">
                            </span>

                            <div class="info-content">
                                <p class="info-label">Ano</p>
                                <input class="info-input" type="text" name="ano" value="3º ano" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <?php include '../App/Views/usuarios/footer_user.php'; ?>
</body>
</html>