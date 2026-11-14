
<?php
// Recebe os dados enviados pelo controller e define valores padrão caso estejam vazios.
$notificacoes = $notificacoes ?? [];
$filtro = $filtro ?? 'todas';
$busca = $busca ?? '';
$data = $data ?? '';

// Armazena o endereço da página responsável por listar as notificações.
$rotaLista = URL . '/administrador/notificacoes_adm';

// Cria uma função para escolher o ícone de acordo com o assunto da notificação.
$iconeDaNotificacao = static function ($titulo) {
    // Converte o título para letras minúsculas para facilitar a identificação das palavras.
    $t = mb_strtolower($titulo, 'UTF-8');

    // Verifica se o título está relacionado a uma avaliação.
    if (str_contains($t, 'avalia')) {
        return ['estrela', 'logo estrela.png', 'icon-estrela', 'Estrela: notificação de avaliação'];
    }

    // Verifica se o título está relacionado a um comentário ou resposta.
    if (str_contains($t, 'coment') || str_contains($t, 'respond')) {
        return ['comentario', 'comen.png', 'icon-comentario', 'Balão de fala: notificação de comentário'];
    }

    // Verifica se o título está relacionado à edição de uma história.
    if (str_contains($t, 'edit')) {
        return ['caneta', 'caneta.png', 'icon-caneta', 'Lápis: notificação de história editada'];
    }

    // Caso não corresponda às opções anteriores, utiliza o ícone de livro.
    return ['livro', 'livro.png', 'icon-livro', 'Livro: notificação de história'];
};

// Cria uma função para gerar os links dos filtros, mantendo os valores da busca e da data.
$linkFiltro = static function ($valor) use ($rotaLista, $busca, $data) {
    // Organiza os parâmetros que serão enviados pela URL e remove os valores vazios.
    $parametros = array_filter(['filtro' => $valor, 'busca' => $busca, 'data' => $data], 'strlen');

    // Gera o endereço com os parâmetros do filtro selecionado.
    return $rotaLista . '?' . http_build_query($parametros);
};
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <!-- Define a codificação de caracteres da página -->
    <meta charset="UTF-8">

    <!-- Ajusta a página para diferentes tamanhos de tela -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/notificacoes_adm.css">

    <!-- Define o título da página -->
    <title>Notificações</title>

</head>


