
<?php
// Recupera o nome do administrador logado. Caso esteja vazio, utiliza o texto "Nome".
$nome = Sessao::nome() !== '' ? Sessao::nome() : 'Nome';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página a diferentes tamanhos de tela -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador -->
    <title>Início - Histórias na Pérola</title>
    
    <!-- Importa os arquivos CSS responsáveis pela aparência da página inicial e pelas configurações gerais -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/inicio_adm.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
</head>

<body>

    <!-- Inclui o menu de navegação do administrador -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal do conteúdo da página -->
    <main class="conteudo">

        <!-- Cabeçalho que apresenta o título e a mensagem de boas-vindas -->
        <header class="cabecalho-inicio">

            <!-- Exibe o título da página inicial -->
            <div class="titulo"><h1>Início</h1></div>

            <!-- Apresenta uma mensagem de boas-vindas com o nome do administrador -->
            <p class="boas-vindas">Bem-vindo, <?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>!</p>
        </header>

        <!-- Exibe mensagens de sucesso ou erro armazenadas na sessão -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Apresenta uma frase de destaque sobre a proposta do sistema -->
        <h2>
            Explore, conheça e valorize histórias em diferentes línguas!
        </h2>

        <!-- Área que reúne os cartões informativos da página inicial -->
        <div class="cards-inicio">

            <!-- Cartão que apresenta as diferenças entre mitos e lendas -->
            <section class="card card-mito">

                <h3>
                    Existe diferença entre lenda e mito?
                </h3>

                <!-- Conteúdo explicativo sobre as características dos mitos e das lendas -->
                <div class="texto-card">

                    <p>
                        Sim! Apesar de serem histórias tradicionais transmitidas
                        de geração em geração, mitos e lendas possuem algumas
                        diferenças. Os mitos geralmente estão ligados a deuses,
                        seres sobrenaturais e explicações sobre a origem do mundo,
                        da natureza ou de determinados acontecimentos.
                    </p>

                    <p>
                        Já as lendas costumam misturar fatos reais com elementos
                        fantásticos e estão relacionadas à cultura, aos costumes
                        e às histórias de um povo.
                    </p>

                    <p>
                        Ambos fazem parte da cultura e da tradição de diferentes
                        comunidades, ajudando a preservar histórias, conhecimentos
                        e valores ao longo do tempo.
                    </p>

                </div>

            </section>

            <!-- Cartão que apresenta o acesso ao gerenciamento das histórias -->
            <section class="card card-gerenciar">

                <h3>
                    Gerencie as histórias da Pérola
                </h3>

                <!-- Explica as ações que o administrador pode realizar na plataforma -->
                <p>
                    Aqui você pode editar histórias existentes, adicionar
                    novas histórias ou excluir histórias da plataforma.
                </p>

                <!-- Direciona para a página de gerenciamento das histórias -->
                <a href="<?= URL ?>/administrador/gerenciar_historia_adm" class="btn-historias">
                    Gerenciar histórias
                </a>

            </section>

        </div>

    </main>

    <!-- Inclui o rodapé utilizado nas páginas do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas funcionalidades gerais de configuração -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
