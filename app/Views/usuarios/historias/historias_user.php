<?php
// Recebe os dados enviados pelo método que carrega a história.
$titulo_lenda = $titulo_lenda ?? '';
$legenda_imagem = $legenda_imagem ?? '';
$texto_lenda = $texto_lenda ?? '';
$comentarios = $comentarios ?? [];

// Define a quantidade de comentários, caso ela não tenha sido informada.
$totalComentarios = (int) ($totalComentarios ?? count($comentarios));

// Define o idioma atual e os idiomas disponíveis para a história.
$idioma_atual = $idioma_atual ?? 'pt';
$idiomas_disponiveis = $idiomas_disponiveis ?? ['pt'];

// Recebe a nota que o usuário já deu e os dados das avaliações.
$minha_nota = (int) ($minha_nota ?? 0);
$totalAvaliacoes = (int) ($avaliacao->total ?? 0);
$mediaAvaliacoes = (float) ($avaliacao->media ?? 0);

// Guarda o ID da história.
$historiaId = (int) $historia->id;

// Função usada para proteger os dados exibidos na página,
// evitando que códigos HTML ou JavaScript sejam executados.
$esc = static fn($valor) =>
htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');

// Define o nome, a imagem e a classe de cada idioma disponível.
$botoesIdioma = [
    'pt' => ['nome' => 'Português', 'img' => 'brasil.png', 'classe' => 'img-espanha'],
    'es' => ['nome' => 'Espanhol', 'img' => 'espanha.png', 'classe' => 'img-espanha'],
    'wari' => ['nome' => "Wari' Oro Nao", 'img' => 'icone_logo_menu.png', 'classe' => 'img-wari'],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Exibe o título da história junto ao nome do projeto na aba do navegador. -->
    <title>
        <?= $esc($titulo_lenda) ?> - Histórias na Pérola
    </title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link
        rel="stylesheet"
        href="<?= URL ?>/public/css/historias_user.css">

    <!-- Define alguns estilos específicos para a área de avaliações. -->
    <style>
        .secao-avaliacao {
            margin: 28px 0 8px;
            padding-top: 20px;
            border-top: 1px solid #e3e4dd;
        }

        .secao-avaliacao .titulo-comentario {
            display: block;
            margin-bottom: 6px;
        }

        .resumo-avaliacao {
            margin: 0 0 10px;
            color: #62665d;
            font-size: 14px;
        }

        .estrelas {
            position: relative;
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 4px;
            border: 0;
            padding: 0;
            margin: 0 12px 0 0;
            vertical-align: middle;
        }

        .estrelas input {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
        }

        .estrelas label {
            font-size: 32px;
            line-height: 1;
            color: #cfd1c8;
            cursor: pointer;
        }

        .estrelas input:checked~label,
        .estrelas label:hover,
        .estrelas label:hover~label {
            color: #c99829;
        }

        .estrelas input:focus-visible+label {
            outline: 3px solid #2467c7;
            outline-offset: 2px;
        }
    </style>
</head>

<body>

    <!-- Inclui o menu de navegação do usuário. -->
    <?php require APP . '/Views/usuarios/menu_user.php'; ?>

    <main class="conteudo">

        <!-- Título e descrição da página. -->
        <h1>História</h1>

        <p class="subtitulo">
            Mito ou lenda escolhida.
        </p>

        <!-- Exibe mensagens de sucesso ou erro, caso existam. -->
        <?php Sessao::exibirFlash(); ?>

        <section class="modal-historia">

            <!-- Exibe o título da história selecionada. -->
            <h2 class="titulo-lenda">
                <?= $esc($titulo_lenda) ?>
            </h2>

            <!-- Verifica se a história possui uma imagem cadastrada. -->
            <div class="box-imagem">
                <?php if (!empty($historia->imagem_uri)): ?>
                    <!-- Exibe a imagem e utiliza a legenda como texto alternativo. -->
                    <img src="<?= $esc($historia->imagem_uri) ?>" alt="<?= $esc($legenda_imagem) ?>">
                <?php else: ?>
                    <!-- Exibe um texto caso a história não tenha imagem. -->
                    Imagem da história
                <?php endif; ?>
            </div>

            <!-- Exibe a legenda da imagem. -->
            <p class="legenda">
                <?= $esc($legenda_imagem) ?>
            </p>

            <!-- Exibe o texto completo da história, mantendo as quebras de linha. -->
            <div class="texto-lenda">
                <?= nl2br($esc(strip_tags((string)$texto_lenda))) ?>
            </div>

            <!-- Verifica se existe mais de um idioma disponível para a história. -->
            <?php if (count($idiomas_disponiveis) > 1): ?>
                <div class="secao-idiomas">

                    <!-- Apresenta o título da área de seleção de idiomas. -->
                    <div class="titulo-idiomas">
                        <img
                            src="<?= URL ?>/public/img/icone_globo.png"
                            alt=""
                            aria-hidden="true">

                        <span>
                            Ler esta história em outras línguas
                        </span>
                    </div>

                    <p class="subtitulo-idiomas">
                        Escolha o idioma para ver a versão completa da história.
                    </p>

                    <!-- Cria os botões dos idiomas disponíveis. -->
                    <div class="botoes-idiomas">

                        <?php foreach ($botoesIdioma as $codigo => $botao): ?>
                            <!-- Não exibe os idiomas que não possuem tradução cadastrada. -->
                            <?php if (!in_array($codigo, $idiomas_disponiveis, true)) continue; ?>

                            <a
                                href="<?= URL ?>/usuarios/historias_user?id=<?= $historiaId ?>&amp;lang=<?= $codigo ?>"
                                class="btn-idioma <?= $idioma_atual === $codigo ? 'ativo' : '' ?>"
                                <?= $idioma_atual === $codigo ? 'aria-current="true"' : '' ?>>
                                <!-- Exibe a imagem correspondente ao idioma. -->
                                <img
                                    src="<?= URL ?>/public/img/<?= $botao['img'] ?>"
                                    alt=""
                                    class="<?= $botao['classe'] ?>"
                                    aria-hidden="true">

                                <!-- Exibe o nome do idioma no botão. -->
                                <span><?= $esc($botao['nome']) ?></span>
                            </a>
                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulário para o usuário avaliar a história. -->
            <form
                action="<?= URL ?>/usuarios/avaliar"
                method="POST"
                class="secao-avaliacao"
                id="avaliacao">
                <!-- Envia o ID da história junto com a avaliação. -->
                <input type="hidden" name="historia" value="<?= $historiaId ?>">

                <span class="titulo-comentario">Avalie esta história</span>

                <!-- Exibe a média e a quantidade de avaliações recebidas. -->
                <p class="resumo-avaliacao">
                    <?php if ($totalAvaliacoes > 0): ?>
                        Média: <?= number_format($mediaAvaliacoes, 1, ',', '') ?> de 5
                        (<?= $totalAvaliacoes ?> <?= $totalAvaliacoes === 1 ? 'avaliação' : 'avaliações' ?>)
                    <?php else: ?>
                        Ainda não há avaliações. Seja o primeiro a avaliar!
                    <?php endif; ?>
                </p>

                <!-- Cria as opções de notas de 1 a 5 estrelas. -->
                <fieldset class="estrelas" aria-label="Sua nota">
                    <?php for ($n = 5; $n >= 1; $n--): ?>
                        <input
                            type="radio"
                            id="nota-<?= $n ?>"
                            name="nota"
                            value="<?= $n ?>"
                            <?= $minha_nota === $n ? 'checked' : '' ?>
                            required>
                        <label for="nota-<?= $n ?>" title="<?= $n ?> de 5">★</label>
                    <?php endfor; ?>
                </fieldset>

                <!-- Altera o texto do botão caso o usuário já tenha avaliado a história. -->
                <button type="submit" class="btn-enviar">
                    <?= $minha_nota > 0 ? 'Alterar avaliação' : 'Avaliar' ?>
                </button>
            </form>

            <!-- Formulário para o usuário enviar um comentário sobre a história. -->
            <form
                action="<?= URL ?>/usuarios/comentar"
                method="POST"
                class="secao-comentario">
                <!-- Envia o ID da história para identificar onde o comentário será registrado. -->
                <input type="hidden" name="historia" value="<?= $historiaId ?>">

                <label
                    for="comentario"
                    class="titulo-comentario">
                    O que você achou desta história?
                </label>

                <!-- Campo onde o usuário escreve seu comentário. -->
                <textarea
                    id="comentario"
                    name="comentario"
                    class="area-texto-comentario"
                    maxlength="1000"
                    placeholder="Digite aqui seu comentário..."
                    required></textarea>

                <!-- Botão responsável por enviar o comentário. -->
                <button
                    type="submit"
                    class="btn-enviar">
                    Enviar
                </button>

                <!-- Informa o limite de caracteres e como o nome será exibido. -->
                <p class="aviso-comentario">
                    Máximo de 1000 caracteres. Seu nome aparecerá junto ao comentário.
                </p>

            </form>

            <!-- Seção responsável por exibir os comentários da história. -->
            <section
                class="lista-comentarios"
                id="comentarios"
                aria-labelledby="titulo-lista-comentarios">

                <h3
                    class="titulo-lista-comentarios"
                    id="titulo-lista-comentarios">
                    <!-- Exibe a quantidade de comentários registrados. -->
                    Comentários (<?= count($comentarios) ?>)
                </h3>

                <!-- Verifica se ainda não existem comentários cadastrados. -->
                <?php if (empty($comentarios)): ?>

                    <p class="sem-comentarios">
                        Ainda não há comentários.
                        Seja o primeiro a comentar!
                    </p>

                <?php else: ?>

                    <!-- Percorre a lista para exibir cada comentário individualmente. -->
                    <?php foreach ($comentarios as $c): ?>

                        <article class="comentario-item">

                            <!-- Exibe a primeira letra do nome do usuário como avatar. -->
                            <div
                                class="avatar-comentario"
                                aria-hidden="true">
                                <?= $esc(mb_strtoupper(mb_substr((string)$c->pess_nome, 0, 1, 'UTF-8'), 'UTF-8')) ?>
                            </div>

                            <div class="corpo-comentario">

                                <div class="cabecalho-comentario">

                                    <!-- Exibe o nome de quem escreveu o comentário. -->
                                    <span class="nome-comentario">
                                        <?= $esc($c->pess_nome) ?>
                                    </span>

                                    <!-- Exibe a data e o horário em que o comentário foi publicado. -->
                                    <time class="data-comentario" datetime="<?= $esc($c->come_data_pessoa) ?>">
                                        <?= $esc(Html::data($c->come_data_pessoa, 'd/m/Y H:i')) ?>
                                    </time>

                                </div>

                                <!-- Exibe o conteúdo do comentário, mantendo as quebras de linha. -->
                                <p class="texto-comentario">
                                    <?= nl2br($esc($c->come_texto)) ?>
                                </p>

                                <!-- Verifica se o comentário pertence ao usuário que está conectado. -->
                                <?php if ((int) $c->pess_id === Sessao::id()): ?>

                                    <!-- Formulário para excluir o próprio comentário. -->
                                    <form
                                        action="<?= URL ?>/usuarios/excluir_comentario"
                                        method="POST"
                                        class="form-excluir-comentario"
                                        onsubmit="return confirmarExclusaoComentario(this)">

                                        <!-- Envia o ID da história relacionada ao comentário. -->
                                        <input type="hidden" name="historia" value="<?= $historiaId ?>">

                                        <!-- Envia o ID do comentário que será excluído. -->
                                        <input
                                            type="hidden"
                                            name="excluir_comentario"
                                            value="<?= (int)$c->come_id ?>">

                                        <!-- Botão para solicitar a exclusão do comentário. -->
                                        <button
                                            type="submit"
                                            class="btn-excluir-comentario">
                                            Excluir comentário
                                        </button>

                                    </form>
                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endforeach; ?>

                <?php endif; ?>

            </section>

            <!-- Link para retornar ao catálogo de histórias. -->
            <div class="area-voltar">
                <a href="<?= URL ?>/usuarios/escolher_historia_user"
                    class="btn-voltar">
                    Voltar
                </a>
            </div>

        </section>

    </main>

    <!-- Inclui o rodapé compartilhado do projeto. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas ações relacionadas aos comentários. -->
    <script
        src="<?= URL ?>/public/js/historias_comentarios.js"
        defer></script>

    <!-- Importa o JavaScript responsável pelas configurações de acessibilidade e aparência. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>