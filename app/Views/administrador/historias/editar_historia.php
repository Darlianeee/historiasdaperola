
<?php
// Recupera os idiomas cadastrados para a história.
// Caso não existam idiomas, utiliza um array vazio.
$idiomas = $historia->idiomas ?? [];

// Separa os dados de cada idioma pelo seu identificador.
$portugues = $idiomas[1] ?? null;
$espanhol = $idiomas[2] ?? null;
$wari = $idiomas[3] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e a adaptação para diferentes telas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Editar História</title>

    <!-- Carrega os arquivos CSS responsáveis pela aparência da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/editar_historia.css">
</head>

<body>

    <!-- Inclui o menu de navegação do administrador. -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal que contém o conteúdo da página. -->
    <main class="pagina">

        <!-- Apresenta o título e a descrição da página. -->
        <section class="cabecalho-pagina">
            <h1>Editar História</h1>
            <p>Modifique suas histórias.</p>
        </section>

        <!-- Card que reúne os campos utilizados para editar a história. -->
        <section class="modal">

            <!-- Cabeçalho do formulário de edição. -->
            <div class="modal-header">
                <h2>Editar História</h2>
            </div>

            <!-- Formulário responsável por enviar as alterações ao administrador.
                 O método POST envia os dados e o multipart/form-data permite enviar imagens. -->
            <form
                id="formEditarHistoria"
                action="<?= URL ?>/administrador/atualizar_historia"
                method="POST"
                enctype="multipart/form-data">

                <!-- Armazena o identificador da história para saber qual registro será atualizado. -->
                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $historia->id ?>">

                <!-- Exibe a imagem atualmente cadastrada para a história. -->
                <div class="imagem-container">
                    <img
                        id="imagemPreview"
                        class="imagem-preview"
                        src="<?= htmlspecialchars(
                                    $historia->imagem_uri ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                        alt="Imagem atual da história"
                        style="object-fit: cover;">
                </div>

                <!-- Permite escolher o idioma e substituir a imagem da história. -->
                <div class="linha-lingua-imagem">

                    <!-- Lista os idiomas disponíveis para edição. -->
                    <div class="lingua">
                        <select id="lingua" name="lingua">
                            <option value="pt">Português</option>
                            <option value="es">Espanhol</option>
                            <option value="wari">Wari' Oro Nao</option>
                        </select>
                    </div>

                    <!-- Botão que permite selecionar uma nova imagem. -->
                    <button
                        type="button"
                        class="btn-substituir"
                        id="btnSubstituir">
                        Substituir imagem
                    </button>

                    <!-- Campo de seleção de arquivo.
                         Aceita imagens nos formatos JPG, JPEG, PNG e WEBP. -->
                    <input
                        type="file"
                        id="imagem"
                        name="imagem"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        hidden>

                </div>

                <!-- Campos ocultos que armazenam o título, a legenda e o texto em português.
                     Esses valores são utilizados para manter os dados de cada idioma durante a edição. -->

                <!-- Armazena o título em português. -->
                <input
                    type="hidden"
                    id="titulo_pt"
                    name="titulo_pt"
                    value="<?= htmlspecialchars(
                                $portugues->titulo ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Armazena a legenda da imagem em português. -->
                <input
                    type="hidden"
                    id="legenda_pt"
                    name="legenda_pt"
                    value="<?= htmlspecialchars(
                                $portugues->legenda ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Armazena o texto da história em português. -->
                <input
                    type="hidden"
                    id="texto_pt"
                    name="texto_pt"
                    value="<?= htmlspecialchars(
                                $portugues->texto ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Campos ocultos responsáveis por armazenar os dados em espanhol. -->

                <!-- Armazena o título em espanhol. -->
                <input
                    type="hidden"
                    id="titulo_es"
                    name="titulo_es"
                    value="<?= htmlspecialchars(
                                $espanhol->titulo ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Armazena a legenda da imagem em espanhol. -->
                <input
                    type="hidden"
                    id="legenda_es"
                    name="legenda_es"
                    value="<?= htmlspecialchars(
                                $espanhol->legenda ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Armazena o texto da história em espanhol. -->
                <input
                    type="hidden"
                    id="texto_es"
                    name="texto_es"
                    value="<?= htmlspecialchars(
                                $espanhol->texto ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Campos ocultos responsáveis por armazenar os dados em Wari' Oro Nao. -->

                <!-- Armazena o título em Wari' Oro Nao. -->
                <input
                    type="hidden"
                    id="titulo_wari"
                    name="titulo_wari"
                    value="<?= htmlspecialchars(
                                $wari->titulo ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Armazena a legenda da imagem em Wari' Oro Nao. -->
                <input
                    type="hidden"
                    id="legenda_wari"
                    name="legenda_wari"
                    value="<?= htmlspecialchars(
                                $wari->legenda ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Armazena o texto da história em Wari' Oro Nao. -->
                <input
                    type="hidden"
                    id="texto_wari"
                    name="texto_wari"
                    value="<?= htmlspecialchars(
                                $wari->texto ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>">

                <!-- Organiza os campos de categoria e título na mesma linha. -->
                <div class="linha-campos">

                    <!-- Apresenta a categoria à qual a história pertence. -->
                    <div class="campo">
                        <label for="categoria_exibida">
                            Categoria
                        </label>

                        <!-- Mantém o identificador da categoria para enviá-lo ao servidor. -->
                        <input
                            type="hidden"
                            name="categoria"
                            value="<?= (int) $historia->categoria_id ?>">

                        <!-- Exibe o nome da categoria sem permitir alterações. -->
                        <input
                            type="text"
                            id="categoria_exibida"
                            value="<?= htmlspecialchars(
                                        $historia->categoria,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                            readonly>
                    </div>

                    <!-- Campo utilizado para editar o título da história no idioma selecionado. -->
                    <div class="campo">
                        <label id="labelTitulo" for="titulo">
                            Título (Português)
                        </label>

                        <input
                            type="text"
                            id="titulo"
                            placeholder="Título da história..."
                            required>
                    </div>

                </div>

                <!-- Campo utilizado para editar a legenda da imagem. -->
                <div class="campo campo-legenda">

                    <label id="labelLegenda" for="legenda">
                        Legenda da imagem (Português)
                    </label>

                    <input
                        type="text"
                        id="legenda"
                        placeholder="Legenda da imagem..."
                        required>

                </div>

                <!-- Campo utilizado para editar o conteúdo da história. -->
                <div class="campo texto-campo">

                    <label id="labelTexto" for="texto">
                        Texto (Português)
                    </label>

                    <textarea
                        id="texto"
                        placeholder="Texto da história..."
                        required></textarea>

                </div>

                <!-- Reúne os botões para cancelar ou salvar as alterações realizadas. -->
                <div class="botoes">

                    <!-- Retorna à página de gerenciamento de histórias sem enviar o formulário. -->
                    <button
                        type="button"
                        class="btn-cancelar"
                        onclick="window.location.href='<?= URL ?>/administrador/gerenciar_historia_adm'">
                        Cancelar
                    </button>

                    <!-- Envia os dados preenchidos para atualizar a história. -->
                    <button
                        type="submit"
                        class="btn-salvar">
                        Salvar
                    </button>

                </div>

            </form>

        </section>

    </main>

    <!-- Inclui o rodapé padrão do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Carrega o JavaScript responsável pela troca de idiomas,
         preenchimento dos campos e pré-visualização da imagem. -->
    <script src="<?= URL ?>/public/js/editar_historia.js"></script>

    <!-- Carrega as funcionalidades gerais das configurações da página. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>

</body>

</html>
