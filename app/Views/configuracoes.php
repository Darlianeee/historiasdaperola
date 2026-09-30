<!DOCTYPE html>
<html lang="pt-BR">
// teste kal
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Configurações</title>

    <link rel="stylesheet" href="Configuracoes.css">
</head>

<body>
    <main class="container-configuracoes">
        <!-- CABEÇALHO DA PÁGINA -->
        <section class="cabecalho-pagina">
            <h1>Configurações de Acessibilidade</h1>
            <p>Personalize a visualização da página de acordo com suas necessidades.</p>
        </section>

        <!-- PAINEL DE ACESSIBILIDADE -->
        <section class="painel-acessibilidade">

            <!-- TEMA -->
            <div class="grupo-configuracao">
                <h2>Tema</h2>
                <p>Escolha entre o tema claro e o tema escuro.</p>

                <div class="botoes-configuracao">
                    <button
                        type="button"
                        data-acessibilidade-tema="claro">☀️ Claro</button>

                    <button
                        type="button"
                        data-acessibilidade-tema="escuro">🌙 Escuro</button>
                </div>

            </div>


            <!-- TAMANHO DA FONTE -->
            <div class="grupo-configuracao">
                <h2>Tamanho da fonte</h2>
                <p>Ajuste o tamanho dos textos da página.</p>

                <div class="botoes-configuracao">
                    <button type="button" data-acessibilidade-fonte="normal">A Normal</button>

                    <button type="button" data-acessibilidade-fonte="grande">A Grande</button>

                    <button type="button" data-acessibilidade-fonte="muito-grande">A Muito grande</button>
                </div>

            </div>

            <!-- CONTRASTE -->
            <div class="grupo-configuracao">
                <h2>Contraste</h2>

                <p>Ative o alto contraste para facilitar a visualização dos elementos.</p>

                <div class="botoes-configuracao">
                    <button type="button" data-acessibilidade-contraste aria-pressed="false">🌓 Ativar alto contraste</button>
                </div>

            </div>

            <!-- RESTAURAR CONFIGURAÇÕES -->
            <div class="grupo-configuracao restaurar">
                <button type="button" class="botao-restaurar" data-acessibilidade-restaurar> ↩ Restaurar configurações padrão</button>

            </div>

            <!-- STATUS -->
            <div class="acessibilidade-status" id="status">
                Configurações carregadas automaticamente.
            </div>

        </section>
    </main>

    <script src="Configuracoes.js"></script>

</body>
</html>
