
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Define a codificação de caracteres e adapta a página a diferentes tamanhos de tela -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador -->
    <title>Cadastro</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página e pelas configurações gerais -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/cadastro.css">

</head>

<body>

<!-- Container que organiza as duas áreas principais da tela de cadastro -->
<div class="container">

    <!-- Área lateral que apresenta a identidade visual do sistema -->
    <div class="lado-direito">

        <!-- Exibe o logotipo e o nome do projeto -->
        <img src="<?= URL ?>/public/img/icone_logo_menu.png" alt="Logo">
        <h2>HISTÓRIAS NA PÉROLA</h2>

        <!-- Apresenta a frase que representa a proposta do sistema -->
        <p>Conectando culturas através de línguas.</p>
    </div>

    <!-- Área que contém o formulário de cadastro -->
    <div class="formulario">

        <!-- Título e descrição da página -->
        <h1>Crie sua conta!</h1>
        <p>Cadastre-se para continuar</p>

        <!-- Exibe mensagens de sucesso ou erro armazenadas na sessão -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Formulário que envia os dados pelo método POST para o cadastro do usuário -->
        <form id="form-cadastro"
              action="<?= URL ?>/usuarios/cadastro_user"
              method="POST">

            <!-- Campo para informar o nome completo -->
            <label for="nome">Nome completo</label>
            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="Digite seu nome"
                autocomplete="name"
                required
            >

            <!-- Área destinada à exibição de mensagens de erro relacionadas ao nome -->
            <small class="erro-campo" id="erro-nome"></small>

            <!-- Campo para informar o endereço de e-mail -->
            <label for="email">E-mail</label>
            <input
                type="text"
                id="email"
                name="email"
                maxlength="100"
                autocomplete="email"
                placeholder="Digite seu e-mail"
                required
            >

            <!-- Área destinada à exibição de mensagens de erro relacionadas ao e-mail -->
            <small class="erro-campo" id="erro-email"></small>

            <!-- Campo para informar a senha da conta -->
            <label for="senha">Senha</label>

            <!-- Agrupa o campo de senha e o botão para mostrar ou ocultar seu conteúdo -->
            <div class="campo-senha">
                <input
                    type="password"
                    id="senha"
                    name="senha"
                    minlength="8"
                    maxlength="30"
                    placeholder="Digite sua senha"
                    autocomplete="new-password"
                    required
                >
                
            <!-- Botão utilizado para alternar a visualização da senha -->
            <button type="button" id="mostrar-senha" aria-label="Mostrar senha">

                <!-- Ícone de olho criado em SVG para representar a visualização da senha -->
                <svg id="icone-olho" viewBox="0 0 24 24"
                    width="20" height="20" fill="none"
                    stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round">

                    <!-- Desenha o contorno do olho -->
                    <path id="olho-contorno"
                        d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>

                    <!-- Desenha a parte central do olho -->
                    <circle id="olho-pupila" cx="12" cy="12" r="2.5"/>

                    <!-- Desenha um risco sobre o olho, inicialmente oculto -->
                    <path id="olho-risco" d="M4 4 20 20" style="display: none;"/>
                </svg>
            </button>
            </div>

            <!-- Área destinada à exibição de mensagens de erro relacionadas à senha -->
            <small class="erro-campo" id="erro-senha"></small>


            <!-- Botão que envia os dados preenchidos para realizar o cadastro -->
            <button type="submit">Cadastrar</button>
        </form>

        <!-- Área para quem já possui uma conta acessar a página de login -->
        <p class="login">
            Já tem uma conta?
            <a href="<?= URL ?>/paginas/login">Entrar</a>
        </p>
    </div>

</div>

<!-- Importa o JavaScript responsável pelo filtro de caracteres dos campos -->
<script src="<?= URL ?>/public/js/filtro-caracteres.js"></script>

<!-- Importa o JavaScript responsável pelas funcionalidades e validações do cadastro -->
<script src="<?= URL ?>/public/js/cadastro.js"></script>

<!-- Importa o JavaScript responsável pelas funcionalidades gerais de configuração -->
<script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>
</html>
