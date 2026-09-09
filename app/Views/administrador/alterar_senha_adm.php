<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/alterar_senha_adm.css">
</head>
<body>
    <?php include '../App/Views/administrador/menu_adm.php'; ?>

    <main class="content">
        <header class="page-header">
            <div class="title-group">
                <div class="title-row">
                    <span class="title-mark"></span>
                    <h1>Alterar Senha</h1>
                </div>

                <p class="subtitle">Modifique sua senha.</p>
            </div>
        </header>
        <section class="password-card">
            <div class="card-heading">
                <h2>Meus Dados - Alterar Senha</h2>
                <div class="section-line"></div>
            </div>
            <form class="password-form">
                <div class="password-group">
                    <label for="current-password">Digite a senha atual:</label>
                    <div class="password-input-wrapper">
                        <input id="current-password" class="password-input" type="password">
                        <button type="button" class="password-toggle" data-target="current-password" title="Mostrar/Ocultar senha">
                            <img src="<?=URL?>/public/img/icone_olhoo.png" alt="Mostrar senha" class="eye-icon">
                        </button>
                    </div>
                </div>
                <div class="password-group">
                    <label for="new-password">Digite a nova senha:</label>
                    <div class="password-input-wrapper">
                        <input id="new-password" class="password-input" type="password">
                        <button type="button" class="password-toggle" data-target="new-password" title="Mostrar/Ocultar senha">
                            <img src="<?=URL?>/public/img/icone_olhoo.png" alt="Mostrar senha" class="eye-icon">
                        </button>
                    </div>
                </div>
                <div class="password-group">
                    <label for="confirm-password">Repita a nova senha:</label>
                    <div class="password-input-wrapper">
                        <input id="confirm-password" class="password-input" type="password">

                        <button type="button" class="password-toggle" data-target="confirm-password" title="Mostrar/Ocultar senha">
                            <img src="<?=URL?>/public/img/icone_olhoo.png" alt="Mostrar senha" class="eye-icon">
                        </button>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="password-btn password-btn-primary">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </section>
    </main>
    <?php include '../App/Views/administrador/footer_adm.php'; ?>
    <script src="<?=URL?>/public/js/alterar-senha.js"></script>
</body>
</html>