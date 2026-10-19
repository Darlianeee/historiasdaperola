<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gerenciar Perfis - Histórias na Pérola</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/gerenciar_perfis.css">
</head>

<body>

    <?php include '../App/Views/administrador/menu_adm.php'; ?>

    <main class="conteudo">

        <div class="titulo">
            <h1>Gerenciar Perfis</h1>
        </div>

        <p class="descricao">
            Consulte e gerencie os perfis cadastrados no sistema.
        </p>

        <div id="mensagem" class="mensagem" role="status"></div>

        <section class="area-tabela">

            <div class="cabecalho-tabela">
                <h2>Perfis cadastrados</h2>
            </div>

            <div class="tabela-responsiva">

                <table>

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody id="listaPessoas">

                        <tr>
                            <td data-label="Nome">Nome do usuário</td>

                            <td data-label="E-mail">
                                usuario@email.com
                            </td>

                            <td data-label="Perfil">
                                <span class="perfil usuario">
                                    Usuário
                                </span>
                            </td>

                            <td data-label="Situação">
                                <span class="situacao inativo">
                                    Inativo
                                </span>
                            </td>

                            <td data-label="Ações">
                                <div class="acoes">

                                    <a href="<?=URL?>/administrador/editar_usuarios"
                                       class="btn-editar">
                                        Editar
                                    </a>

                                    <button
                                        type="button"
                                        class="btn-excluir"
                                        onclick="abrirModal(this, 'Nome do usuário')">
                                        Excluir
                                    </button>

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td data-label="Nome">Nome do administrador</td>

                            <td data-label="E-mail">
                                administrador@email.com
                            </td>

                            <td data-label="Perfil">
                                <span class="perfil administrador">
                                    Administrador
                                </span>
                            </td>

                            <td data-label="Situação">
                                <span class="situacao ativo">
                                    Ativo
                                </span>
                            </td>

                            <td data-label="Ações">
                                <div class="acoes">

                                    <a href="<?=URL?>/administrador/editar_usuarios"
                                       class="btn-editar">
                                        Editar
                                    </a>

                                    <button
                                        type="button"
                                        class="btn-excluir"
                                        onclick="abrirModal(this, 'Nome do administrador')">
                                        Excluir
                                    </button>

                                </div>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

    <div id="modalExcluir" class="modal-excluir" role="dialog" aria-modal="true" aria-labelledby="tituloExcluir">

        <div class="caixa-excluir">

            <span class="icone-alerta">!</span>

            <h2 id="tituloExcluir">Excluir usuário?</h2>

            <p>
                Tem certeza de que deseja excluir
                <strong id="nomeUsuarioExcluir"></strong>?
                Essa ação não poderá ser desfeita.
            </p>

            <div class="botoes-excluir">

                <button type="button" class="btn-cancelar" onclick="fecharModal()">
                    Cancelar
                </button>

                <button type="button" class="btn-confirmar-exclusao" onclick="confirmarExclusao()">
                    Excluir
                </button>

            </div>

        </div>

    </div>

    <div id="mensagemExclusao" class="mensagem-exclusao" role="status"></div>

    <?php include '../App/Views/administrador/footer_adm.php'; ?>

    <script src="<?=URL?>/public/js/gerenciar_perfis.js"></script>

</body>

</html>