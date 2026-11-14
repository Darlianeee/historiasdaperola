
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e a adaptação da página para diferentes telas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Configurações</title>

    <!-- Importa o arquivo CSS responsável pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
</head>

<body>

    <?php
        // Verifica se o usuário possui perfil de administrador ou se está logado como usuário.
        // Em seguida, inclui o menu correspondente ao perfil identificado.
        if (Sessao::ehAdministrador()) {
            include APP . '/Views/administrador/menu_adm.php';
        } elseif (Sessao::estaLogado()) {
            include APP . '/Views/usuarios/menu_user.php';
        }
    ?>

    <!-- Área principal que reúne as opções de personalização da página. -->
    <main class="container-configuracoes">

        <!-- Cabeçalho com o título e a descrição da página. -->
        <section class="cabecalho-pagina">
            <h1>Configurações</h1>
            <p>Personalize a visualização da página de acordo com suas necessidades.</p>
        </section>

        <!-- Painel que reúne as opções de acessibilidade disponíveis no sistema. -->
        <section class="painel-acessibilidade">

            <!-- Opções para alterar o tema da página. -->
            <div class="grupo-configuracao">
                <h2>Tema</h2>
                <p>Escolha entre o tema claro e o tema escuro.</p>

                <div class="botoes-configuracao">
                    <!-- Botão que permite selecionar o tema claro. -->
                    <button type="button" data-acessibilidade-tema="claro">
                        ☀️ Claro
                    </button>

                    <!-- Botão que permite selecionar o tema escuro. -->
                    <button type="button" data-acessibilidade-tema="escuro">
                        🌙 Escuro
                    </button>
                </div>
            </div>

            <!-- Opções para aumentar o tamanho dos textos da página. -->
            <div class="grupo-configuracao">
                <h2>Tamanho da fonte</h2>
                <p>Ajuste o tamanho dos textos da página.</p>

                <div class="botoes-configuracao">
                    <!-- Mantém o tamanho padrão dos textos. -->
                    <button type="button" data-acessibilidade-fonte="normal">
                        Normal
                    </button>

                    <!-- Aumenta o tamanho dos textos. -->
                    <button type="button" data-acessibilidade-fonte="grande">
                        Grande
                    </button>

                    <!-- Aplica um aumento ainda maior no tamanho dos textos. -->
                    <button type="button" data-acessibilidade-fonte="muito-grande">
                        Muito grande
                    </button>
                </div>
            </div>

            <!-- Opção para ativar o alto contraste e facilitar a visualização dos elementos. -->
            <div class="grupo-configuracao">
                <h2>Contraste</h2>
                <p>
                    Ative o alto contraste para facilitar a visualização
                    dos elementos.
                </p>

                <div class="botoes-configuracao">
                    <!-- Botão que ativa ou desativa o alto contraste da página. -->
                    <!-- O atributo aria-pressed informa o estado atual do botão para tecnologias assistivas. -->
                    <button
                        type="button"
                        data-acessibilidade-contraste
                        aria-pressed="false">
                        🌓 Ativar alto contraste
                    </button>
                </div>
            </div>

            <!-- Opção para retornar às configurações originais de acessibilidade. -->
            <div class="grupo-configuracao restaurar">
                <button
                    type="button"
                    class="botao-restaurar"
                    data-acessibilidade-restaurar>
                    ↩ Restaurar configurações padrão
                </button>
            </div>

            <!-- Área que apresenta mensagens sobre o estado das configurações de acessibilidade. -->
            <!-- role e aria-live permitem que leitores de tela identifiquem as atualizações dessa mensagem. -->
            <div
                class="acessibilidade-status"
                id="status"
                role="status"
                aria-live="polite">
                Configurações carregadas automaticamente.
            </div>

        </section>
    </main>

    <!-- Importa o JavaScript responsável por aplicar as alterações de acessibilidade. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>

    <!-- Inclui o rodapé compartilhado entre as páginas do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Componente responsável por disponibilizar o recurso de tradução em Libras. -->
    <div vw class="enabled">
        <!-- Botão utilizado para abrir o recurso de tradução em Libras. -->
        <div vw-access-button class="active"></div>

        <!-- Área onde o componente do VLibras é exibido. -->
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>

    <!-- Importa o script oficial necessário para inicializar o VLibras. -->
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>

</body>
</html>
