
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página a diferentes tamanhos de tela -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador -->
    <title>Esqueceu a senha?</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página e pelas configurações gerais -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/esqueceu_senha.css">

</head>

<body>

    <!-- Container que organiza o formulário e a área de identificação do sistema -->
    <div class="container">

        <!-- Área que contém o formulário de recuperação de senha -->
        <div class="formulario">

            <!-- Título e instrução para iniciar a recuperação da senha -->
            <h1>Esqueceu a senha?</h1>
            <p>Digite seu e-mail e enviaremos um link para criar uma nova senha.</p>

            <!-- Exibe mensagens de sucesso ou erro armazenadas na sessão -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário que envia o e-mail informado pelo método POST -->
            <form id="form-esqueceu-senha"
                action="<?= URL ?>/paginas/esqueceu_senha"
                method="POST">

                <!-- Campo para informar o e-mail cadastrado na conta -->
                <label for="email">E-mail</label>
                <input
                    type="text"
                    id="email"
                    name="email"
                    autocomplete="email"
                    placeholder="Digite seu e-mail"
                    required>

                <!-- Área destinada à exibição de mensagens de erro relacionadas ao e-mail -->
                <small class="erro-campo" id="erro-email"></small>

                <!-- Botão que envia o formulário para solicitar a recuperação da senha -->
                <button type="submit" id="botao-enviar">Enviar</button>
            </form>

            <!-- Link que permite retornar à página de login -->
            <p class="voltar-login">
                <a href="<?= URL ?>/paginas/login">Voltar para o login</a>
            </p>
        </div>

        <!-- Área lateral que apresenta a identidade visual do sistema -->
        <div class="lado-direito">

            <!-- Exibe o logotipo do projeto -->
            <img
                src="<?= URL ?>/public/img/icone_logo_menu.png"
                alt="Logo">

            <!-- Apresenta o nome e a frase de identificação do sistema -->
            <h2>HISTÓRIAS NA PÉROLA</h2>
            <p>Conectando culturas através de línguas.</p>
        </div>
    </div>

    <!-- Importa o JavaScript responsável pelas funcionalidades gerais de configuração -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>

    <!-- Importa o JavaScript responsável pelas funcionalidades da recuperação de senha -->
    <script src="<?= URL ?>/public/js/esqueceu_senha.js"></script>
</body>

</html>
