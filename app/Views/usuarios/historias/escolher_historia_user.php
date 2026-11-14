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

    <!-- Inclui o menu de navegação da área do usuário. -->
    <?php include APP . '/Views/usuarios/menu_user.php'; ?>

    <!-- Área principal que apresenta o catálogo de histórias. -->
    <main class="conteudo">

        <!-- Título da página. -->
        <h1>Histórias</h1>

        <!-- Exibe o texto de apresentação do catálogo. -->
        <p class="subtitulo">
            <?= Html::e($subtitulo) ?>
        </p>

        <!-- Área que contém o campo de pesquisa das histórias. -->
        <div class="busca-container">

            <!-- Formulário que envia o termo pesquisado para o catálogo pelo método GET. -->
            <form
                action="<?= URL ?>/usuarios/escolher_historia_user"
                method="GET"
                class="busca-box">

                <!-- Exibe o ícone utilizado para representar a pesquisa. -->
                <span class="icone-busca" aria-hidden="true">
                    <img src="<?= URL ?>/public/img/LUPA2.png" alt="">
                </span>

                <!-- Campo onde o usuário pode digitar o título de um mito ou de uma lenda. -->
                <!-- Mantém o termo pesquisado preenchido após a atualização da página. -->
                <input
                    type="text"
                    id="buscaHistoria"
                    name="busca"
                    value="<?= Html::e($busca) ?>"
                    aria-label="Buscar história pelo título"
                    placeholder="Digite o nome de uma lenda ou de um mito...">
            </form>

        </div>

        <!-- Área responsável por organizar os cards das histórias cadastradas. -->
        <section class="grid-historias" id="gridHistorias">

            <!-- Verifica se não existem histórias disponíveis para exibição. -->
            <?php if (empty($historias)): ?>

                <!-- Exibe uma mensagem de acordo com a situação da pesquisa. -->
                <p class="sem-historias">
                    <?= $busca !== ''
                        ? 'Nenhuma história encontrada para “' . Html::e($busca) . '”.'
                        : 'Nenhuma história cadastrada ainda.' ?>
                </p>

            <?php endif; ?>

            <!-- Percorre a lista de histórias para apresentar cada uma em um card. -->
            <?php foreach ($historias as $item): ?>

                <?php
                // Armazena o identificador da história como número inteiro.
                $id = (int) $item->id;

                // Armazena os títulos da história em português, espanhol e Wari'.
                // Caso algum título não esteja disponível, define uma string vazia.
                $titulo = $item->titulo ?? '';
                $tituloEs = $item->titulo_es ?? '';
                $tituloWari = $item->titulo_wari ?? '';
                ?>

                <!-- Card que reúne as informações de uma história. -->
                <!-- O atributo data-categoria armazena a categoria em letras minúsculas para uso no JavaScript. -->
                <article
                    class="card-item"
                    data-categoria="<?= Html::e(mb_strtolower($item->categoria ?? '', 'UTF-8')) ?>">

                    <!-- Área destinada à imagem da história. -->
                    <div class="card-imagem">

                        <!-- Verifica se a história possui uma imagem cadastrada antes de exibi-la. -->
                        <?php if (!empty($item->imagem)): ?>

                            <!-- Exibe a imagem e utiliza o título da história como descrição alternativa. -->
                            <img
                                src="<?= Html::e($item->imagem) ?>"
                                alt="<?= Html::e($titulo) ?>">

                        <?php endif; ?>

                    </div>

                    <!-- Área que apresenta o título, a categoria e o botão de leitura. -->
                    <div class="card-info">

                        <div class="card-texto">

                            <!-- Exibe o título da história e armazena as versões em outros idiomas nos atributos data. -->
                            <!-- Essas informações são utilizadas pelo JavaScript para trabalhar com os diferentes idiomas. -->
                            <div
                                class="card-titulo"
                                data-titulo-pt="<?= Html::e($titulo) ?>"
                                data-titulo-es="<?= Html::e($tituloEs) ?>"
                                data-titulo-wari="<?= Html::e($tituloWari) ?>">
                                <?= Html::e($titulo) ?>
                            </div>

                            <!-- Exibe a categoria à qual a história pertence. -->
                            <div class="card-categoria">
                                <?= Html::e($item->categoria) ?>
                            </div>

                        </div>

                        <!-- Direciona para a página de leitura da história, enviando seu ID e definindo português como idioma inicial. -->
                        <a
                            href="<?= URL ?>/usuarios/historias_user?id=<?= $id ?>&amp;lang=pt"
                            class="btn-ler">
                            Ler história
                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

            <!-- Exibe uma mensagem quando a busca dinâmica não encontra histórias correspondentes. -->
            <?php if (!empty($historias)): ?>

                <p class="sem-historias" id="semResultados" hidden>
                    Nenhuma história corresponde à sua busca.
                </p>

            <?php endif; ?>

        </section>

    </main>

    <!-- Inclui o rodapé compartilhado entre as páginas do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pela busca e pelas funcionalidades do catálogo. -->
    <!-- O atributo defer permite executar o arquivo após a leitura do HTML. -->
    <script src="<?= URL ?>/public/js/escolher_historia_user.js" defer></script>

    <!-- Importa o JavaScript responsável pelas funcionalidades das configurações de acessibilidade. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>

</body>

</html>