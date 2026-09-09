<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nova História</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/nova_historia.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet"
    >

</head>


<body>


<?php include '../App/Views/administrador/menu_adm.php'; ?>


<div class="container">


    <!-- TÍTULO DA PÁGINA -->

    <div class="titulo-pagina">

        <h1>Nova História</h1>

        <p>Adicione novas histórias.</p>

    </div>



    <!-- CARD -->

    <div class="card">


        <h2>Adicionar nova história</h2>

        <span>Preencha os campos em cada língua.</span>



        <!-- IDIOMAS -->

        <div class="idiomas">


            <!-- PORTUGUÊS -->

            <button
                type="button"
                class="ativo"
                data-idioma="pt"
            >

                <img
                    src="<?=URL?>/public/img/brasil.png"
                    alt="Bandeira do Brasil"
                >

                <span>Português</span>

            </button>



            <!-- ESPANHOL -->

            <button
                type="button"
                data-idioma="es"
            >

                <img
                    src="<?=URL?>/public/img/espanha.png"
                    alt="Bandeira da Espanha"
                >

                <span>Espanhol</span>

            </button>



            <!-- WARI' ORO NAO -->

            <button
                type="button"
                class="idioma-wari"
                data-idioma="wari"
            >

                <img
                    src="<?=URL?>/public/img/icone_logo_menu.png"
                    alt="Logo Wari' Oro Nao"
                >

                <span>Wari' Oro Nao</span>

            </button>


        </div>



        <!-- CATEGORIA + IMAGEM -->

        <div class="linha">


            <!-- CATEGORIA -->

            <div class="campo">

                <label>Categoria</label>

                <select id="categoria">

                    <option value="">
                        Todas as categorias
                    </option>

                    <option value="mito">
                        Mito
                    </option>

                    <option value="lenda">
                        Lenda
                    </option>

                </select>

            </div>



            <!-- IMAGEM -->

            <div class="campo imagem">

                <label>Imagem</label>

                <button
                    type="button"
                    class="btnImagem"
                >
                    Adicionar imagem
                </button>

            </div>


        </div>



        <!-- TÍTULO + LEGENDA -->

        <div class="linha">


            <!-- TÍTULO -->

            <div class="campo">

                <label id="labelTitulo">
                    Título (Português)
                </label>

                <input
                    type="text"
                    id="titulo"
                    placeholder="Digite o título em português..."
                >

            </div>



            <!-- LEGENDA -->

            <div class="campo">

                <label id="labelLegenda">
                    Legenda da imagem (Português)
                </label>

                <input
                    type="text"
                    id="legenda"
                    placeholder="Digite a legenda da imagem..."
                >

            </div>


        </div>



        <!-- TEXTO -->

        <div class="campo">

            <label id="labelTexto">
                Texto (Português)
            </label>

            <textarea
                id="texto"
                placeholder="Digite o texto em português..."
            ></textarea>

        </div>



        <!-- AÇÕES -->

        <div class="acoes">


            <!-- CANCELAR -->

            <button
                type="button"
                class="cancelar"
            >

                <a href="<?=URL?>/administrador/gerenciar_historia_adm">
                    Cancelar
                </a>

            </button>



            <!-- SALVAR -->

            <button
                type="button"
                class="salvar"
            >
                Salvar
            </button>


        </div>


    </div>


</div>

<?php include '../App/Views/administrador/footer_adm.php'; ?>
<script src="<?=URL?>/public/js/nova_historia.js"></script>

</body>

</html>