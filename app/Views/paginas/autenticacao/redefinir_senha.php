
<?php
// Recebe o token enviado pelo controller. Caso não exista, define uma string vazia.
$token = $token ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Define a codificação de caracteres e a adaptação da página para diferentes telas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Criar nova senha</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/esqueceu_senha.css">

</head>
<body>
    <!-- Container principal que organiza o formulário e a área de identificação do projeto. -->
    <div class="container">

        <!-- Área que contém o formulário para cadastrar uma nova senha. -->
        <div class="formulario">
            <h1>Criar nova senha</h1>
            <p>Escolha a nova senha da sua conta.</p>

            <!-- Exibe mensagens temporárias do sistema, como avisos de erro ou sucesso. -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário responsável por enviar os dados para redefinir a senha. -->
            <form id="form-redefinir-senha"
                  action="<?= URL ?>/paginas/redefinir_senha"
                  method="POST">

                <!-- Campo oculto que envia o token necessário para identificar a solicitação de redefinição. -->
                <input type="hidden" name="token" value="<?= Html::e($token) ?>">

                <!-- Campo para informar a nova senha da conta. -->
                <label for="nova_senha">Nova senha</label>
                <input
                    type="password"
                    id="nova_senha"
                    name="nova_senha"
                    autocomplete="new-password"
                    maxlength="30"
                    placeholder="De 8 a 30 caracteres"
                    required
                >

                <!-- Espaço utilizado para apresentar mensagens de erro relacionadas à nova senha. -->
                <small class="erro-campo" id="erro-nova-senha"></small>

                <!-- Campo para confirmar a nova senha digitada anteriormente. -->
                <label for="confirmar_senha">Confirmar nova senha</label>
                <input
                    type="password"
                    id="confirmar_senha"
                    name="confirmar_senha"
                    autocomplete="new-password"
                    maxlength="30"
                    placeholder="Repita a nova senha"
                    required
                >

                <!-- Espaço utilizado para apresentar mensagens de erro na confirmação da senha. -->
                <small class="erro-campo" id="erro-confirmar-senha"></small>

                <!-- Botão que envia os dados para salvar a nova senha. -->
                <button type="submit">Salvar senha</button>
            </form>
        </div>

        <!-- Área lateral com a identificação e a apresentação do projeto. -->
        <div class="lado-direito">
            <img
                src="<?= URL ?>/public/img/icone_logo_menu.png"
                alt="Logo"
            >
            <h2>HISTÓRIAS NA PÉROLA</h2>
            <p>Conectando culturas através de línguas.</p>
        </div>
    </div>

   
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
    <script src="<?= URL ?>/public/js/redefinir_senha.js"></script>
</body>
</html>
