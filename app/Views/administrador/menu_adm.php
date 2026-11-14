
<!-- Importa o arquivo CSS responsável pela aparência do menu do administrador -->
<link rel="stylesheet" href="<?= URL ?>/public/css/menu_adm.css">

<!-- Cabeçalho que contém o logotipo e o menu de navegação -->
<header class="header">

    <!-- Botão utilizado para abrir e fechar o menu de navegação -->
    <button class="menu-toggle" id="menuToggle" type="button" aria-label="Abrir menu">
        <!-- Linhas que formam o ícone do menu -->
        <span></span>
        <span></span>
        <span></span>
    </button>

    <!-- Área que apresenta o logotipo e o nome do sistema -->
    <div class="logo">
        <img src="<?= URL ?>/public/img/icone_logo_menu.png" alt="Logo">
        <p>HISTÓRIAS NA PÉROLA</p>
    </div>

    <!-- Área de navegação que reúne as opções disponíveis para o administrador -->
    <nav id="mainNav">
        <ul class="menu">

            <!-- Link que direciona para a página inicial do administrador -->
            <li>
                <a href="<?= URL ?>/administrador/inicio_adm" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_inicio.png"
                        alt="Início"
                        class="menu-icon inicio-icon">
                    <span>Início</span>
                </a>
            </li>

            <!-- Link que direciona para a página de perfil do administrador -->
            <li>
                <a href="<?= URL ?>/administrador/perfil_adm" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_perfil.png"
                        alt="Perfil"
                        class="menu-icon perfil-icon">
                    <span>Perfil</span>
                </a>
            </li>

            <!-- Link que direciona para o gerenciamento das histórias -->
            <li>
                <a href="<?= URL ?>/administrador/gerenciar_historia_adm" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_historias.png"
                        alt="Histórias"
                        class="menu-icon histórias-icon">
                    <span>Histórias</span>
                </a>
            </li>

            <!-- Link que direciona para a página de notificações -->
            <li>
                <a href="<?= URL ?>/administrador/notificacoes_adm" class="menu-link">

                    <!-- Agrupa o ícone de notificações e o contador de mensagens não lidas -->
                    <span class="notificacoes-icone-container">
                        <img
                            src="<?= URL ?>/public/img/icone_notificacoes.png"
                            alt="Notificações"
                            class="menu-icon notificações-icon">

                        <!-- Verifica se existe uma quantidade de notificações não lidas maior que zero -->
                        <?php if (isset($quantidadeNotificacoesNaoLidas) && $quantidadeNotificacoesNaoLidas > 0): ?>

                            <!-- Exibe a quantidade de notificações não lidas, limitando a indicação a 99+ -->
                            <span class="contador-notificacoes">
                                <?= $quantidadeNotificacoesNaoLidas > 99 ? '99+' : (int) $quantidadeNotificacoesNaoLidas ?>
                            </span>

                        <?php endif; ?>
                    </span>

                    <span>Notificações</span>
                </a>
            </li>

            <!-- Link que direciona para o gerenciamento dos perfis cadastrados -->
            <li>
                <a href="<?= URL ?>/administrador/gerenciar_perfis" class="menu-link">
                    <img src="<?= URL ?>/public/img/perfis_icone.png"
                        alt="Perfis"
                        class="menu-icon perfis-icon">
                    <span>Gerenciar Perfis</span>
                </a>
            </li>

            <!-- Link que direciona para a página com informações sobre o projeto -->
            <li>
                <a href="<?= URL ?>/administrador/sobre_nos_adm" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_sobreNos.png"
                        alt="Sobre nós"
                        class="menu-icon sobre-nós-icon">
                    <span>Sobre Nós</span>
                </a>
            </li>

            <!-- Link que direciona para as configurações do sistema -->
            <li>
                <a href="<?= URL ?>/paginas/configuracoes" class="menu-link">
                    <img src="<?= URL ?>/public/img/configuracao_icone.png" alt="Configurações" class="menu-icon configuracao-icon">
                    <span>Configurações</span>
                </a>
            </li>

            <!-- Link utilizado para sair da conta do administrador -->
            <li>
                <a href="<?= URL ?>/paginas/sair" class="menu-link">
                    <img src="<?= URL ?>/public/img/icone_sair.png"
                        alt="Sair"
                        class="menu-icon sair-icon">
                    <span>Sair</span>
                </a>
            </li>

        </ul>
    </nav>

    <!-- Importa o JavaScript responsável pelo funcionamento do menu de navegação -->
    <script src="<?= URL ?>/public/js/menu.js"></script>

</header>
