
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Perfil</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/editar_perfil_adm.css">
</head>

<body>

    <?php include '../App/Views/administrador/menu_adm.php'; ?>


    <main class="content">

        <!-- =========================================
             CABEÇALHO
        ========================================== -->

        <header class="page-header">

            <div class="title-group">

                <div class="title-row">

                    <span class="title-mark"></span>

                    <h1>Editar Perfil</h1>

                </div>

                <p class="subtitle">
                    Altere seus dados.
                </p>

            </div>

        </header>


        <!-- =========================================
             CARD
        ========================================== -->

        <section class="profile-card">

            <h2>Editar Meus Dados</h2>


            <form>


                <div class="profile-grid">


                    <!-- =========================================
                         LADO ESQUERDO
                    ========================================== -->

                    <div class="profile-aside">

                        <div class="avatar-frame">

                            <img
                                src="<?=URL?>/img/foto_perfil.png"
                                alt="Avatar"
                            >

                        </div>


                        <div class="profile-actions">


                            <button
                                type="submit"
                                class="profile-btn profile-btn-primary"
                            >
                                Salvar Alterações
                            </button>


                            <a
                                href="<?=URL?>/administrador/alterar_senha_adm"
                                class="profile-btn profile-btn-secondary"
                            >
                                Alterar senha
                            </a>


                        </div>

                    </div>


                    <!-- =========================================
                         INFORMAÇÕES
                    ========================================== -->

                    <div class="info-grid">


                        <!-- NOME -->

                        <div class="info-item">

                            <span class="info-icon">

                                <img
                                    src="<?=URL?>/img/icone_nome.png"
                                    alt="Ícone de Nome"
                                >

                            </span>


                            <div class="info-content">

                                <p class="info-label">
                                    Nome Completo
                                </p>

                                <input
                                    class="info-input"
                                    type="text"
                                    name="nome"
                                    value="Nome Completo"
                                >

                            </div>

                        </div>


                        <!-- E-MAIL -->

                        <div class="info-item">

                            <span class="info-icon">

                                <img
                                    src="<?=URL?>/img/icone_email.png"
                                    alt="Ícone de Email"
                                >

                            </span>


                            <div class="info-content">

                                <p class="info-label">
                                    E-mail
                                </p>

                                <input
                                    class="info-input"
                                    type="email"
                                    name="email"
                                    value="nome@ifro.edu.br"
                                >

                            </div>

                        </div>


                        <!-- SIAPE -->

                        <div class="info-item">

                            <span class="info-icon">

                                <img
                                    src="<?=URL?>/img/icone_matricula.png"
                                    alt="Ícone de SIAPE"
                                >

                            </span>


                            <div class="info-content">

                                <p class="info-label">
                                    SIAPE
                                </p>

                                <input
                                    class="info-input"
                                    type="text"
                                    name="siape"
                                    value="0000000"
                                    readonly
                                >

                            </div>

                        </div>


                        <!-- SETOR -->

                        <div class="info-item">

                            <span class="info-icon">

                                <img
                                    src="<?=URL?>/img/icone_setor.png"
                                    alt="Ícone de Setor"
                                >

                            </span>


                            <div class="info-content">

                                <p class="info-label">
                                    Setor
                                </p>

                                <input
                                    class="info-input"
                                    type="text"
                                    name="setor"
                                    value="Algum lugar"
                                >

                            </div>

                        </div>


                    </div>

                </div>

            </form>

        </section>

    </main>


    <?php include '../App/Views/administrador/footer_adm.php'; ?>

</body>

</html>