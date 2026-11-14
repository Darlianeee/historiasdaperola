
<?php
// Recebe os dados enviados pelo controller.
$notificacoes = $notificacoes ?? [];
$filtro = $filtro ?? 'todas';
$busca = $busca ?? '';
$data = $data ?? '';

// Define a rota da lista de notificações.
$rotaLista = URL . '/usuarios/notificacoes_user';

// Escolhe o ícone de acordo com o assunto da notificação.
$iconeDaNotificacao = static function ($titulo) {

    $t = mb_strtolower($titulo, 'UTF-8');

    if (str_contains($t, 'avalia')) {
        return ['estrela', 'logo estrela.png', 'icon-estrela', 'Estrela: notificação de avaliação'];
    }

    if (str_contains($t, 'coment') || str_contains($t, 'respond')) {
        return ['comentario', 'comen.png', 'icon-comentario', 'Balão de fala: notificação de comentário'];
    }

    if (str_contains($t, 'edit')) {
        return ['caneta', 'caneta.png', 'icon-caneta', 'Lápis: notificação de história editada'];
    }

    return ['livro', 'livro.png', 'icon-livro', 'Livro: notificação de história'];
};

// Cria os links dos filtros mantendo a busca e a data.
$linkFiltro = static function ($valor) use ($rotaLista, $busca, $data) {

    $parametros = array_filter([
        'filtro' => $valor,
        'busca' => $busca,
        'data' => $data
    ], 'strlen');

    return $rotaLista . '?' . http_build_query($parametros);
};
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/notificacoes_user.css">

    <title>Notificações</title>

    <style>
        /* Organiza os botões do topo. */
        .topo a.botao {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        /* Destaca o filtro selecionado. */
        .topo .botao.ativo {
            background: #BE9628;
            color: #FFFFFF;
        }

        /* Permite que o formulário utilize o espaço disponível. */
        .topo form {
            display: contents;
        }

        /* Destaca as notificações que ainda não foram lidas. */
        .notificacao.nao-lida {
            border-left: 5px solid #BE9628;
        }

        /* Identifica as notificações novas. */
        .notificacao.nao-lida .texto h3::after {
            content: "Nova";
            margin-left: 8px;
            padding: 2px 8px;
            border-radius: 10px;
            background: #BE9628;
            color: #fff;
            font-size: 11px;
            vertical-align: middle;
        }

        /* Define a aparência da mensagem sem notificações. */
        .sem-notificacoes {
            padding: 24px;
            text-align: center;
            color: #666;
        }

        /* Mantém as quebras de linha das mensagens. */
        .texto p {
            white-space: pre-line;
        }
    </style>

</head>

<body>

    <?php include APP . '/Views/usuarios/menu_user.php'; ?>

    <main class="container">

        <!-- Apresenta o título e a descrição da página. -->
        <section class="cabecalho">

            <h1>Notificações</h1>

            <p>Acompanhe suas notificações.</p>

        </section>

        <?php Sessao::exibirFlash(); ?>

        <!-- Apresenta os filtros e a seleção de data. -->
        <section class="topo">

            <a
                class="botao <?= $filtro === 'todas' ? 'ativo' : '' ?>"
                href="<?= Html::e($linkFiltro('todas')) ?>">
                Todas
            </a>

            <a
                class="botao <?= $filtro === 'nao_lidas' ? 'ativo' : '' ?>"
                href="<?= Html::e($linkFiltro('nao_lidas')) ?>">
                Não Lidas
            </a>

            <a
                class="botao <?= $filtro === 'lidas' ? 'ativo' : '' ?>"
                href="<?= Html::e($linkFiltro('lidas')) ?>">
                Lidas
            </a>

            <!-- Envia a data selecionada para filtrar as notificações. -->
            <form method="get" action="<?= $rotaLista ?>">

                <input
                    type="hidden"
                    name="filtro"
                    value="<?= Html::e($filtro) ?>"
                >

                <?php if ($busca !== ''): ?>
                    <input
                        type="hidden"
                        name="busca"
                        value="<?= Html::e($busca) ?>"
                    >
                <?php endif; ?>

                <input
                    type="date"
                    name="data"
                    value="<?= Html::e($data) ?>"
                    class="data"
                    aria-label="Filtrar por data"
                    onchange="this.form.submit()"
                >

            </form>

        </section>

        <!-- Apresenta a lista de notificações. -->
        <section class="lista-notificacoes">

            <?php if (empty($notificacoes)): ?>

                <p class="sem-notificacoes">
                    <?= ($busca !== '' || $data !== '' || $filtro !== 'todas')
                        ? 'Nenhuma notificação encontrada com esses filtros.'
                        : 'Você ainda não tem notificações.' ?>
                </p>

            <?php endif; ?>

            <?php foreach ($notificacoes as $n): ?>

                <?php
                // Obtém o ícone correspondente à notificação.
                [$classeIcone, $imagemIcone, $classeImagem, $altIcone] =
                    $iconeDaNotificacao($n->noti_titulo);

                $notiId = (int) $n->noti_id;
                ?>

                <!-- Apresenta as informações de cada notificação. -->
                <article class="notificacao <?= (int) $n->peno_lida === 0 ? 'nao-lida' : '' ?>">

                    <div class="icone <?= $classeIcone ?>">

                        <img
                            src="<?= URL ?>/public/img/<?= $imagemIcone ?>"
                            alt="<?= $altIcone ?>"
                            class="<?= $classeImagem ?>"
                        >

                    </div>

                    <div class="texto">

                        <h3>
                            <?= Html::e($n->noti_titulo) ?>
                        </h3>

                        <p>
                            <?= Html::e(mb_strimwidth($n->noti_mensagem, 0, 180, '...', 'UTF-8')) ?>
                        </p>

                        <span>
                            <?= Html::e(Html::tempoRelativo($n->noti_data_hora)) ?>
                        </span>

                    </div>

                    <div class="notification-action">

                        <input
                            type="checkbox"
                            id="menu-<?= $notiId ?>"
                            class="menu-toggle"
                        >

                        <label
                            for="menu-<?= $notiId ?>"
                            class="menu-dots"
                            aria-label="Abrir opções"
                        >

                            <img
                                src="<?= URL ?>/public/img/pontoo.png"
                                alt="Opções da notificação"
                                class="icon-ponto"
                            >

                        </label>

                        <div class="dropdown-menu">

                            <a
                                href="<?= URL ?>/usuarios/detalhes_notificacao_user?id=<?= $notiId ?>"
                                class="detalhes-link">
                                Ver detalhes
                            </a>

                            <?php if ((int) $n->peno_lida === 0): ?>

                                <a
                                    href="<?= URL ?>/usuarios/marcar_lida?id=<?= $notiId ?>"
                                    class="marcar-lida-link">
                                    Marcar como lida
                                </a>

                            <?php endif; ?>

                            <a
                                href="<?= URL ?>/usuarios/excluir_notificacao_user?id=<?= $notiId ?>"
                                class="delete-btn">
                                Excluir
                            </a>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </section>

    </main>

    <?php include APP . '/Views/paginas/footer.php'; ?>

    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
    <script src="<?= URL ?>/public/js/notificacao.js"></script>

</body>

</html>
