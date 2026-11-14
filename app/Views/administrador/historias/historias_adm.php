
<?php
// Recupera os dados enviados pelo método Administrador::historias_adm().
// Caso alguma informação não tenha sido definida, utiliza um valor padrão.
$titulo_lenda = $titulo_lenda ?? '';
$legenda_imagem = $legenda_imagem ?? '';
$texto_lenda = $texto_lenda ?? '';
$comentarios = $comentarios ?? [];
$totalComentarios = (int) ($totalComentarios ?? count($comentarios));
$idioma_atual = $idioma_atual ?? 'pt';
$idiomas_disponiveis = $idiomas_disponiveis ?? ['pt'];

// Recupera a quantidade de avaliações e a média recebida pela história.
$totalAvaliacoes = (int) ($avaliacao->total ?? 0);
$mediaAvaliacoes = (float) ($avaliacao->media ?? 0);

// Recupera o identificador da história que está sendo exibida.
$historiaId = (int) $historia->id;

// Cria uma função auxiliar para proteger os valores exibidos na página,
// evitando que códigos HTML sejam interpretados pelo navegador.
$esc = static fn($valor) =>
htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');

// Define as informações dos botões de seleção de idioma,
// incluindo o nome, a imagem e a classe CSS de cada opção.
$botoesIdioma = [
    'pt' => ['nome' => 'Português', 'img' => 'brasil.png', 'classe' => 'img-espanha'],
    'es' => ['nome' => 'Espanhol', 'img' => 'espanha.png', 'classe' => 'img-espanha'],
    'wari' => ['nome' => "Wari' Oro Nao", 'img' => 'icone_logo_menu.png', 'classe' => 'img-wari'],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página para diferentes tamanhos de tela. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Exibe o título da história seguido do nome do sistema na aba do navegador. -->
    <title>
        <?= $esc($titulo_lenda) ?> - Histórias na Pérola
    </title>

    <!-- Carrega os arquivos CSS responsáveis pela aparência da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link
        rel="stylesheet"
        href="<?= URL ?>/public/css/historias_adm.css">

    <!-- Define estilos específicos desta página relacionados às avaliações e aos comentários. -->
    <style>
        /* Define o espaçamento, a cor e o tamanho do texto do resumo das avaliações. */
        .resumo-avaliacao {
            margin: 22px 0 0;
            color: #62665d;
            font-size: 14px;
        }

        /* Destaca a estrela utilizada na apresentação da média das avaliações. */
        .resumo-avaliacao strong {
            color: #c99829;
        }

        /* Organiza os botões de ação dos comentários, permitindo a quebra de linha quando necessário. */
        .acoes-comentario {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
    </style>
</head>

<body>

    <!-- Inclui o menu de navegação utilizado pelo administrador. -->
    <?php require APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal que reúne as informações da história selecionada. -->
    <main class="conteudo">

        <!-- Apresenta o título principal da página. -->
        <h1>História</h1>

        <!-- Exibe uma descrição sobre o conteúdo apresentado. -->
        <p class="subtitulo">
            Mito ou lenda escolhida.
        </p>

        <!-- Verifica se existe alguma mensagem temporária na sessão para exibi-la. -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Card que reúne o conteúdo da história, as avaliações e os comentários. -->
        <section class="modal-historia">

            <!-- Exibe o título da história selecionada. -->
            <h2 class="titulo-lenda">
                <?= $esc($titulo_lenda) ?>
            </h2>

            <!-- Área responsável por apresentar a imagem da história. -->
            <div class="box-imagem">

                <!-- Verifica se a história possui uma imagem cadastrada antes de exibi-la. -->
                <?php if (!empty($historia->imagem_uri)): ?>
                    <img src="<?= $esc($historia->imagem_uri) ?>" alt="<?= $esc($legenda_imagem) ?>">
                <?php else: ?>

                    <!-- Apresenta um texto alternativo quando a história não possui imagem. -->
                    Imagem da história

                <?php endif; ?>
            </div>

            <!-- Exibe a legenda correspondente à imagem da história. -->
            <p class="legenda">
                <?= $esc($legenda_imagem) ?>
            </p>

            <!-- Apresenta o texto completo da história.
                 A função strip_tags() remove possíveis tags HTML,
                 enquanto nl2br() mantém as quebras de linha do texto. -->
            <div class="texto-lenda">
                <?= nl2br($esc(strip_tags((string)$texto_lenda))) ?>
            </div>

            <!-- Apresenta o resumo das avaliações recebidas pela história. -->
            <p class="resumo-avaliacao">

                <!-- Verifica se a história possui pelo menos uma avaliação cadastrada. -->
                <?php if ($totalAvaliacoes > 0): ?>

                    <!-- Exibe a estrela, a média das notas e a quantidade de avaliações recebidas. -->
                    <strong>★</strong>
                    Média <?= number_format($mediaAvaliacoes, 1, ',', '') ?> de 5
                    (<?= $totalAvaliacoes ?> <?= $totalAvaliacoes === 1 ? 'avaliação' : 'avaliações' ?>)

                <?php else: ?>

                    <!-- Mensagem apresentada quando a história ainda não recebeu avaliações. -->
                    Esta história ainda não foi avaliada.

                <?php endif; ?>
            </p>

            <!-- Verifica se existe mais de um idioma disponível para a história.
                 Caso exista, apresenta as opções para alternar entre as versões. -->
            <?php if (count($idiomas_disponiveis) > 1): ?>
                <div class="secao-idiomas">

                    <!-- Cabeçalho da seção de seleção de idiomas. -->
                    <div class="titulo-idiomas">

                        <!-- Exibe o ícone que representa a disponibilidade de outros idiomas. -->
                        <img
                            src="<?= URL ?>/public/img/icone_globo.png"
                            alt=""
                            aria-hidden="true">

                        <span>
                            Ler esta história em outras línguas
                        </span>

                    </div>

                    <!-- Orienta o administrador sobre a seleção de outro idioma. -->
                    <p class="subtitulo-idiomas">
                        Escolha o idioma para ver a versão completa da história.
                    </p>

                    <!-- Área que reúne os botões de seleção dos idiomas disponíveis. -->
                    <div class="botoes-idiomas">

                        <!-- Percorre as opções de idiomas definidas anteriormente. -->
                        <?php foreach ($botoesIdioma as $codigo => $botao): ?>

                            <!-- Verifica se o idioma está disponível para esta história.
                                 Se não estiver cadastrado, não apresenta o botão correspondente. -->
                            <?php if (!in_array($codigo, $idiomas_disponiveis, true)) continue; ?>

                            <!-- Cria um botão para acessar a versão da história no idioma selecionado.
                                 Também destaca visualmente o idioma que está sendo exibido. -->
                            <a
                                href="<?= URL ?>/administrador/historias_adm?id=<?= $historiaId ?>&amp;lang=<?= $codigo ?>"
                                class="btn-idioma btn-idioma-<?= $codigo ?> <?= $idioma_atual === $codigo ? 'ativo' : '' ?>"
                                <?= $idioma_atual === $codigo ? 'aria-current="true"' : '' ?>>

                                <!-- Exibe a imagem correspondente ao idioma selecionado. -->
                                <img
                                    src="<?= URL ?>/public/img/<?= $botao['img'] ?>"
                                    alt=""
                                    class="<?= $botao['classe'] ?>"
                                    aria-hidden="true">

                                <!-- Apresenta o nome do idioma no botão. -->
                                <span><?= $esc($botao['nome']) ?></span>
                            </a>

                        <?php endforeach; ?>

                    </div>

                </div>
            <?php endif; ?>

            <!-- Seção responsável por apresentar os comentários feitos pelos usuários. -->
            <section
                class="lista-comentarios"
                id="comentarios"
                aria-labelledby="titulo-lista-comentarios">

                <!-- Exibe o título da seção e a quantidade de comentários da história. -->
                <h3
                    class="titulo-lista-comentarios"
                    id="titulo-lista-comentarios">
                    Comentários (<?= count($comentarios) ?>)
                </h3>

                <!-- Verifica se existem comentários cadastrados para a história. -->
                <?php if (empty($comentarios)): ?>

                    <!-- Mensagem apresentada quando ainda não existem comentários. -->
                    <p class="sem-comentarios">
                        Ainda não há comentários nesta história.
                    </p>

                <?php else: ?>

                    <!-- Percorre a lista de comentários e apresenta cada um individualmente. -->
                    <?php foreach ($comentarios as $c): ?>

                        <!-- Estrutura que reúne as informações de um comentário. -->
                        <article class="comentario-item">

                            <!-- Cria um avatar utilizando a primeira letra do nome do usuário.
                                 As funções mb_substr() e mb_strtoupper() permitem trabalhar corretamente com caracteres especiais. -->
                            <div
                                class="avatar-comentario"
                                aria-hidden="true">
                                <?= $esc(mb_strtoupper(mb_substr((string)$c->pess_nome, 0, 1, 'UTF-8'), 'UTF-8')) ?>
                            </div>

                            <!-- Área que contém o nome, a data, o texto e as ações do comentário. -->
                            <div class="corpo-comentario">

                                <!-- Reúne as informações de identificação do comentário. -->
                                <div class="cabecalho-comentario">

                                    <!-- Exibe o nome do usuário que realizou o comentário. -->
                                    <span class="nome-comentario">
                                        <?= $esc($c->pess_nome) ?>
                                    </span>

                                    <!-- Exibe a data e o horário em que o comentário foi realizado,
                                         utilizando o formato dia/mês/ano e hora:minuto. -->
                                    <time class="data-comentario" datetime="<?= $esc($c->come_data_pessoa) ?>">
                                        <?= $esc(Html::data($c->come_data_pessoa, 'd/m/Y H:i')) ?>
                                    </time>

                                </div>

                                <!-- Apresenta o conteúdo escrito pelo usuário, mantendo as quebras de linha. -->
                                <p class="texto-comentario">
                                    <?= nl2br($esc($c->come_texto)) ?>
                                </p>

                                <!-- Área destinada às ações disponíveis para o comentário. -->
                                <div class="acoes-comentario">

                                    <!-- Formulário utilizado pelo administrador para solicitar a exclusão de um comentário.
                                         Antes de enviar, executa uma função JavaScript de confirmação. -->
                                    <form
                                        action="<?= URL ?>/administrador/excluir_comentario"
                                        method="POST"
                                        class="form-excluir-comentario"
                                        onsubmit="return confirmarExclusaoComentario(this)">

                                        <!-- Envia o identificador do comentário para que o sistema saiba qual registro excluir. -->
                                        <input
                                            type="hidden"
                                            name="excluir_comentario"
                                            value="<?= (int)$c->come_id ?>">

                                        <!-- Botão que confirma o envio da solicitação de exclusão do comentário. -->
                                        <button
                                            type="submit"
                                            class="btn-excluir-comentario">
                                            Excluir comentário
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </article>

                    <!-- Finaliza a repetição dos comentários. -->
                    <?php endforeach; ?>

                <?php endif; ?>

            </section>

            <!-- Reúne os botões de navegação e edição da história. -->
            <div class="acoes-historia">

                <!-- Retorna à página de gerenciamento de histórias. -->
                <a
                    class="btn-secundario"
                    href="<?= URL ?>/administrador/gerenciar_historia_adm">
                    Voltar ao gerenciamento
                </a>

                <!-- Direciona para a página de edição da história atual,
                     enviando seu identificador pela URL. -->
                <a
                    class="btn-primario"
                    href="<?= URL ?>/administrador/editar_historia_adm?id=<?= $historiaId ?>">
                    Editar história
                </a>

            </div>

        </section>

    </main>

    <!-- Inclui o rodapé padrão do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Carrega o JavaScript responsável pelas funcionalidades da página da história. -->
    <script
        src="<?= URL ?>/public/js/historias_adm.js"
        defer></script>

    <!-- Carrega as funcionalidades relacionadas aos comentários,
         incluindo a confirmação antes de realizar uma exclusão. -->
    <script
        src="<?= URL ?>/public/js/historias_comentarios.js"
        defer></script>

    <!-- Carrega as funcionalidades gerais das configurações da página. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
