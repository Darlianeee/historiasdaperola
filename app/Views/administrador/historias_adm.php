<?php


$admin_nome = 'Administrador';

// Idiomas desta tela (os mesmos da tela "Nova história")
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

/*
 * Cada comentário: id, nome, data, texto, curtidas,
 *   curtiu   (o administrador curtiu?),
 *   oculto   (escondido dos usuários?),
 *   do_admin (foi escrito pelo administrador?)
 */
$comentarios = [
    ['id' => 1, 'nome' => 'Maria Souza',  'data' => '18/09/2026', 'texto' => 'Adorei conhecer essa lenda, é muito bonita e importante para a nossa cultura.', 'curtidas' => 12, 'curtiu' => true,  'oculto' => false, 'do_admin' => false],
    ['id' => 2, 'nome' => 'João Pereira', 'data' => '17/09/2026', 'texto' => 'Minha avó contava uma versão parecida dessa história quando eu era criança.', 'curtidas' => 5,  'curtiu' => false, 'oculto' => true,  'do_admin' => false],
    ['id' => 3, 'nome' => $admin_nome,    'data' => '16/09/2026', 'texto' => 'Obrigado pelos comentários! Em breve vamos publicar novas lendas.',              'curtidas' => 3,  'curtiu' => false, 'oculto' => false, 'do_admin' => true],
    ['id' => 4, 'nome' => 'Ana Karolina', 'data' => '15/09/2026', 'texto' => 'Muito legal poder ler em outros idiomas também!',                                    'curtidas' => 0,  'curtiu' => false, 'oculto' => false, 'do_admin' => false],
];

$total_ocultos = count(array_filter($comentarios, function ($c) {
    return !empty($c['oculto']);
}));

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
    <link rel="stylesheet" href="<?=URL?>/public/css/historias_adm.css">
</head>
<body>

<!-- VLibras -->
<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
        <div class="vw-plugin-top-wrapper"></div>
    </div>
</div>

<?php include APP . '/Views/administrador/menu_adm.php'; ?>