<body>

    <!-- Inclui o menu de navegação do administrador -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>


    <!-- Área principal que reúne o conteúdo da página -->
    <main class="container">


        <!-- Cabeçalho com o título e a descrição da página -->
        <section class="cabecalho">

            <h1>Notificações</h1>

            <p>
                Acompanhe suas notificações.
            </p>

        </section>

        <!-- Exibe mensagens temporárias do sistema, como avisos de sucesso ou erro -->
        <?php Sessao::exibirFlash(); ?>


        <!-- Área dos filtros, da busca e da seleção de data -->
        <section class="topo">

            <!-- Exibe todas as notificações e indica quando esse filtro está selecionado -->
            <a class="botao <?= $filtro === 'todas' ? 'ativo' : '' ?>" href="<?= Html::e($linkFiltro('todas')) ?>">
                Todas
            </a>

            <!-- Exibe somente as notificações que ainda não foram lidas -->
            <a class="botao <?= $filtro === 'nao_lidas' ? 'ativo' : '' ?>" href="<?= Html::e($linkFiltro('nao_lidas')) ?>">
                Não Lidas
            </a>

            <!-- Exibe somente as notificações que já foram lidas -->
            <a class="botao <?= $filtro === 'lidas' ? 'ativo' : '' ?>" href="<?= Html::e($linkFiltro('lidas')) ?>">
                Lidas
            </a>

            <!-- Formulário responsável por enviar os dados de busca e filtragem -->
            <form method="get" action="<?= $rotaLista ?>">

                <!-- Mantém o filtro selecionado ao realizar uma busca -->
                <input type="hidden" name="filtro" value="<?= Html::e($filtro) ?>">

                <!-- Campo utilizado para pesquisar notificações -->
                <div class="buscar">

                    <!-- Exibe o ícone de lupa ao lado do campo de busca -->
                    <img
                        src="<?= URL ?>/public/img/LUPA2.png"
                        alt="Lupa: buscar notificações"
                        class="icon-Lupa">

                    <!-- Campo para digitar o termo que será pesquisado -->
                    <input
                        type="text"
                        name="busca"
                        value="<?= Html::e($busca) ?>"
                        placeholder="Buscar notificações..."
                        aria-label="Buscar notificações">

                </div>

                <!-- Permite selecionar uma data específica para filtrar as notificações -->
                <input
                    type="date"
                    name="data"
                    value="<?= Html::e($data) ?>"
                    class="data"
                    aria-label="Filtrar por data"
                    onchange="this.form.submit()">

            </form>

        </section>


        <!-- Área responsável por exibir a lista de notificações -->
        <section class="lista-notificacoes">

            <!-- Verifica se não existem notificações para exibir -->
            <?php if (empty($notificacoes)): ?>

                <!-- Apresenta uma mensagem diferente dependendo dos filtros utilizados -->
                <p class="sem-notificacoes">
                    <?= ($busca !== '' || $data !== '' || $filtro !== 'todas')
                        ? 'Nenhuma notificação encontrada com esses filtros.'
                        : 'Você ainda não tem notificações.' ?>
                </p>

            <?php endif; ?>

            <!-- Percorre todas as notificações recebidas pelo controller -->
            <?php foreach ($notificacoes as $n): ?>
                <?php
                // Obtém as informações do ícone de acordo com o título da notificação.
                [$classeIcone, $imagemIcone, $classeImagem, $altIcone] = $iconeDaNotificacao($n->noti_titulo);

                // Converte o ID da notificação para número inteiro.
                $notiId = (int) $n->noti_id;
                ?>

                <!-- Exibe uma notificação e adiciona uma classe caso ela ainda não tenha sido lida -->
                <article class="notificacao <?= (int) $n->peno_lida === 0 ? 'nao-lida' : '' ?>">

                    <!-- Área responsável por apresentar o ícone da notificação -->
                    <div class="icone <?= $classeIcone ?>">

                        <!-- Exibe a imagem correspondente ao assunto da notificação -->
                        <img
                            src="<?= URL ?>/public/img/<?= $imagemIcone ?>"
                            alt="<?= $altIcone ?>"
                            class="<?= $classeImagem ?>">

                    </div>


                    <!-- Área com o título, a mensagem e a data da notificação -->
                    <div class="texto">

                        <!-- Exibe o título da notificação -->
                        <h3>
                            <?= Html::e($n->noti_titulo) ?>
                        </h3>

                        <!-- Exibe uma parte da mensagem, limitando o texto a 180 caracteres -->
                        <p><?= Html::e(mb_strimwidth($n->noti_mensagem, 0, 180, '...', 'UTF-8')) ?></p>

                        <!-- Exibe há quanto tempo a notificação foi recebida -->
                        <span>
                            <?= Html::e(Html::tempoRelativo($n->noti_data_hora)) ?>
                        </span>

                    </div>


                    <!-- Área que contém as opções disponíveis para cada notificação -->
                    <div class="notification-action">


                        <!-- Caixa de seleção utilizada para controlar a abertura do menu de opções -->
                        <input
                            type="checkbox"
                            id="menu-<?= $notiId ?>"
                            class="menu-toggle">


                        <!-- Botão visual que permite abrir e fechar o menu de opções -->
                        <label
                            for="menu-<?= $notiId ?>"
                            class="menu-dots"
                            aria-label="Abrir opções">

                            <!-- Exibe o ícone de três pontos -->
                            <img
                                src="<?= URL ?>/public/img/pontoo.png"
                                alt="Opções da notificação"
                                class="icon-ponto">

                        </label>


                        <!-- Menu suspenso com as ações disponíveis para a notificação -->
                        <div class="dropdown-menu">

                            <!-- Direciona para a página com os detalhes completos da notificação -->
                            <a href="<?= URL ?>/administrador/detalhe_notificacao_adm?id=<?= $notiId ?>" class="detalhes-link">
                                Ver detalhes
                            </a>

                            <!-- Verifica se a notificação ainda não foi lida -->
                            <?php if ((int) $n->peno_lida === 0): ?>

                                <!-- Exibe a opção para marcar a notificação como lida -->
                                <a href="<?= URL ?>/administrador/marcar_lida?id=<?= $notiId ?>" class="marcar-lida-link">
                                    Marcar como lida
                                </a>

                            <?php endif; ?>

                            <!-- Direciona para a página de confirmação da exclusão da notificação -->
                            <a
                                href="<?= URL ?>/administrador/excluir_notificacao_adm?id=<?= $notiId ?>"
                                class="delete-btn">
                                Excluir
                            </a>

                        </div>


                    </div>


                </article>

            <?php endforeach; ?>

        </section>


    </main>

    <!-- Inclui o rodapé do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa os arquivos JavaScript utilizados nas configurações e nas notificações -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
    <script src="<?= URL ?>/public/js/notificacao.js"></script>
</body>

</html>
