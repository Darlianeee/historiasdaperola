<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?=URL?>/public/css/login_user.css">
</head>
<body>

<div class="container">

    <!-- Bloco Verde da Marca (Aparece PRIMEIRO no celular) -->
    <div class="lado-direito">
        <img src="<?=URL?>/public/img/icone_logo_menu.png" alt="Logo">
        <h2>HISTÓRIAS NA PÉROLA</h2>
        <p>Conectando culturas através de línguas.</p>
    </div>

    <!-- Bloco Branco do Formulário (Aparece DEPOIS no celular) -->
    <div class="formulario">
        <h1>Bem-vindo de volta!</h1>
        <p>Entre para continuar</p>

        <form>
            
            <label>SUAP</label>
            <input type="text">


            <label>Senha</label>
            <input type="password">

            <button type="submit">Entrar</button>

        </form>
        <p class="esqueceu">
           <a href="<?=URL?>/paginas/esqueceu_senha">Recuperar senha</a>
        </p>
        <p class="login">
            Ainda não tem uma conta? <a href="<?=URL?>/usuarios/cadastro_user">Cadastre-se</a>
        </p>
    </div>

</div>

</body>
</html>
