<?php
$subtitulo = "Adicione novas histórias.";

$historias = array_fill(0, 12, [
    'id' => 1,
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

    <title>Gerenciar Histórias - Histórias na Pérola</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/gerenciar_historia_adm.css">
</head>

<body>

<?php include '../App/Views/administrador/menu_adm.php'; ?>

<main class="conteudo">

    <h1>Gerenciar Histórias</h1>

    <p class="subtitulo">
        <?= htmlspecialchars($subtitulo); ?>
    </p>


    <!-- BARRA DE FERRAMENTAS -->
    <div class="ferramentas-container">

        <!-- BUSCA -->
        <div class="busca-box">

            <span class="icone-busca" aria-hidden="true">
                <img src="<?=URL?>/public/img/LUPA2.png" alt="Ícone de busca">
            </span>

            <input
                type="text"
                placeholder="Buscar História..."
            >

        </div>


        <!-- CATEGORIA -->
        <select class="select-categoria">

            <option value="">Categoria</option>

            <option value="mito">
                Mito
            </option>

            <option value="lenda">
                Lenda
            </option>

        </select>


        <!-- NOVA HISTÓRIA -->
        <a
            href="<?=URL?>/administrador/nova_historia"
            class="btn-nova-historia"
        >
            + Nova História
        </a>

    </div>


    <!-- GRID DE HISTÓRIAS -->
    <section class="grid-historias">

        <?php foreach ($historias as $index => $item): ?>

            <div class="card-item">

                <div class="card-imagem-wrapper">

                    <?php if (!empty($item['imagem'])): ?>

                        <img 
                            src="<?= htmlspecialchars($item['imagem']); ?>" 
                            alt="Imagem da História"
                        >

                    <?php endif; ?>

                    <button 
                        class="btn-opcoes"
                        type="button"
                        onclick="toggleMenu(event, <?= $index; ?>)"
                        aria-label="Opções da história"
                    >
                        ⋮
                    </button>

                    <div 
                        class="menu-opcoes"
                        id="menu-<?= $index; ?>"
                    >

                        <a href="<?=URL?>/administrador/editar_historia_adm?id=<?= $item['id']; ?>">
                            Editar História
                        </a>

                        <a 
                            href="<?=URL?>/administrador/excluir_historia_adm?id=<?= $item['id']; ?>"
                            class="btn-apagar"
                        >
                            Excluir História
                        </a>

                    </div>

                </div>


                <!-- PARTE BRANCA DO CARD -->
                <div class="card-info">

                    <div class="card-textos">

                        <div class="card-titulo">
                            <?= htmlspecialchars($item['titulo']); ?>
                        </div>

                        <div class="card-categoria">
                            <?= htmlspecialchars($item['categoria']); ?>
                        </div>

                    </div>

                    <a href="<?=URL?>/administrador/historias_adm" class="btn-ler">
                        Ver história
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </section>

</main>


<script>

function toggleMenu(event, index) {

    event.stopPropagation();

    const menus = document.querySelectorAll('.menu-opcoes');

    menus.forEach((menu, i) => {

        if (i !== index) {
            menu.classList.remove('ativo');
        }

    });

    const menuAtual = document.getElementById('menu-' + index);

    menuAtual.classList.toggle('ativo');
}


document.addEventListener('click', function () {

    const menus = document.querySelectorAll('.menu-opcoes');

    menus.forEach(menu => {
        menu.classList.remove('ativo');
    });

});

</script>


<?php include '../App/Views/administrador/footer_adm.php'; ?>

</body>
</html>