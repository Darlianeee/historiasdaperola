<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Usuários - Histórias na Pérola</title>

    <link rel="stylesheet" href="<?=URL?>/public/css/editar_usuarios.css">
</head>

<body>

    <?php include '../App/Views/administrador/menu_adm.php'; ?>

    <main class="conteudo">

        <div class="titulo">
            <h1>Editar Usuários</h1>
        </div>

        <p class="descricao">
            Altere o perfil e o status da pessoa cadastrada no sistema.
        </p>

        <section class="formulario">

            <h2 class="subtitulo-formulario">Usuários</h2>

            <form id="formularioPerfil">

                <div class="campo">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" value="Ana Silva" readonly>
                </div>

                <div class="campo">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" value="ana@email.com" readonly>
                </div>

                <div class="campo">
                    <label for="perfil">Perfil</label>

                    <select id="perfil" required>
                        <option value="Usuário" selected>Usuário</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="status">Status</label>

                    <select id="status" required>
                        <option value="Ativo" selected>Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>

                <div id="mensagem" class="mensagem" role="status"></div>

                <div class="botoes">

                    <a href="<?=URL?>/administrador/gerenciar_perfis"
                    class="btn-cancelar">
                        Cancelar
                    </a>

                    <button type="submit" class="btn-salvar">
                        Salvar
                    </button>

                </div>

            </form>

        </section>

    </main>

    <?php include '../App/Views/administrador/footer_adm.php'; ?>
    
    <script src="<?=URL?>/public/js/editar_usuarios.js"></script>

</body>

</html>