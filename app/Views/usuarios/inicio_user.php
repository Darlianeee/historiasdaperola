<?php
// Verifica se existe um nome salvo na sessão. Caso contrário, utiliza o texto "Nome".
$nome = Sessao::nome() !== '' ? Sessao::nome() : 'Nome';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Início - Histórias na Pérola</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/inicio_user.css">
</head>

<body>

    <!-- Inclui o menu de navegação do usuário. -->
    <?php include APP . '/Views/usuarios/menu_user.php'; ?>

    <main class="conteudo">

        <!-- Cabeçalho da página inicial com o título e a mensagem de boas-vindas. -->
        <header class="cabecalho-inicio">
            <div class="titulo">
                <h1>Início</h1>
            </div>

            <!-- Exibe o nome do usuário que está conectado. -->
            <p class="boas-vindas">Bem-vindo, <?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>!</p>
        </header>

        <!-- Exibe mensagens de sucesso ou erro, caso existam. -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Apresenta uma mensagem de incentivo para explorar as histórias. -->
        <h2>
            Explore, conheça e valorize histórias em diferentes línguas!
        </h2>

        <!-- Área que organiza os cartões apresentados na página inicial. -->
        <div class="cards-inicio">

            <!-- Cartão que explica a diferença entre mitos e lendas. -->
            <section class="card card-mito">

                <h3>
                    Existe diferença entre lenda e mito?
                </h3>

                <div class="texto-card">

                    <!-- Apresenta as principais características que diferenciam mitos e lendas. -->
                    <p>
                        Sim! Apesar de serem histórias tradicionais transmitidas de geração
                        em geração, mitos e lendas possuem algumas diferenças. Os mitos
                        geralmente estão ligados a deuses, seres sobrenaturais e explicações
                        sobre a origem do mundo, da natureza ou de determinados acontecimentos.
                        Já as lendas costumam misturar fatos reais com elementos fantásticos e
                        estão relacionadas à cultura, aos costumes e às histórias de um povo.
                    </p>

                    <!-- Explica a importância dos mitos e das lendas para a preservação cultural. -->
                    <p>
                        Ambos fazem parte da cultura e da tradição de diferentes comunidades,
                        ajudando a preservar histórias, conhecimentos e valores ao longo do tempo.
                    </p>

                </div>

            </section>

            <!-- Cartão que convida o usuário a conhecer as histórias disponíveis no sistema. -->
            <section class="card card-explorar">

                <h3>
                    Que tal conhecer uma história?
                </h3>

                <p>
                    Descubra mitos e lendas de diferentes culturas e conheça
                    histórias que atravessaram gerações.
                </p>

                <!-- Botão que direciona o usuário para o catálogo de histórias. -->
                <a href="<?= URL ?>/usuarios/escolher_historia_user" class="btn-historias">
                    Explorar histórias
                </a>

            </section>

        </div>

    </main>

    <!-- Inclui o rodapé compartilhado do projeto. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas configurações de acessibilidade e aparência. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>