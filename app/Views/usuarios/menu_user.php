<!-- Importa o arquivo CSS responsável pela aparência do menu do usuário. -->
<link rel="stylesheet" href="<?= URL ?>/public/css/menu_user.css">

<!-- Cabeçalho que contém o logotipo e o menu de navegação. -->
<header class="header">

    <!-- Botão utilizado para abrir e fechar o menu em telas menores. -->
    <button class="menu-toggle" id="menuToggle" type="button" aria-label="Abrir menu">
        <!-- Linhas que formam o ícone do menu. -->
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Área que apresenta o logotipo e o nome do projeto. -->
    <div class="logo">
        <img src="<?= URL ?>/public/img/icone_logo_menu.png" alt="Logo">
        <p>HISTÓRIAS NA PÉROLA</p>
    </div>

    <!-- Área que reúne os links de navegação do usuário. -->
    <nav id="mainNav">
        <ul class="menu">

            <!-- Link que direciona o usuário para a página inicial. -->
            <li>
                <a href="<?= URL ?>/usuarios/inicio_user" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_inicio.png" alt="Início" class="menu-icon inicio-icon">
                    <span>Início</span>
                </a>
            </li>

            <!-- Link que direciona o usuário para a página do perfil. -->
            <li>
                <a href="<?= URL ?>/usuarios/perfil_user" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_perfil.png" alt="Perfil" class="menu-icon perfil-icon">
                    <span>Perfil</span>
                </a>
            </li>

            <!-- Link que direciona o usuário para o catálogo de histórias. -->
            <li>
                <a href="<?= URL ?>/usuarios/escolher_historia_user" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_historias.png" alt="Histórias" class="menu-icon histórias-icon">
                    <span>Histórias</span>
                </a>
            </li>

            <!-- Link que direciona o usuário para a página de notificações. -->
            <li>
                <a href="<?= URL ?>/usuarios/notificacoes_user" class="menu-link">

                    <!-- Área que reúne o ícone e o contador de notificações não lidas. -->
                    <span class="notificacoes-icone-container">

                        <img
                            src="<?= URL ?>/public/img/icone_notificacoes.png"
                            alt="Notificações"
                            class="menu-icon notificações-icon">

                        <!-- Verifica se existe alguma notificação não lida para exibir o contador. -->
                        <?php if (isset($quantidadeNotificacoesNaoLidas) && $quantidadeNotificacoesNaoLidas > 0): ?>

                            <span class="contador-notificacoes">
                                <!-- Exibe a quantidade de notificações não lidas, limitando a contagem visual a 99+. -->
                                <?= $quantidadeNotificacoesNaoLidas > 99 ? '99+' : (int) $quantidadeNotificacoesNaoLidas ?>
                            </span>

                        <?php endif; ?>
                    </span>

                    <span>Notificações</span>
                </a>
            </li>

            <!-- Link que direciona o usuário para a página Sobre Nós. -->
            <li>
                <a href="<?= URL ?>/usuarios/sobre_nos_user" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_sobreNos.png"
                        alt="Sobre nós"
                        class="menu-icon sobre-nós-icon">
                    <span>Sobre Nós</span>
                </a>
            </li>

            <!-- Link que direciona o usuário para as configurações do sistema. -->
            <li>
                <a href="<?= URL ?>/paginas/configuracoes" class="menu-link">
                    <img src="<?= URL ?>/public/img/configuracao_icone.png" alt="Configurações" class="menu-icon configuracao-icon">
                    <span>Configurações</span>
                </a>
            </li>

            <!-- Link que direciona o usuário para a página de saída da conta. -->
            <li>
                <a href="<?= URL ?>/paginas/sair" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_sair.png" alt="Sair" class="menu-icon sair-icon">
                    <span>Sair</span>
                </a>
            </li>

        </ul>
    </nav>

    <!-- Importa o JavaScript responsável pelo funcionamento do menu, incluindo sua abertura e fechamento. -->
    <script src="<?= URL ?>/public/js/menu.js"></script>
</header>