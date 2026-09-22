<!DOCTYPE html> 
<html lang="pt-BR"> 

<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Meu Perfil</title> 
 
    <link rel="stylesheet" href="<?=URL?>/public/css/perfil_adm.css"> 
</head> 

<body> 

    <?php include '../App/Views/administrador/menu_adm.php'; ?>

    <main class="content"> 

        <header class="page-header"> 
            <div class="title-group"> 
                <div class="title-row"> 
                    <span class="title-mark"></span> 
                    <h1>Meu Perfil</h1> 
                </div> 
 
                <p class="subtitle">Visualize e gerencie suas informações pessoais.</p> 
            </div> 
        </header> 

        <section class="profile-card"> 

            <h2>Meus Dados</h2> 

            <div class="profile-grid"> 

                <div class="profile-aside"> 

                    <div class="avatar-frame"> 
                        <img src="<?=URL?>/img/foto_perfil.png" alt="Avatar"> 
                    </div> 

                    <div class="profile-actions"> 

                        <a href="<?=URL?>/administrador/editar_perfil_adm" class="profile-btn profile-btn-primary"> 
                            Editar perfil 
                        </a> 

                        <a href="<?=URL?>/administrador/alterar_senha_adm" class="profile-btn profile-btn-secondary"> 
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
                            <p class="info-value">Nome Completo</p> 
                        </div> 
                    </div> 

                    <div class="info-item"> 
                        <span class="info-icon"> 
                            <img src="<?=URL?>/img/icone_email.png" alt="Ícone de Email"> 
                        </span> 

                        <div class="info-content"> 
                            <p class="info-label">E-mail</p> 
                            <p class="info-value">nome@ifro.edu.br</p> 
                        </div> 
                    </div> 

                    <div class="info-item"> 
                        <span class="info-icon"> 
                            <img src="<?=URL?>/img/icone_matricula.png" alt="Ícone de Matrícula"> 
                        </span> 

                        <div class="info-content"> 
                            <p class="info-label">Matrícula</p> 
                            <p class="info-value">0000000</p> 
                        </div> 
                    </div> 

                    <div class="info-item"> 
                        <span class="info-icon"> 
                            <img src="<?=URL?>/img/icone_setor.png" alt="Ícone de Setor"> 
                        </span> 

                        <div class="info-content"> 
                            <p class="info-label">Setor</p> 
                            <p class="info-value">Algum lugar</p> 
                        </div> 
                    </div> 

                </div> 

            </div> 

        </section> 

    </main> 

    <?php include '../App/Views/administrador/footer_adm.php'; ?>

</body> 

</html>