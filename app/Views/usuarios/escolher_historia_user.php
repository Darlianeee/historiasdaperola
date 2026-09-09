<?php
$subtitulo = "Visualize e leia novas histórias.";

$historias = array_fill(0, 12, [
    'titulo' => 'Nome da história',
    'categoria' => 'Categoria',
    'imagem' => ''
]);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Histórias - Histórias na Pérola</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/escolher_historia_user.css">
</head>

<body>

<?php include '../App/Views/usuarios/menu_user.php'; ?>

<main class="conteudo">

    <h1>Histórias</h1>

    <p class="subtitulo">
        <?php echo htmlspecialchars($subtitulo); ?>
    </p>

    <!-- BARRA DE PESQUISA -->
    <div class="busca-container">

        <form action="" method="GET" class="busca-box">

            <!-- LUPA -->
            <span class="icone-busca" aria-hidden="true">
                <img src="<?=URL?>/public/img/LUPA2.png" alt="Ícone de busca">
            </span>

            <input 
                type="text" 
                name="busca" 
                placeholder="Digite nome de uma lenda ou de um mito.."
            >

        </form>

    </div>


    <!-- GRID DE HISTÓRIAS -->
    <section class="grid-historias">

        <?php foreach ($historias as $item): ?>

            <div class="card-item">

                <!-- IMAGEM -->
                <div class="card-imagem">

                    <?php if (!empty($item['imagem'])): ?>

                        <img 
                            src="<?php echo htmlspecialchars($item['imagem']); ?>" 
                            alt="Imagem da História"
                        >

                    <?php endif; ?>

                </div>


                <!-- INFORMAÇÕES DO CARD -->
                <div class="card-info">

                    <div class="card-texto">

                        <div class="card-titulo">
                            <?php echo htmlspecialchars($item['titulo']); ?>
                        </div>

                        <div class="card-categoria">
                            <?php echo htmlspecialchars($item['categoria']); ?>
                        </div>

                    </div>


                    <!-- BOTÃO LER -->
                    <a href="<?=URL?>/usuarios/historias_user" class="btn-ler">
                        Ler história
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </section>

</main>

<?php include '../App/Views/usuarios/footer_user.php'; ?>

</body>
</html>