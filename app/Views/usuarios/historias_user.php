<?php
$nome = "Usuário";
$titulo_lenda = "Título da Lenda";
$legenda_imagem = "Legenda:xxxxxxxxx";
$texto_lenda = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br><br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
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

        <!-- SEÇÃO DE FEEDBACK DO USUÁRIO -->
        <form action="" method="POST" class="secao-comentario">
            <div class="titulo-comentario">O que você achou desta lenda?</div>
            
            <div class="rating-stars">
                <input type="radio" id="star5" name="avaliacao" value="5"><label for="star5">★</label>
                <input type="radio" id="star4" name="avaliacao" value="4"><label for="star4">★</label>
                <input type="radio" id="star3" name="avaliacao" value="3"><label for="star3">★</label>
                <input type="radio" id="star2" name="avaliacao" value="2"><label for="star2">★</label>
                <input type="radio" id="star1" name="avaliacao" value="1"><label for="star1">★</label>
            </div>

            <textarea name="comentario" class="area-texto-comentario" placeholder="Digite aqui seu comentário..."></textarea>
            
            <div>
                <button type="submit" class="btn-enviar">Enviar</button>
            </div>
        </form>
    </section>
</main>

<?php include '../App/Views/usuarios/footer_user.php'; ?>
</body>
</html>