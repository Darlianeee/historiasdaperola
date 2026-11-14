
<?php
// Define o texto que será exibido como subtítulo da página.
$subtitulo = "Adicione novas histórias.";

// Verifica se a lista de histórias foi recebida.
// Caso não tenha sido definida, utiliza um array vazio.
$historias = $historias ?? [];

// Verifica se existe alguma mensagem para exibir na página.
$mensagem = $mensagem ?? '';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página para diferentes tamanhos de tela. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Gerenciar Histórias - Histórias na Pérola</title>

    <!-- Carrega os arquivos CSS responsáveis pela aparência da página e pelas configurações gerais. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/gerenciar_historia_adm.css">
</head>

<body>

    <!-- Inclui o menu de navegação do administrador. -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal que reúne as funcionalidades de gerenciamento das histórias. -->
    <main class="conteudo">

        <!-- Apresenta o título principal da página. -->
        <h1>Gerenciar Histórias</h1>

        <!-- Exibe o subtítulo definido anteriormente, protegendo o conteúdo antes de apresentá-lo. -->
        <p class="subtitulo">
            <?= htmlspecialchars($subtitulo, ENT_QUOTES, 'UTF-8'); ?>
        </p>

        <!-- Verifica se existe alguma mensagem temporária armazenada na sessão para exibi-la. -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Exibe uma mensagem de sucesso quando houver alguma informação recebida. -->
        <?php if ($mensagem !== ''): ?>
            <div class="mensagem-sucesso" role="status">
                <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Reúne as ferramentas utilizadas para pesquisar, filtrar e cadastrar histórias. -->
        <div class="ferramentas-container">

            <!-- Campo de pesquisa para localizar histórias pelo título. -->
            <div class="busca-box">

                <!-- Exibe o ícone de lupa utilizado na pesquisa. -->
                <span class="icone-busca" aria-hidden="true">
                    <img src="<?= URL ?>/public/img/LUPA2.png" alt="">
                </span>

                <!-- Recebe o texto digitado pelo administrador para pesquisar uma história. -->
                <input
                    type="text"
                    id="buscaHistoria"
                    placeholder="Buscar História..."
                    aria-label="Buscar história pelo título">
            </div>

            <!-- Lista utilizada para filtrar as histórias de acordo com sua categoria. -->
            <select
                class="select-categoria"
                id="filtroCategoria"
                aria-label="Filtrar por categoria">
                <option value="">Categoria</option>
                <option value="mito">Mito</option>
                <option value="lenda">Lenda</option>
            </select>

            <!-- Direciona o administrador para a página de cadastro de uma nova história. -->
            <a
                href="<?= URL ?>/administrador/nova_historia"
                class="btn-nova-historia">
                + Nova História
            </a>

        </div>

        <!-- Apresenta a quantidade total de histórias cadastradas no sistema. -->
        <div class="total-historias">

            <!-- Elemento decorativo utilizado para destacar a informação. -->
            <span class="marcador-dourado"></span>

            <span>Histórias cadastradas:</span>

            <!-- Exibe a quantidade total de histórias, convertendo o valor para inteiro. -->
            <strong><?= (int) ($totalHistorias ?? 0) ?></strong>

        </div>

        <!-- Área responsável por organizar e exibir os cards das histórias cadastradas. -->
        <section class="grid-historias" id="gridHistorias">

            <!-- Verifica se existem histórias cadastradas para exibir. -->
            <?php if (empty($historias)): ?>

                <!-- Mensagem apresentada quando ainda não existem histórias cadastradas. -->
                <p class="sem-historias" id="semHistorias">
                    Nenhuma história cadastrada ainda.
                </p>

            <?php else: ?>

                <!-- Percorre a lista de histórias e cria um card para cada registro.
                     O índice é utilizado para identificar individualmente os menus de opções. -->
                <?php foreach ($historias as $index => $item): ?>

                    <?php
                    // Recupera o identificador da história.
                    $id = (int) $item->id;

                    // Recupera o título da história.
                    $titulo = $item->titulo ?? '';

                    // Recupera a categoria à qual a história pertence.
                    $categoria = $item->categoria ?? '';

                    // Recupera o caminho da imagem cadastrada para a história.
                    $imagem = $item->imagem ?? '';
                    ?>

                    <!-- Card individual que apresenta as informações e as opções de cada história.
                         Os atributos data-titulo e data-categoria são utilizados pelos filtros de pesquisa. -->
                    <div
                        class="card-item"
                        data-titulo="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>"
                        data-categoria="<?= htmlspecialchars(mb_strtolower($categoria, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>">

                        <!-- Área que contém a imagem da história e o menu de opções. -->
                        <div class="card-imagem-wrapper">

                            <!-- Verifica se a história possui uma imagem cadastrada antes de exibi-la. -->
                            <?php if ($imagem !== ''): ?>
                                <img
                                    src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php endif; ?>

                            <!-- Botão que abre ou fecha o menu de opções da história.
                                 A função toggleMenu() é responsável por controlar sua exibição. -->
                            <button
                                class="btn-opcoes"
                                type="button"
                                onclick="toggleMenu(event, <?= $index; ?>)"
                                aria-label="Opções da história"
                                aria-expanded="false">
                                ⋮
                            </button>

                            <!-- Menu que apresenta as opções disponíveis para a história selecionada. -->
                            <div class="menu-opcoes" id="menu-<?= $index; ?>">

                                <!-- Direciona para a página de edição da história selecionada,
                                     enviando seu identificador pela URL. -->
                                <a href="<?= URL ?>/administrador/editar_historia_adm?id=<?= $id; ?>">
                                    Editar História
                                </a>

                                <!-- Direciona para a página de confirmação da exclusão da história. -->
                                <a
                                    href="<?= URL ?>/administrador/excluir_historia_adm?id=<?= $id; ?>"
                                    class="btn-apagar">
                                    Excluir História
                                </a>

                            </div>

                        </div>

                        <!-- Área que apresenta o título, a categoria e o acesso à história. -->
                        <div class="card-info">

                            <!-- Agrupa as informações textuais da história. -->
                            <div class="card-textos">

                                <!-- Exibe o título da história e armazena os títulos disponíveis em cada idioma.
                                     Esses dados permitem que o JavaScript altere o idioma exibido. -->
                                <div
                                    class="card-titulo"
                                    data-titulo-pt="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-titulo-es="<?= htmlspecialchars($item->titulo_es ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    data-titulo-wari="<?= htmlspecialchars($item->titulo_wari ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>
                                </div>

                                <!-- Exibe a categoria da história. -->
                                <div class="card-categoria">
                                    <?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            </div>

                            <!-- Direciona para a visualização da história em português,
                                 enviando o identificador da história e o idioma selecionado. -->
                            <a href="<?= URL ?>/administrador/historias_adm?id=<?= $id; ?>&lang=pt" class="btn-ler">
                                Ver história
                            </a>

                        </div>

                    </div>

                <!-- Finaliza a repetição dos cards das histórias. -->
                <?php endforeach; ?>

                <!-- Mensagem exibida pelo JavaScript quando nenhuma história corresponde à pesquisa ou ao filtro selecionado.
                     O atributo hidden mantém a mensagem inicialmente oculta. -->
                <p class="sem-resultados" id="semResultados" hidden>
                    Nenhuma história corresponde à sua busca.
                </p>

            <?php endif; ?>

        </section>

    </main>

    <!-- Inclui o rodapé padrão do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Carrega o JavaScript responsável pela pesquisa, pelos filtros e pelos menus de opções das histórias. -->
    <script src="<?= URL ?>/public/js/gerenciar_historia_adm.js"></script>

    <!-- Carrega as funcionalidades gerais das configurações da página. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
