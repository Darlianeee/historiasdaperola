<?php
$nome = "Administrador";
$titulo_lenda = "Título da Lenda";
$legenda_imagem = "Legenda:xxxxxxxx";
$texto_lenda = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br><br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HISTÓRIAS NA PÉROLA
</title>
<link rel="stylesheet" href="<?=URL?>/public/css/historias_adm.css">
</head>
<body>
    <?php include '../App/Views/administrador/menu_adm.php'; ?> 

<main class="conteudo">
    <h1>História</h1>
    <p class="subtitulo">Mito ou lenda escolhida.</p>

    <section class="modal-historia">
        <a href="<?=URL?>/administrador/gerenciar_historia_adm" class="btn-fechar" title="Fechar">
            <div class="icon-close">✕</div>
        </a>

        <h2 class="titulo-lenda"><?php echo htmlspecialchars($titulo_lenda); ?></h2>

        <div class="box-imagem">
            <!-- Caso tenha imagem dinâmica, substitua a linha abaixo por: <img src="caminho_imagem.jpg" alt="Lenda"> -->
            IMAGEM
        </div>

        <p class="legenda"><?php echo htmlspecialchars($legenda_imagem); ?></p>

        <div class="texto-lenda">
            <?php echo $texto_lenda; ?>
        </div>

        <div class="secao-idiomas">
            <div class="titulo-idiomas">
                <img src="<?=URL?>/public/img/icone_globo.png" alt="Globo">
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
    </section>
</main>

<?php include '../App/Views/administrador/footer_adm.php'; ?>
</body>
</html>