<?php

// Idiomas desta tela (os mesmos da tela "Nova história" do administrador)
$idiomas = [
    'pt' => [
        'nome'   => 'Português',
        'html'   => 'pt-BR',
        'icone'  => 'brasil.png',
        'classe' => 'img-brasil',
    ],
    'es' => [
        'nome'   => 'Espanhol',
        'html'   => 'es',
        'icone'  => 'espanha.png',
        'classe' => 'img-espanha',
    ],
    'wari' => [
        'nome'   => "Wari' Oro Nao",
        'html'   => 'pav',
        'icone'  => 'icone_logo_menu.png',
        'classe' => 'img-wari',
    ],
];

$exemplo = trim(str_repeat('XXXXXXXXXX ', 14));

/*
 * Cada idioma tem o seu título, legenda e texto.
 * No texto, uma linha em branco separa um parágrafo do outro.
 */
$historia = [
    'imagem'  => '', // caminho da imagem; vazio mostra o espaço reservado
    'versoes' => [
        'pt' => [
            'titulo'  => 'Título da Lenda',
            'legenda' => 'Legenda da imagem',
            'texto'   => $exemplo . "\n\n" . $exemplo,
        ],
        'es' => [
            'titulo'  => 'Título de la leyenda',
            'legenda' => 'Leyenda de la imagen',
            'texto'   => $exemplo . "\n\n" . $exemplo,
        ],
        'wari' => [
            'titulo'  => "Título da Lenda (Wari' Oro Nao)",
            'legenda' => "Legenda da imagem (Wari' Oro Nao)",
            'texto'   => $exemplo . "\n\n" . $exemplo,
        ],
    ],
];

$comentarios = [
    ['id' => 1, 'nome' => 'Maria Souza',  'data' => '18/09/2026', 'texto' => 'Adorei conhecer essa lenda, é muito bonita e importante para a nossa cultura.', 'curtidas' => 12, 'curtiu' => true],
    ['id' => 2, 'nome' => 'João Pereira', 'data' => '17/09/2026', 'texto' => 'Minha avó contava uma versão parecida dessa história quando eu era criança.', 'curtidas' => 5,  'curtiu' => false],
    ['id' => 3, 'nome' => 'Ana Karolina', 'data' => '15/09/2026', 'texto' => 'Muito legal poder ler em outros idiomas também!', 'curtidas' => 0,  'curtiu' => false],
];

// Idioma escolhido na URL (?lang=es). Qualquer valor fora da lista volta para o português.
$lang         = $_GET['lang'] ?? 'pt';
$idioma_atual = (is_string($lang) && isset($idiomas[$lang])) ? $lang : 'pt';
$versao       = $historia['versoes'][$idioma_atual];

// Parágrafos do texto escolhido
$paragrafos = preg_split('/\R{2,}/', trim($versao['texto']));

// Link para trocar de idioma (mantém outros parâmetros, sem o "url" interno do roteador)
$linkIdioma = function ($codigo) {
    $parametros = $_GET;
    unset($parametros['url']);
    $parametros['lang'] = $codigo;
    return '?' . http_build_query($parametros) . '#historia';
};
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>História - Histórias na Pérola</title>
    <link rel="stylesheet" href="<?=URL?>/public/css/historias_user.css">
</head>
<body>

<!-- VLibras -->
<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
        <div class="vw-plugin-top-wrapper"></div>
    </div>
</div>

<?php include APP . '/Views/usuarios/menu_user.php'; ?>

