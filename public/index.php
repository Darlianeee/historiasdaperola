<?php 
include '../app/configuracao.php'; 
include '../app/Autoload.php'; 
?>

<!DOCTYPE html> 
<html lang="pt-br"> 

<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    
    <title><?= APP_NAME ?></title> 

    <link rel="stylesheet" href="<?=URL?>/public/css/footer.css"/>
    <link rel="stylesheet" href="<?=URL?>/public/css/header_adm.css"/>
    <link rel="stylesheet" href="<?=URL?>/public/css/header_user.css"/>
    <link rel="stylesheet" href="<?=URL?>/public/css/perfil_usuario.css"/>
    <link rel="stylesheet" href="<?=URL?>/public/css/perfil_adm.css"/>
    <link rel="stylesheet" href="<?=URL?>/public/css/editar_perfil_user.css"/>
    <link rel="stylesheet" href="<?=URL?>/public/css/alterar_senha.css"/>
    <link rel="stylesheet" href="<?=URL?>/public/css/sair.css"/>

</head> 

<body> 

    <?php 
        $rotas = new Rota(); 
    ?>
    
</body> 
</html>