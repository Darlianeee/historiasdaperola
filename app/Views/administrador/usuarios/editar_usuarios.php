
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página a diferentes tamanhos de tela -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador -->
    <title>Editar Usuários - Histórias na Pérola</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?=URL?>/public/css/editar_usuarios.css">
</head>

<body>

    <!-- Inclui o menu de navegação do administrador -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal do conteúdo da página -->
    <main class="conteudo">

        <!-- Exibe o título da página -->
        <div class="titulo">
            <h1>Editar Usuários</h1>
        </div>

        <!-- Apresenta uma breve descrição da funcionalidade -->
        <p class="descricao">
            Altere o perfil e o status da pessoa cadastrada no sistema.
        </p>

        <!-- Seção que contém o formulário de edição do usuário -->
        <section class="formulario">

            <h2 class="subtitulo-formulario">Usuários</h2>

            <!-- Exibe mensagens de sucesso ou erro armazenadas na sessão -->
            <?php Sessao::exibirFlash(); ?>

            <!-- Formulário enviado pelo método POST para a função de edição de usuários -->
            <form id="formularioPerfil" method="post" action="<?=URL?>/administrador/editar_usuarios">

                <!-- Campo oculto que envia o identificador da pessoa para o processamento -->
                <input type="hidden" name="id" value="<?= (int) $pessoa->pess_id ?>">

                <!-- Campo que apresenta o nome cadastrado, sem permitir alterações -->
                <div class="campo">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" value="<?= Html::e($pessoa->pess_nome) ?>" readonly>
                </div>

                <!-- Campo que apresenta o e-mail cadastrado, sem permitir alterações -->
                <div class="campo">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" value="<?= Html::e($pessoa->emai_nome) ?>" readonly>
                </div>

                <!-- Campo para selecionar o perfil que será atribuído ao usuário -->
                <div class="campo">
                    <label for="perfil">Perfil</label>

                    <select id="perfil" name="perfil" required>

                        <!-- Percorre os perfis disponíveis para preencher as opções do campo -->
                        <?php foreach ($perfis as $perfil): ?>
                            <option value="<?= (int) $perfil->perf_id ?>" <?= (int) $perfil->perf_id === (int) $pessoa->perf_id ? 'selected' : '' ?>>
                                <?= Html::e($perfil->perf_nome) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Campo para selecionar se a conta do usuário está ativa ou inativa -->
                <div class="campo">
                    <label for="status">Status</label>

                    <select id="status" name="status" required>

                        <!-- Apresenta as opções de status e seleciona a que corresponde ao cadastro atual -->
                        <?php foreach (['Ativo', 'Inativo'] as $status): ?>
                            <option value="<?= $status ?>" <?= $pessoa->pess_status === $status ? 'selected' : '' ?>><?= $status ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Área destinada à exibição de mensagens relacionadas ao formulário -->
                <div id="mensagem" class="mensagem" role="status"></div>

                <!-- Agrupa os botões de cancelar e salvar as alterações -->
                <div class="botoes">

                    <!-- Retorna à página de gerenciamento de perfis sem salvar as alterações -->
                    <a href="<?=URL?>/administrador/gerenciar_perfis"
                    class="btn-cancelar">
                        Cancelar
                    </a>

                    <!-- Envia o formulário para salvar as alterações realizadas -->
                    <button type="submit" class="btn-salvar">
                        Salvar
                    </button>

                </div>

            </form>

        </section>

    </main>

    <!-- Inclui o rodapé utilizado nas páginas do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pelas funcionalidades da página -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
