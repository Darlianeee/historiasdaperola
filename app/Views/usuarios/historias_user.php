<?php
$nome = $nome ?? 'Usuário';
$titulo_lenda = $titulo_lenda ?? 'Título da Lenda';
$legenda_imagem = $legenda_imagem ?? 'Legenda da imagem';
$texto_lenda = $texto_lenda ?? 'O conteúdo desta lenda será exibido aqui.';

// Comentários demonstrativos.
$comentarios = $comentarios ?? [
    [
        'id' => 1,
        'nome' => 'Maria Souza',
        'data' => '18/09/2026',
        'texto' => 'Adorei conhecer essa lenda, é muito bonita e importante para a nossa cultura.'
    ],
    [
        'id' => 2,
        'nome' => 'João Pereira',
        'data' => '17/09/2026',
        'texto' => 'Minha avó contava uma versão parecida dessa história quando eu era criança.'
    ],
    [
        'id' => 3,
        'nome' => 'Ana Karolina',
        'data' => '15/09/2026',
        'texto' => 'Muito legal poder ler em outros idiomas também!'
    ],
];

$idiomasPermitidos = ['es', 'wari'];
$idioma_atual = $_GET['lang'] ?? 'es';

if (!in_array($idioma_atual, $idiomasPermitidos, true)) {
    $idioma_atual = 'es';
}

$esc = static fn($valor) =>
    htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $esc($titulo_lenda) ?> - Histórias na Pérola
    </title>

    <link
        rel="stylesheet"
        href="<?= URL ?>/public/css/historias_user.css"
    >
</head>

<body>

<?php require APP . '/Views/usuarios/menu_user.php'; ?>

<main class="conteudo">

    <h1>História</h1>

    <p class="subtitulo">
        Mito ou lenda escolhida.
    </p>

    <section class="modal-historia">

        <a
            href="<?= URL ?>/usuarios/escolher_historia_user"
            class="btn-fechar"
            title="Voltar"
            aria-label="Voltar para as histórias"
        >
            <span class="icon-close" aria-hidden="true">×</span>
        </a>

        <h2 class="titulo-lenda">
            <?= $esc($titulo_lenda) ?>
        </h2>

        <div class="box-imagem">
            Imagem da história
        </div>

        <p class="legenda">
            <?= $esc($legenda_imagem) ?>
        </p>

        <div class="texto-lenda">
            <?= nl2br($esc(strip_tags((string)$texto_lenda))) ?>
        </div>

        <div class="secao-idiomas">

            <div class="titulo-idiomas">
                <img
                    src="<?= URL ?>/public/img/icone_globo.png"
                    alt=""
                    aria-hidden="true"
                >

                <span>
                    Ler esta lenda em outras línguas
                </span>
            </div>

            <p class="subtitulo-idiomas">
                Escolha o idioma para ver a versão completa da lenda.
            </p>

            <div class="botoes-idiomas">

                <a
                    href="?lang=es"
                    class="btn-idioma <?= $idioma_atual === 'es' ? 'ativo' : '' ?>"
                    <?= $idioma_atual === 'es' ? 'aria-current="true"' : '' ?>
                >
                    <img
                        src="<?= URL ?>/public/img/espanha.png"
                        alt=""
                        class="img-espanha"
                        aria-hidden="true"
                    >

                    <span>Espanhol</span>
                </a>

                <a
                    href="?lang=wari"
                    class="btn-idioma <?= $idioma_atual === 'wari' ? 'ativo' : '' ?>"
                    <?= $idioma_atual === 'wari' ? 'aria-current="true"' : '' ?>
                >
                    <img
                        src="<?= URL ?>/public/img/icone_logo_menu.png"
                        alt=""
                        class="img-wari"
                        aria-hidden="true"
                    >

                    <span>Wari' Oro Nao</span>
                </a>

            </div>
        </div>

        <form
            action=""
            method="POST"
            class="secao-comentario"
        >

            <label
                for="comentario"
                class="titulo-comentario"
            >
                O que você achou desta lenda?
            </label>

            <textarea
                id="comentario"
                name="comentario"
                class="area-texto-comentario"
                maxlength="1000"
                placeholder="Digite aqui seu comentário..."
                required
            ></textarea>

            <button
                type="submit"
                class="btn-enviar"
            >
                Enviar
            </button>

            <p class="aviso-comentario">
                O envio precisa estar conectado ao processamento no servidor.
            </p>

        </form>

        <section
            class="lista-comentarios"
            aria-labelledby="titulo-lista-comentarios"
        >

            <h3
                class="titulo-lista-comentarios"
                id="titulo-lista-comentarios"
            >
                Comentários (<?= count($comentarios) ?>)
            </h3>

            <?php if (empty($comentarios)): ?>

                <p class="sem-comentarios">
                    Ainda não há comentários.
                    Seja o primeiro a comentar!
                </p>

            <?php else: ?>

                <?php foreach ($comentarios as $c): ?>

                    <article class="comentario-item">

                        <div
                            class="avatar-comentario"
                            aria-hidden="true"
                        >
                            <?= $esc(
                                function_exists('mb_substr')
                                    ? mb_strtoupper(
                                        mb_substr(
                                            (string)$c['nome'],
                                            0,
                                            1,
                                            'UTF-8'
                                        ),
                                        'UTF-8'
                                    )
                                    : strtoupper(
                                        substr(
                                            (string)$c['nome'],
                                            0,
                                            1
                                        )
                                    )
                            ) ?>
                        </div>

                        <div class="corpo-comentario">

                            <div class="cabecalho-comentario">

                                <span class="nome-comentario">
                                    <?= $esc($c['nome']) ?>
                                </span>

                                <time class="data-comentario">
                                    <?= $esc($c['data']) ?>
                                </time>

                            </div>

                            <p class="texto-comentario">
                                <?= nl2br($esc($c['texto'])) ?>
                            </p>

                            <form
                                action=""
                                method="POST"
                                class="form-excluir-comentario"
                                onsubmit="return confirmarExclusaoComentario(this)"
                            >

                                <input
                                    type="hidden"
                                    name="excluir_comentario"
                                    value="<?= (int)$c['id'] ?>"
                                >

                                <button
                                    type="submit"
                                    class="btn-excluir-comentario"
                                >
                                    Excluir comentário
                                </button>

                            </form>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </section>

</main>

<?php require APP . '/Views/usuarios/footer_user.php'; ?>

<script
    src="<?= URL ?>/public/js/historias_comentarios.js"
    defer
></script>

</body>
</html>