<main class="conteudo">

    <h1>História</h1>
    <p class="subtitulo">Mito ou lenda escolhida.</p>

    <article class="modal-historia" id="historia">

        <a href="<?=URL?>/usuarios/escolher_historia_user" class="btn-fechar" title="Fechar" aria-label="Fechar e voltar para as histórias">
            <span aria-hidden="true">✕</span>
        </a>

        <div lang="<?= $idiomas[$idioma_atual]['html'] ?>">

            <h2 class="titulo-lenda"><?= htmlspecialchars($versao['titulo']) ?></h2>

            <div class="box-imagem">
                <?php if (!empty($historia['imagem'])): ?>
                    <img src="<?= htmlspecialchars($historia['imagem']) ?>" alt="<?= htmlspecialchars($versao['legenda']) ?>">
                <?php else: ?>
                    <span>IMAGEM</span>
                <?php endif; ?>
            </div>

            <p class="legenda"><?= htmlspecialchars($versao['legenda']) ?></p>

            <div class="texto-lenda">
                <?php foreach ($paragrafos as $paragrafo): ?>
                    <p><?= nl2br(htmlspecialchars($paragrafo)) ?></p>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- IDIOMAS -->
        <section class="secao-idiomas">

            <div class="titulo-idiomas">
                <img src="<?=URL?>/public/img/icone_globo.png" alt="">
                <span>Ler esta lenda em outras línguas</span>
            </div>

            <p class="subtitulo-idiomas">Escolha o idioma para ver a versão completa da lenda.</p>

            <div class="botoes-idiomas">
                <?php foreach ($idiomas as $codigo => $idioma): ?>
                    <a href="<?= htmlspecialchars($linkIdioma($codigo)) ?>"
                       class="btn-idioma <?= $codigo === $idioma_atual ? 'ativo' : '' ?>"
                       <?= $codigo === $idioma_atual ? 'aria-current="true"' : '' ?>>
                        <img src="<?=URL?>/public/img/<?= $idioma['icone'] ?>" alt="" class="<?= $idioma['classe'] ?>">
                        <span><?= htmlspecialchars($idioma['nome']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

        </section>

        <!-- COMENTÁRIO DO USUÁRIO -->
        <form action="" method="POST" class="secao-comentario">
            <label for="comentario" class="titulo-comentario">O que você achou desta lenda?</label>

            <textarea id="comentario" name="comentario" class="area-texto-comentario" maxlength="1000" required placeholder="Digite aqui seu comentário..."></textarea>

            <button type="submit" class="btn-enviar">Enviar</button>
        </form>

        <!-- LISTA DE COMENTÁRIOS -->
        <section class="lista-comentarios">
            <div class="titulo-lista-comentarios">Comentários (<?= count($comentarios) ?>)</div>

            <?php if (empty($comentarios)): ?>
                <p class="sem-comentarios">Ainda não há comentários. Seja o primeiro a comentar!</p>
            <?php else: ?>
                <?php foreach ($comentarios as $c): ?>
                    <div class="comentario-item">

                        <div class="avatar-comentario" aria-hidden="true">
                            <?= htmlspecialchars(mb_strtoupper(mb_substr($c['nome'], 0, 1))) ?>
                        </div>

                        <div class="corpo-comentario">
                            <div class="cabecalho-comentario">
                                <span class="nome-comentario"><?= htmlspecialchars($c['nome']) ?></span>
                                <span class="data-comentario"><?= htmlspecialchars($c['data']) ?></span>
                            </div>

                            <p class="texto-comentario"><?= nl2br(htmlspecialchars($c['texto'])) ?></p>

                            <!-- Curtir: envia o id do comentário para o PHP tratar (POST) -->
                            <form action="" method="POST" class="form-curtir">
                                <input type="hidden" name="curtir_comentario" value="<?= (int)$c['id'] ?>">
                                <button type="submit"
                                        class="btn-curtir <?= $c['curtiu'] ? 'curtido' : '' ?>"
                                        aria-pressed="<?= $c['curtiu'] ? 'true' : 'false' ?>"
                                        title="Curtir comentário">
                                    <span class="icone-curtir" aria-hidden="true">♥</span>
                                    <span class="qtd-curtidas"><?= (int)$c['curtidas'] ?></span>
                                </button>
                            </form>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

    </article>

</main>

<?php include APP . '/Views/usuarios/footer_user.php'; ?>

<!-- VLibras -->
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
</script>

</body>
</html>
