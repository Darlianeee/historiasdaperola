<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CadastroAdm</title>
    <link rel="stylesheet" href="<?=URL?>/public/css/cadastro_user.css">
</head>
<body>

<div class="container">

    <!-- Bloco Verde da Marca (Aparece PRIMEIRO no celular) -->
    <div class="lado-direito">
        <img src="<?=URL?>/public/img/icone_logo_menu.png" alt="Logo">
        <h2>HISTÓRIAS NA PÉROLA</h2>
        <p>Conectando culturas através de histórias</p>
    </div>

    <!-- Bloco Branco do Formulário (Aparece DEPOIS no celular) -->
    <div class="formulario">
        <h1>Cadastre-se!</h1>
        <p>Crie sua conta para começar</p>

        <form>
            <label>Nome Completo</label>
            <input type="text">

            <label>SIAPE</label>
            <input type="text">

            <label>E-mail</label>
            <input type="email">

            <label>Senha</label>
            <input type="password">

            <button type="submit">Entrar</button>
        </form>

        <p class="login">
            Já tem uma conta? <a href="<?=URL?>/administrador/login_adm">Login</a>
        </p>
    </div>

</div>

</body>
</html>
