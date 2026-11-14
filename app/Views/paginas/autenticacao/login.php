
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Define a codificação de caracteres e a adaptação da página para diferentes telas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Login</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/login.css">

</head>

<body>
    <!-- Container principal que organiza a área da logo e o formulário de login. -->
    <div class="container">

        <!-- Área lateral com a identificação do projeto. -->
        <div class="lado-direito">
            <img src="<?= URL ?>/public/img/icone_logo_menu.png" alt="Logo">
            <h2>HISTÓRIAS NA PÉROLA</h2>
            <p>Conectando culturas através de línguas.</p>
        </div>

        <!-- Área que contém os campos e as opções de acesso à conta. -->
        <div class="formulario">
            <h1>Bem-vindo de volta!</h1>
            <p>Entre para continuar</p>

            <!-- Exibe mensagens temporárias do sistema, como avisos de erro ou sucesso. -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário responsável por enviar os dados de login ao sistema. -->
            <form id="form-login"
                  action="<?= URL ?>/paginas/login"
                  method="POST">

                <!-- Campo para informar o e-mail cadastrado. -->
                <label for="email">E-mail</label>

                <input
                    type="text"
                    id="email"
                    name="email"
                    autocomplete="email"
                    placeholder="Digite seu e-mail"
                    required
                >

                <!-- Espaço utilizado para exibir mensagens de erro relacionadas ao e-mail. -->
                <small class="erro-campo" id="erro-email"></small>

                <!-- Identifica o campo destinado à senha do usuário. -->
                <label for="senha">Senha</label>

                <!-- Agrupa o campo de senha e o botão para mostrar ou ocultar o conteúdo. -->
                <div class="campo-senha">
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        autocomplete="current-password"
                        placeholder="Digite sua senha"
                        required
                    >

                    <!-- Botão que permite alternar a visualização da senha. -->
                    <button type="button" id="mostrar-senha" aria-label="Mostrar senha">

                        <!-- Ícone de olho utilizado para indicar a opção de visualizar a senha. -->
                        <svg id="icone-olho" viewBox="0 0 24 24"
                            width="20" height="20" fill="none"
                            stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round">

                            <!-- Desenha o contorno do olho. -->
                            <path id="olho-contorno"
                                d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>

                            <!-- Desenha a parte central do olho. -->
                            <circle id="olho-pupila" cx="12" cy="12" r="2.5"/>

                            <!-- Representa o risco que indica que a senha está oculta. -->
                            <path id="olho-risco" d="M4 4 20 20" style="display: none;"/>
                        </svg>
                    </button>
                </div>

                <!-- Espaço utilizado para apresentar mensagens de erro relacionadas à senha. -->
                <small class="erro-campo" id="erro-senha"></small>

                <!-- Botão que envia os dados preenchidos para realizar o login. -->
                <button type="submit">Entrar</button>
            </form>

            <!-- Apresenta o link para acessar a página de recuperação de senha. -->
            <p class="esqueceu">
                <a href="<?= URL ?>/paginas/esqueceu_senha">
                    Esqueceu senha?
                </a>
            </p>

            <!-- Apresenta a opção de cadastro para quem ainda não possui uma conta. -->
            <p class="login">
                Ainda não tem uma conta?
                <a href="<?= URL ?>/paginas/cadastro">
                    Cadastre-se
                </a>
            </p>
        </div>
    </div>

    <!-- Importa os arquivos JavaScript responsáveis pelas validações e funcionalidades da página. -->
    <script src="<?= URL ?>/public/js/filtro-caracteres.js"></script>
    <script src="<?= URL ?>/public/js/login.js"></script>

    <!-- Importa o script responsável pelas funcionalidades das configurações de acessibilidade. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>
</html>