<main class="conteudo">

    <h1>História</h1>
    <p class="subtitulo">Mito ou lenda escolhida.</p>

    <article class="modal-historia" id="historia">

        <a href="<?=URL?>/administrador/gerenciar_historia_adm" class="btn-fechar" title="Fechar" aria-label="Fechar e voltar para o gerenciamento de histórias">
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

        <!-- FAZER COMENTÁRIO (como administrador) -->
        <form action="" method="POST" class="secao-comentario" data-autor="<?= htmlspecialchars($admin_nome) ?>">
            <label for="comentario" class="titulo-comentario">Escreva um comentário</label>
            <p class="dica-comentario">Seu comentário aparece com o selo de Administrador.</p>

            <textarea id="comentario" name="comentario" class="area-texto-comentario" maxlength="1000" required placeholder="Digite aqui seu comentário..."></textarea>

            <button type="submit" class="btn-enviar">Enviar</button>
        </form>

        <!-- LISTA DE COMENTÁRIOS -->
        <section class="lista-comentarios">

            <div class="titulo-lista-comentarios">
                Comentários (<span id="total-comentarios"><?= count($comentarios) ?></span>)
                <span class="info-ocultos" id="info-ocultos" <?= $total_ocultos > 0 ? '' : 'hidden' ?>>· <?= $total_ocultos ?> <?= $total_ocultos === 1 ? 'oculto' : 'ocultos' ?></span>
            </div>

            <p class="sem-comentarios" id="sem-comentarios" <?= empty($comentarios) ? '' : 'hidden' ?>>Ainda não há comentários. Seja o primeiro a comentar!</p>

            <div id="itens-comentarios">
                <?php foreach ($comentarios as $c): ?>
                    <div class="comentario-item <?= $c['oculto'] ? 'oculto' : '' ?> <?= $c['do_admin'] ? 'do-admin' : '' ?>" data-id="<?= (int)$c['id'] ?>">

                        <div class="avatar-comentario" aria-hidden="true">
                            <?= htmlspecialchars(mb_strtoupper(mb_substr($c['nome'], 0, 1))) ?>
                        </div>

                        <div class="corpo-comentario">
                            <div class="cabecalho-comentario">
                                <span class="nome-comentario"><?= htmlspecialchars($c['nome']) ?></span>
                                <?php if ($c['do_admin']): ?>
                                    <span class="selo selo-admin">Administrador</span>
                                <?php else: ?>
                                    <span class="selo selo-oculto" <?= $c['oculto'] ? '' : 'hidden' ?>>Oculto</span>
                                <?php endif; ?>
                                <span class="data-comentario"><?= htmlspecialchars($c['data']) ?></span>
                            </div>

                            <p class="texto-comentario"><?= htmlspecialchars($c['texto']) ?></p>

                            <?php if (!$c['do_admin']): ?>
                                <p class="aviso-oculto" <?= $c['oculto'] ? '' : 'hidden' ?>>Este comentário não aparece para os usuários.</p>
                            <?php endif; ?>

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

                        <!-- Opções: ocultar/mostrar (só comentários de usuários) e excluir (todos) -->
                        <div class="opcoes-comentario">
                            <button type="button" class="btn-opcoes" aria-haspopup="true" aria-expanded="false"
                                    aria-label="Opções do comentário de <?= htmlspecialchars($c['nome']) ?>">⋮</button>

                            <div class="menu-opcoes-comentario">
                                <?php if (!$c['do_admin']): ?>
                                    <form action="" method="POST" class="form-ocultar">
                                        <input type="hidden" name="<?= $c['oculto'] ? 'mostrar_comentario' : 'ocultar_comentario' ?>" value="<?= (int)$c['id'] ?>">
                                        <button type="submit" class="item-menu"><?= $c['oculto'] ? 'Mostrar comentário' : 'Ocultar comentário' ?></button>
                                    </form>
                                <?php endif; ?>

                                <form action="" method="POST" class="form-excluir">
                                    <input type="hidden" name="excluir_comentario" value="<?= (int)$c['id'] ?>">
                                    <button type="submit" class="item-menu item-excluir">Excluir comentário</button>
                                </form>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Modelo usado pelo JavaScript para mostrar um comentário novo do administrador -->
            <template id="modelo-comentario">
                <div class="comentario-item do-admin" data-id="">
                    <div class="avatar-comentario" aria-hidden="true"></div>

                    <div class="corpo-comentario">
                        <div class="cabecalho-comentario">
                            <span class="nome-comentario"></span>
                            <span class="selo selo-admin">Administrador</span>
                            <span class="data-comentario"></span>
                        </div>

                        <p class="texto-comentario"></p>

                        <form action="" method="POST" class="form-curtir">
                            <input type="hidden" name="curtir_comentario" value="">
                            <button type="submit" class="btn-curtir" aria-pressed="false" title="Curtir comentário">
                                <span class="icone-curtir" aria-hidden="true">♥</span>
                                <span class="qtd-curtidas">0</span>
                            </button>
                        </form>
                    </div>

                    <div class="opcoes-comentario">
                        <button type="button" class="btn-opcoes" aria-haspopup="true" aria-expanded="false" aria-label="Opções do comentário">⋮</button>

                        <div class="menu-opcoes-comentario">
                            <form action="" method="POST" class="form-excluir">
                                <input type="hidden" name="excluir_comentario" value="">
                                <button type="submit" class="item-menu item-excluir">Excluir comentário</button>
                            </form>
                        </div>
                    </div>
                </div>
            </template>

        </section>

    </article>

    <!-- Avisos para leitores de tela (comentário publicado, ocultado, excluído...) -->
    <p class="sr-only" id="aviso-acao" role="status" aria-live="polite"></p>

</main>

<!-- CONFIRMAÇÃO DE EXCLUSÃO (mesmo texto da tela "Excluir comentário") -->
<dialog id="dialogo-excluir" class="dialogo-excluir" aria-labelledby="titulo-dialogo-excluir">
    <form method="dialog" class="dialogo-conteudo">
        <h2 id="titulo-dialogo-excluir">Deseja realmente excluir este comentário?</h2>

        <p>O comentário será apagado permanentemente, exclua se tiver certeza dessa decisão.</p>

        <div class="dialogo-botoes">
            <button type="submit" value="cancelar" class="btn-cancelar" autofocus>Cancelar</button>
            <button type="submit" value="confirmar" class="btn-confirmar-excluir">Excluir</button>
        </div>
    </form>
</dialog>

<?php include APP . '/Views/administrador/footer_adm.php'; ?>

<!-- Simulação das ações de comentários (remover ao ligar o PHP/banco) -->
<script src="<?=URL?>/public/js/historias_adm.js"></script>

<!-- VLibras -->
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
</script>

</body>
</html>
