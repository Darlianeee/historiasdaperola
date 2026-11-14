
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e adapta a página a diferentes tamanhos de tela -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador -->
    <title>Gerenciar Perfis - Histórias na Pérola</title>

    <!-- Importa os arquivos CSS responsáveis pela aparência da página -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?= URL ?>/public/css/gerenciar_perfis.css">
</head>

<body>

    <!-- Inclui o menu de navegação do administrador -->
    <?php include APP . '/Views/administrador/menu_adm.php'; ?>

    <!-- Área principal do conteúdo da página -->
    <main class="conteudo">

        <!-- Exibe o título da página -->
        <div class="titulo">
            <h1>Gerenciar Perfis</h1>
        </div>

        <!-- Apresenta uma breve descrição da funcionalidade -->
        <p class="descricao">
            Consulte e gerencie os perfis cadastrados no sistema.
        </p>

        <!-- Exibe mensagens de sucesso ou erro armazenadas na sessão -->
        <?php Sessao::exibirFlash(); ?>

        <!-- Área destinada à exibição de mensagens da página -->
        <div id="mensagem" class="mensagem" role="status"></div>

        <!-- Seção que reúne a pesquisa e a tabela de usuários cadastrados -->
        <section class="area-tabela">

            <!-- Cabeçalho da tabela -->
            <div class="cabecalho-tabela">
                <h2>Perfis cadastrados</h2>
            </div>

            <!-- Campo utilizado para pesquisar pessoas cadastradas -->
            <div class="area-pesquisa">
                <div class="campo-pesquisa">

                    <!-- Permite pesquisar usuários pelo nome, e-mail ou perfil -->
                    <input type="search" id="pesquisarPessoa" placeholder="Pesquisar por nome, e-mail ou perfil..."
                        autocomplete="off" aria-label="Pesquisar usuários">

                    <!-- Ícone que representa a função de pesquisa -->
                    <span class="icone-pesquisa">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>

            <!-- Área que permite adaptar a tabela a diferentes tamanhos de tela -->
            <div class="tabela-responsiva">

                <!-- Tabela que apresenta os dados das pessoas cadastradas -->
                <table>

                    <!-- Cabeçalho com os nomes das colunas -->
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <!-- Corpo da tabela onde os usuários são apresentados -->
                    <tbody id="listaPessoas">

                        <!-- Verifica se existem pessoas cadastradas no sistema -->
                        <?php if (empty($pessoas)): ?>
                            <tr>
                                <!-- Exibe uma mensagem caso a lista esteja vazia -->
                                <td colspan="5">Nenhuma pessoa cadastrada.</td>
                            </tr>
                        <?php endif; ?>

                        <!-- Percorre a lista de pessoas para apresentar seus dados na tabela -->
                        <?php foreach ($pessoas as $p): ?>

                            <?php
                            // Verifica se a pessoa possui o perfil de administrador
                            $ehAdmin = (int) $p->perf_id === Pessoa::PERFIL_ADMINISTRADOR;

                            // Verifica se a situação da conta está ativa
                            $ativo = $p->pess_status === 'Ativo';

                            // Verifica se a pessoa exibida é o próprio administrador logado
                            $ehVoce = (int) $p->pess_id === Sessao::id();
                            ?>

                            <tr>

                                <!-- Exibe o nome da pessoa e identifica quando é o próprio administrador -->
                                <td data-label="Nome">
                                    <?= Html::e($p->pess_nome) ?>    <?= $ehVoce ? ' (você)' : '' ?>
                                </td>

                                <!-- Exibe o e-mail cadastrado -->
                                <td data-label="E-mail">
                                    <?= Html::e($p->emai_nome ?? '—') ?>
                                </td>

                                <!-- Exibe o perfil da pessoa com uma classe correspondente ao tipo de perfil -->
                                <td data-label="Perfil">
                                    <span class="perfil <?= $ehAdmin ? 'administrador' : 'usuario' ?>">
                                        <?= Html::e($p->perf_nome) ?>
                                    </span>
                                </td>

                                <!-- Exibe a situação da conta, indicando se está ativa ou inativa -->
                                <td data-label="Situação">
                                    <span class="situacao <?= $ativo ? 'ativo' : 'inativo' ?>">
                                        <?= Html::e($p->pess_status) ?>
                                    </span>
                                </td>

                                <!-- Apresenta as opções disponíveis para cada pessoa cadastrada -->
                                <td data-label="Ações">
                                    <div class="acoes">

                                        <!-- Direciona para a página de edição dos dados da pessoa selecionada -->
                                        <a href="<?= URL ?>/administrador/editar_usuarios?id=<?= (int) $p->pess_id ?>"
                                            class="btn-editar">
                                            Editar
                                        </a>

                                        <!-- Impede que o administrador exclua a própria conta -->
                                        <?php if (!$ehVoce): ?>

                                            <!-- Abre a janela de confirmação e envia os dados da pessoa selecionada -->
                                            <button type="button" class="btn-excluir" data-id="<?= (int) $p->pess_id ?>"
                                                data-nome="<?= Html::e($p->pess_nome) ?>"
                                                onclick="abrirModal(this, this.dataset.nome)">
                                                Excluir
                                            </button>

                                        <?php endif; ?>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

    <!-- Janela de confirmação exibida antes de excluir uma pessoa -->
    <div id="modalExcluir" class="modal-excluir" role="dialog" aria-modal="true" aria-labelledby="tituloExcluir">

        <!-- Caixa que reúne as informações e os botões da confirmação -->
        <div class="caixa-excluir">

            <!-- Ícone de alerta para chamar a atenção do administrador -->
            <span class="icone-alerta">!</span>

            <!-- Título da janela de confirmação -->
            <h2 id="tituloExcluir">Excluir usuário?</h2>

            <!-- Apresenta o nome da pessoa que será excluída -->
            <p>
                Tem certeza de que deseja excluir
                <strong id="nomeUsuarioExcluir"></strong>?
                Essa ação não poderá ser desfeita.
            </p>

            <!-- Informa quais outros registros relacionados à pessoa também serão excluídos -->
            <p>Comentários, avaliações e notificações dessa pessoa também serão apagados.</p>

            <!-- Formulário enviado pelo método POST para realizar a exclusão da pessoa -->
            <form class="botoes-excluir" id="formExcluirPessoa" method="post"
                action="<?= URL ?>/administrador/excluir_pessoa">

                <!-- Campo oculto que recebe o identificador da pessoa que será excluída -->
                <input type="hidden" name="id" id="idPessoaExcluir" value="">

                <!-- Fecha a janela sem realizar a exclusão -->
                <button type="button" class="btn-cancelar" onclick="fecharModal()">
                    Cancelar
                </button>

                <!-- Confirma e envia o formulário para excluir a pessoa -->
                <button type="submit" class="btn-confirmar-exclusao">
                    Excluir
                </button>

            </form>

        </div>

    </div>

    <!-- Área destinada à exibição de mensagens relacionadas à exclusão -->
    <div id="mensagemExclusao" class="mensagem-exclusao" role="status"></div>

    <!-- Inclui o rodapé utilizado nas páginas do sistema -->
    <?php include APP . '/Views/paginas/footer.php'; ?>

    <!-- Importa o JavaScript responsável pela pesquisa e pelo gerenciamento dos perfis -->
    <script src="<?= URL ?>/public/js/gerenciar_perfis.js"></script>

    <!-- Importa o JavaScript responsável pelas funcionalidades gerais de configuração -->
    <script src="<?= URL ?>/public/js/Configuracoes.js"></script>
</body>

</html>
