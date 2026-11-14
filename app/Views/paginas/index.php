<?php
// Define o texto que será apresentado abaixo do título da página.
$subtitulo = "Explore mitos e lendas e conheça as histórias da região.";

// Recebe a lista de histórias enviada pelo controller. Caso não exista, define um array vazio.
$historias = $historias ?? [];

// Recebe o termo digitado na busca. Caso não exista, define uma string vazia.
$busca = $busca ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e a adaptação da página para diferentes telas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Catálogo de Histórias - Histórias na Pérola</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência e pelas configurações da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/escolher_historia_user.css">

</head>

<body>

    <!-- Inclui o cabeçalho público compartilhado entre as páginas do sistema. -->
    <?php include APP . '/Views/paginas/cabecalho_publico.php'; ?>

    <!-- Área principal que apresenta o catálogo de histórias. -->
    <main class="conteudo">

        <!-- Título e descrição da página. -->
        <h1>Histórias</h1>
        <p class="subtitulo"><?= Html::e($subtitulo) ?></p>

        <!-- Área que contém o campo de pesquisa das histórias. -->
        <div class="busca-container">
            <!-- Formulário que envia o termo pesquisado para a página inicial pelo método GET. -->
            <form action="<?= URL ?>/paginas/index" method="GET" class="busca-box">

                <!-- Exibe o ícone utilizado para representar a pesquisa. -->
                <span class="icone-busca" aria-hidden="true"><img src="<?= URL ?>/public/img/LUPA2.png" alt=""></span>

                <!-- Campo onde o visitante pode digitar o título de um mito ou lenda. -->
                <!-- Mantém o termo pesquisado preenchido após a atualização da página. -->
                <input type="text" name="busca" value="<?= Html::e($busca) ?>" aria-label="Buscar história pelo título" placeholder="Digite o nome de uma lenda ou de um mito...">
            </form>
        </div>

        <!-- Área responsável por organizar os cards das histórias cadastradas. -->
        <section class="grid-historias">

            <!-- Verifica se não existem histórias disponíveis para exibição. -->
            <?php if (empty($historias)): ?>

                <!-- Exibe uma mensagem diferente dependendo de ter sido realizada uma pesquisa ou não. -->
                <p class="sem-historias"><?= $busca !== '' ? 'Nenhuma história encontrada para “' . Html::e($busca) . '”.' : 'Nenhuma história cadastrada ainda.' ?></p>

            <?php endif; ?>

            <!-- Percorre a lista de histórias para apresentar cada uma em um card. -->
            <?php foreach ($historias as $item): ?>

                <!-- Card que reúne as informações de uma história. -->
                <article class="card-item">

                    <!-- Área destinada à imagem da história. -->
                    <div class="card-imagem">

                        <!-- Verifica se a história possui uma imagem cadastrada antes de exibi-la. -->
                        <?php if (!empty($item->imagem)): ?>
                            <img src="<?= Html::e($item->imagem) ?>" alt="<?= Html::e($item->titulo) ?>">
                        <?php endif; ?>

                    </div>

                    <!-- Área que apresenta o título, a categoria e o botão de acesso à história. -->
                    <div class="card-info">

                        <div class="card-texto">

                            <!-- Exibe o título da história. -->
                            <div class="card-titulo"><?= Html::e($item->titulo) ?></div>

                            <!-- Exibe a categoria da história. -->
                            <div class="card-categoria"><?= Html::e($item->categoria) ?></div>

                        </div>

                        <!-- Direciona o visitante para o login, enviando o identificador da história selecionada. -->
                        <a href="<?= URL ?>/paginas/login?historia=<?= (int) $item->id ?>" class="btn-ler">Ler história</a>

                    </div>
                </article>

            <?php endforeach; ?>
        </section>
    </main>

    <!-- Importa o JavaScript responsável pelas funcionalidades das configurações de acessibilidade. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>

</body>

</html>