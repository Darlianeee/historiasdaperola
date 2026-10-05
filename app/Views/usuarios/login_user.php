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

    
    <div class="lado-direito">
        <img src="<?=URL?>/public/img/icone_logo_menu.png" alt="Logo">
        <h2>HISTÓRIAS NA PÉROLA</h2>
        <p>Conectando culturas através de línguas.</p>
    </div>

    
    <div class="formulario">
        <h1>Bem-vindo de volta!</h1>
        <p>Entre para continuar</p>

        <form>
            
            <label>Matrícula</label>
            <input type="text" id="matricula" name="matricula">



            <label>Senha</label>
            <input type="password" id="senha" name="senha">

            <button type="submit" id="botao-entrar">Entrar</button>

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
