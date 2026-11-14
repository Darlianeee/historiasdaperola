<?php
// Identifica o tipo de sessão atual para definir os links que serão exibidos no rodapé.
$administrador = Sessao::estaLogado() && Sessao::ehAdministrador();
$usuarioLogado = Sessao::estaLogado() && !$administrador;

// Define os links de navegação de acordo com o perfil identificado.
if ($administrador) {
    // Links disponíveis para o administrador.
    $linkInicio = 'administrador/inicio_adm';
    $linkSobre = 'paginas/sobre_nos';
    $linkPerfis = 'administrador/gerenciar_perfis';
} elseif ($usuarioLogado) {
    // Links disponíveis para o usuário que está logado.
    $linkInicio = 'usuarios/inicio_user';
    $linkSobre = 'paginas/sobre_nos';
    $linkPerfis = 'usuarios/perfil_user';
} else {
    // Links exibidos para quem ainda não está logado no sistema.
    $linkInicio = 'paginas/index';
    $linkSobre = 'paginas/sobre_nos';
    $linkPerfis = 'paginas/login';
}
?>

<!-- Rodapé compartilhado entre as páginas do sistema. -->
<footer class="footer">

    <!-- Área que reúne os links de navegação do rodapé. -->
    <div class="footer-links">
        <ul>
            <!-- Link para a página inicial correspondente ao perfil atual. -->
            <li><a href="<?= URL ?>/<?= $linkInicio ?>">Início</a></li>

            <!-- Link para a página de apresentação do projeto. -->
            <li><a href="<?= URL ?>/<?= $linkSobre ?>">Sobre Nós</a></li>

            <!-- Link para acessar as configurações de acessibilidade. -->
            <li><a href="<?= URL ?>/paginas/configuracoes">Configurações</a></li>

            <!-- Exibe a opção de gerenciamento de perfis somente para o administrador. -->
            <?php if ($administrador): ?>
                <li><a href="<?= URL ?>/<?= $linkPerfis ?>">Gerenciar perfis</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Área central que apresenta a logo do IFRO. -->
    <div class="footer-center">
        <img src="<?= URL ?>/public/img/footer_logo.png" alt="Logo IFRO" class="footer-logo">
    </div>

    <!-- Área que apresenta as informações de contato. -->
    <div class="footer-contact">
        <p>Contatos:</p>
        <p>Telefone: (99) 99999-9999</p>
        <p>E-mail: algumacoisa@ifro.edu.br</p>
    </div>
</footer>