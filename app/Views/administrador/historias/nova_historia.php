
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página para diferentes tamanhos de tela. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Nova História</title>

    <!-- Carrega os arquivos CSS responsáveis pela aparência da página e pelas configurações gerais. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/nova_historia.css">
</head>

<body>

    <!-- Inclui o menu de navegação utilizado pelo administrador. -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Container que organiza o conteúdo da página de cadastro. -->
    <div class="container">

        <!-- Apresenta o título e a descrição da página. -->
        <div class="titulo-pagina">
            <h1>Nova História</h1>
            <p>Adicione novas histórias.</p>
        </div>

        <!-- Card que reúne os campos necessários para cadastrar uma nova história. -->
        <div class="card">

            <!-- Verifica se existe alguma mensagem temporária na sessão para exibi-la. -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário responsável por enviar os dados da nova história ao servidor.
                 O método POST envia as informações e o multipart/form-data permite o envio de imagens. -->
            <form
                action="<?= URL ?>/administrador/salvar_historia"
                method="POST"
                enctype="multipart/form-data"
                id="formHistoria">

                <!-- Apresenta o título e uma orientação sobre o preenchimento dos campos. -->
                <h2>Adicionar nova história</h2>

                <span>Preencha os campos em cada língua.</span>

                <!-- Área que permite selecionar o idioma em que a história será cadastrada. -->
                <div class="idiomas">

                    <!-- Botão para preencher as informações da história em português.
                         Começa selecionado por ser o idioma inicial do formulário. -->
                    <button type="button" class="ativo" data-idioma="pt">
                        <img src="<?= URL ?>/public/img/brasil.png" alt="Bandeira do Brasil">
                        <span>Português</span>
                    </button>

                    <!-- Botão para alternar os campos e preencher a versão em espanhol. -->
                    <button type="button" data-idioma="es">
                        <img src="<?= URL ?>/public/img/espanha.png" alt="Bandeira da Espanha">
                        <span>Espanhol</span>
                    </button>

                    <!-- Botão para alternar os campos e preencher a versão em Wari' Oro Nao. -->
                    <button type="button" class="idioma-wari" data-idioma="wari">
                        <img src="<?= URL ?>/public/img/icone_logo_menu.png" alt="Logo Wari' Oro Nao">
                        <span>Wari' Oro Nao</span>
                    </button>

                </div>

                <!-- Organiza os campos de categoria e imagem na mesma linha. -->
                <div class="linha">

                    <!-- Campo utilizado para selecionar a categoria da história. -->
                    <div class="campo">
                        <label for="categoria">Categoria</label>

                        <!-- Apresenta as categorias disponíveis para o cadastro.
                             Cada opção possui um identificador enviado ao servidor. -->
                        <select id="categoria" name="categoria" required>
                            <option value="">Selecione uma categoria</option>
                            <option value="1">Mito</option>
                            <option value="2">Lenda</option>
                        </select>
                    </div>

                    <!-- Campo utilizado para selecionar a imagem que acompanhará a história. -->
                    <div class="campo imagem">
                        <label for="imagem">Imagem</label>

                        <!-- Permite selecionar uma imagem nos formatos JPEG, PNG ou WEBP.
                             O preenchimento é obrigatório para concluir o cadastro. -->
                        <input
                            type="file"
                            id="imagem"
                            name="imagem"
                            accept="image/jpeg,image/png,image/webp"
                            required>
                    </div>

                </div>

                <!-- Organiza os campos de título e legenda da imagem na mesma linha. -->
                <div class="linha">

                    <!-- Campo utilizado para informar o título da história no idioma selecionado. -->
                    <div class="campo">
                        <label id="labelTitulo" for="titulo">
                            Título (Português)
                        </label>

                        <!-- Recebe o título da história, permitindo no máximo 100 caracteres. -->
                        <input
                            type="text"
                            id="titulo"
                            placeholder="Digite o título em português..."
                            maxlength="100"
                            required>
                    </div>

                    <!-- Campo utilizado para informar a legenda correspondente à imagem. -->
                    <div class="campo">
                        <label id="labelLegenda" for="legenda">
                            Legenda da imagem (Português)
                        </label>

                        <!-- Recebe a legenda da imagem, permitindo no máximo 100 caracteres. -->
                        <input
                            type="text"
                            id="legenda"
                            placeholder="Digite a legenda da imagem em português..."
                            maxlength="100"
                            required>
                    </div>

                </div>

                <!-- Campo utilizado para inserir o conteúdo completo da história no idioma selecionado. -->
                <div class="campo">
                    <label id="labelTexto" for="texto">
                        Texto (Português)
                    </label>

                    <textarea
                        id="texto"
                        placeholder="Digite o texto em português..."
                        required></textarea>
                </div>

                <!-- Campos ocultos que armazenam o título, a legenda e o texto em português.
                     Esses campos recebem os valores preenchidos para serem enviados ao servidor. -->
                <input type="hidden" name="titulo_pt" id="titulo_pt">
                <input type="hidden" name="legenda_pt" id="legenda_pt">
                <input type="hidden" name="texto_pt" id="texto_pt">

                <!-- Campos ocultos que armazenam os dados da história em espanhol. -->
                <input type="hidden" name="titulo_es" id="titulo_es">
                <input type="hidden" name="legenda_es" id="legenda_es">
                <input type="hidden" name="texto_es" id="texto_es">

                <!-- Campos ocultos que armazenam os dados da história em Wari' Oro Nao. -->
                <input type="hidden" name="titulo_wari" id="titulo_wari">
                <input type="hidden" name="legenda_wari" id="legenda_wari">
                <input type="hidden" name="texto_wari" id="texto_wari">

                <!-- Área que reúne os botões para cancelar ou concluir o cadastro da história. -->
                <div class="acoes">

                    <!-- Cancela a operação e retorna à página de gerenciamento de histórias. -->
                    <button
                        type="button"
                        class="cancelar"
                        onclick="window.location.href='<?= URL ?>/administrador/gerenciar_historia_adm'">
                        Cancelar
                    </button>

                    <!-- Envia os dados preenchidos para o servidor realizar o cadastro da história. -->
                    <button type="submit" class="salvar">
                        Salvar história
                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- Inclui o rodapé padrão do sistema. -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Carrega o JavaScript responsável pela troca de idiomas e pelo preenchimento
         dos campos ocultos antes do envio do formulário. -->
    <script src="<?= URL ?>/public/js/novas_historias.js" defer></script>

    <!-- Carrega as funcionalidades gerais das configurações da página. -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
