<link rel="stylesheet" href="<?=URL?>/public/css/menu_adm.css">

<header class="header">

    <button class="menu-toggle" id="menuToggle" type="button" aria-label="Abrir menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="logo">
        <img src="<?=URL?>/public/img/icone_logo_menu.png" alt="Logo">
        <p>HISTÓRIAS NA PERÓLA</p>
    </div>

    <nav id="mainNav">
        <ul class="menu">

            <li>
                <a href="<?=URL?>/administrador/inicio_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/icone_inicio.png"
                         alt="Início"
                         class="menu-icon inicio-icon">
                    <span>Início</span>
                </a>
            </li>

            <li>
                <a href="<?=URL?>/administrador/perfil_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/icone_perfil.png"
                         alt="Perfil"
                         class="menu-icon perfil-icon">
                    <span>Perfil</span>
                </a>
            </li>

            <!-- HISTÓRIAS -->
            <li>
                <a href="<?=URL?>/administrador/gerenciar_historia_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/icone_historias.png"
                         alt="Histórias"
                         class="menu-icon histórias-icon">
                    <span>Histórias</span>
                </a>
            </li>

            <!-- COMENTÁRIOS -->
            <li>
                <a href="<?=URL?>/administrador/comentarios_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/icone_comentarios.png"
                         alt="Comentários"
                         class="menu-icon comentarios-icon">
                    <span>Comentários</span>
                </a>
            </li>

            <!-- NOTIFICAÇÕES -->
            <li>
                <a href="<?=URL?>/administrador/notificacoes_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/icone_notificacoes.png"
                         alt="Notificações"
                         class="menu-icon notificações-icon">
                    <span>Notificações</span>
                </a>
            </li>

            <!-- SOBRE NÓS -->
            <li>
                <a href="<?=URL?>/administrador/sobre_nos_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/icone_sobreNos.png"
                         alt="Sobre nós"
                         class="menu-icon sobre-nós-icon">
                    <span>Sobre Nós</span>
                </a>
            </li>

            <li>
                <a href="<?=URL?>/administrador/sair_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/configuracao_icone.png"
                         alt="Sair"
                         class="menu-icon configuracao-icon">
                    <span>Configurações</span>
                </a>
            </li>

            <!-- SAIR -->
            <li>
                <a href="<?=URL?>/administrador/sair_adm" class="menu-link">
                    <img src="<?=URL?>/public/img/icone_sair.png"
                         alt="Sair"
                         class="menu-icon sair-icon">
                    <span>Sair</span>
                </a>
            </li>

        </ul>
    </nav>

    <script src="<?=URL?>/public/js/menu.js"></script>

</header>