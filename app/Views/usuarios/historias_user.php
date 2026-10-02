<?php
$nome = "Usuário";
$titulo_lenda = "Título da Lenda";
$legenda_imagem = "Legenda:xxxxxxxxx";
$texto_lenda = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br><br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

/*
 * COMENTÁRIOS DOS USUÁRIOS
 * Por enquanto é um array de exemplo. Depois, troque por uma consulta ao banco, por exemplo:
 * $comentarios = $comentarioModel->listarPorHistoria($id_historia, $id_usuario_logado);
 * Cada item precisa ter: id, nome, data, texto, curtidas, curtiu (true/false).
 */
$comentarios = [
    ['id' => 1, 'nome' => 'Maria Souza',   'data' => '18/09/2026', 'texto' => 'Adorei conhecer essa lenda, é muito bonita e importante para a nossa cultura.', 'curtidas' => 12, 'curtiu' => true],
    ['id' => 2, 'nome' => 'João Pereira',  'data' => '17/09/2026', 'texto' => 'Minha avó contava uma versão parecida dessa história quando eu era criança.', 'curtidas' => 5,  'curtiu' => false],
    ['id' => 3, 'nome' => 'Ana Karolina',  'data' => '15/09/2026', 'texto' => 'Muito legal poder ler em outros idiomas também!', 'curtidas' => 0,  'curtiu' => false],
];
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

<?php include '../App/Views/usuarios/menu_user.php'; ?>

<main class="conteudo">
    <h1>História</h1>
    <p class="subtitulo">Mito ou lenda escolhida.</p>

    <section class="modal-historia">
        <a href="<?=URL?>/public/usuarios/escolher_historia_user" class="btn-fechar" title="Fechar">
            <div class="icon-close">✕</div>
        </a>

        <h2 class="titulo-lenda"><?php echo htmlspecialchars($titulo_lenda); ?></h2>

        <div class="box-imagem">
            IMAGEM
        </div>

        <p class="legenda"><?php echo htmlspecialchars($legenda_imagem); ?></p>

        <div class="texto-lenda">
            <?php echo $texto_lenda; ?>
        </div>

        <div class="secao-idiomas">
            <div class="titulo-idiomas">
                <img src="img/icone_globo.png" alt="Globo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23333\' stroke-width=\'2\'><circle cx=\'12\' cy=\'12\' r=\'10\'/><line x1=\'2\' y1=\'12\' x2=\'22\' y2=\'12\'/><path d=\'M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z\'/></svg>'">
                <span>Ler esta lenda em outras línguas</span>
            </div>

            <p class="subtitulo-idiomas">Escolha o idioma para ver a versão completa da lenda.</p>

            <?php
            $idioma_atual = $_GET['lang'] ?? 'es';
            ?>

            <div class="botoes-idiomas">

                <a href="?lang=es"
                class="btn-idioma <?= $idioma_atual === 'es' ? 'ativo' : '' ?>">
                    <img src="<?=URL?>/public/img/espanha.png" alt="Espanha" class="img-espanha">
                    <span>Espanhol</span>
                </a>

                <a href="?lang=wari"
                class="btn-idioma <?= $idioma_atual === 'wari' ? 'ativo' : '' ?>">
                    <img src="<?=URL?>/public/img/icone_logo_menu.png" alt="Wari Oro Nao" class="img-wari">
                    <span>Wari Oro Nao</span>
                </a>

            </div>
        </div>

        <!-- SEÇÃO DE COMENTÁRIO DO USUÁRIO (sem estrelas) -->
        <form action="" method="POST" class="secao-comentario">
            <div class="titulo-comentario">O que você achou desta lenda?</div>

            <textarea name="comentario" class="area-texto-comentario" placeholder="Digite aqui seu comentário..."></textarea>

            <div>
                <button type="submit" class="btn-enviar">Enviar</button>
            </div>
        </form>

        <!-- LISTA DE COMENTÁRIOS DOS USUÁRIOS -->
        <div class="lista-comentarios">
            <div class="titulo-lista-comentarios">Comentários (<?= count($comentarios) ?>)</div>

            <?php if (empty($comentarios)): ?>
                <p class="sem-comentarios">Ainda não há comentários. Seja o primeiro a comentar!</p>
            <?php else: ?>
                <?php foreach ($comentarios as $c): ?>
                    <div class="comentario-item">
                        <div class="avatar-comentario">
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
                                <button type="submit" class="btn-curtir <?= $c['curtiu'] ? 'curtido' : '' ?>" title="Curtir comentário">
                                    <span class="icone-curtir">♥</span>
                                    <span class="qtd-curtidas"><?= (int)$c['curtidas'] ?></span>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include '../App/Views/usuarios/footer_user.php'; ?>
</body>
</html>
