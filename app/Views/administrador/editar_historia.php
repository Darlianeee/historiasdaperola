<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar História</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/editar_historia.css">

</head>


<body>


<?php include '../App/Views/administrador/menu_adm.php'; ?>


<!-- CONTEÚDO PRINCIPAL -->

<main class="pagina">


    <!-- TÍTULO DA PÁGINA -->

    <section class="cabecalho-pagina">

        <h1>Editar História</h1>

        <p>Modifique suas histórias.</p>

    </section>



    <!-- MODAL -->

    <section class="modal">


        <!-- CABEÇALHO -->

        <div class="modal-header">

            <h2>Editar História</h2>

            <a
                href="<?=URL?>/administrador/gerenciar_historia_adm"
                class="fechar"
                aria-label="Fechar"
            >
                ×
            </a>

        </div>



        <!-- IMAGEM -->

        <div class="imagem-container">

            <div class="imagem-preview"></div>

        </div>



        <!-- SELECIONAR LÍNGUA -->

        <!-- LÍNGUA + SUBSTITUIR IMAGEM -->

        <div class="linha-lingua-imagem">

            <div class="lingua">

                <select id="lingua" name="lingua">

                    <option>
                        Selecionar idioma
                    </option>

                    <option>
                        Português
                    </option>

                    <option>
                        Espanhol
                    </option>

                    <option>
                        Wari' Oro Nao
                    </option>

                </select>

            </div>

            <button
                type="button"
                class="btn-substituir"
            >
                Substituir imagem
            </button>

        </div>



        <!-- FORMULÁRIO -->

        <form>


            <!-- TÍTULO + LEGENDA -->

            <div class="linha-campos">


                <!-- TÍTULO -->

                <div class="campo">

                    <label id="labelTitulo" for="titulo">
                        Título
                    </label>

                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        placeholder="Título da história..."
                    >

                </div>



                <!-- LEGENDA -->

                <div class="campo">

                    <label id="labelLegenda" for="legenda">
                        Legenda da imagem 
                    </label>

                    <input
                        type="text"
                        id="legenda"
                        name="legenda"
                        placeholder="Legenda da imagem..."
                    >

                </div>


            </div>



            <!-- TEXTO -->

            <div class="campo texto-campo">

                <label id="labelTexto" for="texto">
                    Texto 
                </label>

                <textarea
                    id="texto"
                    name="texto"
                    placeholder="Texto da história..."
                ></textarea>

            </div>



            <!-- BOTÕES -->

            <div class="botoes">

                <button
                    type="button"
                    class="btn-cancelar">
                    <a href="<?=URL?>/administrador/gerenciar_historia_adm">
                        Cancelar
                    </a>
                </button>

                <button
                    type="button"
                    class="btn-salvar"
                >
                    Salvar
                </button>

            </div>

        </form>


    </section>


</main>


<?php include '../App/Views/administrador/footer_adm.php'; ?>

</body>

</html>