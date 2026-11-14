
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

    <!-- Script responsável por validar os campos antes de enviar o formulário. -->
    <script>
        // Aguarda o carregamento completo do HTML para executar as funcionalidades.
        document.addEventListener("DOMContentLoaded", function () {

            // Busca os elementos do formulário e os campos de senha.
            const formulario = document.getElementById("form-redefinir-senha");
            const nova = document.getElementById("nova_senha");
            const confirmar = document.getElementById("confirmar_senha");

            // Busca os espaços onde serão exibidas as mensagens de erro.
            const erroNova = document.getElementById("erro-nova-senha");
            const erroConfirmar = document.getElementById("erro-confirmar-senha");

            // Verifica se a nova senha possui pelo menos 8 caracteres.
            function conferirNova() {
                if (nova.value.length > 0 && nova.value.length < 8) {
                    erroNova.textContent = "A senha precisa ter pelo menos 8 caracteres.";
                    return false;
                }

                // Limpa a mensagem de erro quando a senha atende ao tamanho mínimo.
                erroNova.textContent = "";
                return nova.value.length >= 8;
            }

            // Verifica se a confirmação é igual à nova senha.
            function conferirConfirmacao() {
                if (confirmar.value.length > 0 && confirmar.value !== nova.value) {
                    erroConfirmar.textContent = "As senhas não são iguais.";
                    return false;
                }

                // Limpa a mensagem de erro quando as senhas são iguais.
                erroConfirmar.textContent = "";
                return confirmar.value === nova.value;
            }

            // Verifica a nova senha sempre que o usuário digita ou altera seu conteúdo.
            nova.addEventListener("input", function () {
                conferirNova();
                conferirConfirmacao();
            });

            // Verifica a confirmação sempre que o usuário digita ou altera seu conteúdo.
            confirmar.addEventListener("input", conferirConfirmacao);

            // Realiza as validações antes de permitir o envio do formulário.
            formulario.addEventListener("submit", function (evento) {
                const novaOk = conferirNova();
                const confirmarOk = conferirConfirmacao();

                // Impede o envio caso alguma das senhas não esteja correta.
                if (!novaOk || !confirmarOk) {
                    evento.preventDefault();

                    // Direciona o cursor para o primeiro campo que precisa ser corrigido.
                    if (!novaOk) {
                        nova.focus();
                    } else {
                        confirmar.focus();
                    }
                }
            });
        });
    </script>

    <!-- Importa o JavaScript responsável pelas funcionalidades das configurações de acessibilidade. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>
</html>
