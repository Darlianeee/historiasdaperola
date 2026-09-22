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
                <p class="subtitle">
                    Altere seus dados.
                </p>
            </div>
        </header>

        <section class="profile-card">
            <h2>Editar Meus Dados</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="profile-grid">

                    <div class="profile-aside">

                        <div class="avatar-frame">

                            <img id="previewFoto" src="<?=URL?>/img/foto_perfil.png" alt="Foto de perfil">
                            <label for="fotoPerfil" class="avatar-edit" title="Alterar foto">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M9 3L7.5 5H5C3.9 5 3 5.9 3 7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V7C21 5.9 20.1 5 19 5H16.5L15 3H9Z"/>
                                    <circle cx="12" cy="12.5" r="3.5"/>
                                </svg>
                            </label>
                            <input type="file" id="fotoPerfil"name="fotoPerfil" accept="image/*" hidden>
                        </div>

                        <div class="profile-actions">
                            <button type="submit"class="profile-btn profile-btn-primary">
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
                                <p class="info-label">
                                    Nome Completo
                                </p>
                                <input class="info-input" type="text" name="nome" value="Nome Completo">
                            </div>
                        </div>



                        <!-- E-MAIL -->

                        <div class="info-item">


                            <span class="info-icon">

                                <img
                                    src="<?=URL?>/img/icone_email.png"
                                    alt="Ícone de E-mail"
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



                        <!--MATRICULA -->

                        <div class="info-item">


                            <span class="info-icon">

                                <img
                                    src="<?=URL?>/img/icone_matricula.png"
                                    alt="Ícone de Matrícula"
                                >

                            </span>


                            <div class="info-content">


                                <p class="info-label">
                                    Matrícula
                                </p>


                                <input
                                    class="info-input"
                                    type="text"
                                    name="suap"
                                    value="0000000000000"
                                    readonly
                                >


                            </div>


                        </div>


                    </div>


                </div>


            </form>


        </section>


    </main>



    <!-- =====================================================
         MODAL DE EDIÇÃO DA FOTO
    ====================================================== -->

    <div
        class="photo-modal"
        id="photoModal"
    >


        <div class="photo-modal-content">


            <!-- CABEÇALHO -->

            <div class="photo-modal-header">

                <h2>Ajustar foto</h2>


                <button
                    type="button"
                    class="close-photo-modal"
                    id="fecharModal"
                >
                    &times;
                </button>

            </div>



            <!-- ÁREA DA FOTO -->

            <div
                class="crop-area"
                id="cropArea"
            >

                <img
                    id="cropImage"
                    src=""
                    alt="Imagem para ajuste"
                    draggable="false"
                >


                <div class="crop-circle"></div>

            </div>



            <!-- ZOOM -->

            <div class="photo-controls">


                <button
                    type="button"
                    id="zoomMenos"
                    class="zoom-button"
                >
                    −
                </button>


                <input
                    type="range"
                    id="zoomSlider"
                    min="1"
                    max="3"
                    step="0.01"
                    value="1"
                >


                <button
                    type="button"
                    id="zoomMais"
                    class="zoom-button"
                >
                    +
                </button>


            </div>


            <p class="crop-help">
                Arraste a foto para ajustar a posição.
            </p>



            <!-- BOTÕES -->

            <div class="photo-modal-actions">


                <button
                    type="button"
                    class="modal-button modal-cancel"
                    id="cancelarFoto"
                >
                    Cancelar
                </button>


                <button
                    type="button"
                    class="modal-button modal-confirm"
                    id="usarFoto"
                >
                    Usar foto
                </button>


            </div>


        </div>


    </div>

    <?php include '../App/Views/usuarios/footer_user.php'; ?>
    <script src="<?=URL?>/public/js/foto_perfil.js"></script>

</body>

</html>