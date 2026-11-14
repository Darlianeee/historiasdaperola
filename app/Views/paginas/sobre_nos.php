
<?php
// Verifica o perfil conectado e exibe o menu correspondente.
if (Sessao::estaLogado() && Sessao::ehAdministrador()) {
    // Exibe o menu do administrador.
    include APP . '/Views/administrador/menu_adm.php';
} elseif (Sessao::estaLogado()) {
    // Exibe o menu do usuário.
    include APP . '/Views/usuarios/menu_user.php';
} else {
    // Exibe o cabeçalho público para visitantes que não estão logados.
    include APP . '/Views/paginas/cabecalho_publico.php';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres e a adaptação da página para diferentes telas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Define o título exibido na aba do navegador. -->
    <title>Sobre Nós</title>

    <!-- Importa os arquivos CSS responsáveis pelas configurações e pela aparência da página. -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/Configuracoes.css">
    <link rel="stylesheet" href="<?=URL?>/public/css/sobre_nos.css">
</head>

<body>

<!-- Área principal que reúne as informações sobre o projeto e sua equipe. -->
<main class="conteudo">

    <!-- Cabeçalho com o título e a apresentação da página. -->
    <section class="cabecalho-pagina">

        <h1>Sobre Nós</h1>

        <p>
            Conheça nossa equipe e a história por trás do projeto.
        </p>

    </section>

    <!-- Seção que apresenta os motivos que levaram ao desenvolvimento do sistema. -->
    <section class="motivo">

        <h2>Motivo para o desenvolvimento do sistema</h2>

        <!-- Apresenta a importância da preservação do patrimônio cultural da região. -->
        <p>
            O desenvolvimento deste site surgiu da necessidade de preservar,
            valorizar e divulgar o patrimônio cultural imaterial da região
            de Guajará-Mirim, em Rondônia (RO). A região é marcada por uma
            expressiva diversidade étnica e cultural, resultado da intensa
            interação social característica de uma região de fronteira.
        </p>

        <!-- Explica a proposta do projeto e as línguas disponíveis no acervo. -->
        <p>
            Nosso projeto busca contribuir para a valorização dessas histórias,
            memórias e manifestações culturais, tornando esse conhecimento
            mais acessível à comunidade. O acervo reúne narrativas disponíveis
            em diferentes línguas, incluindo português brasileiro, espanhol
            latino (Bolívia) e Wari' Oro Nao.
        </p>

    </section>

    <!-- Seção responsável por apresentar os integrantes da equipe e suas funções. -->
    <section class="secao-equipe">

        <!-- Título e descrição da seção da equipe. -->
        <div class="titulo-equipe">

            <h2>Nossa equipe</h2>

            <p>
                Conheça as pessoas que participaram do desenvolvimento deste projeto.
            </p>

        </div>

        <!-- Área que organiza os cartões com as informações dos integrantes. -->
        <div class="equipe">

            <!-- Cartão com a foto, o nome e a função da primeira integrante. -->
            <div class="integrante">

                <!-- Área destinada à fotografia da integrante. -->
                <div class="foto-integrante">

                    <img
                        src="<?=URL?>/public/img/darli.png"
                        alt="Darliane Arza de Oliveira é uma menina de 18 anos, tem a pele morena clara, cabelo preto e ondulado, repartido ao meio. Seus olhos também são escuros, assim como suas sobrancelhas, que são finas e retas.">

                </div>

                <!-- Área que apresenta o nome e as responsabilidades da integrante. -->
                <div class="informacoes-integrante">

                    <h3>
                        Darliane Arza
                        <br>
                        de Oliveira
                    </h3>

                    <p class="funcao">
                        Desing e Desenvolvedora Front-end, Banco de dados e Back-end
                    </p>

                </div>

            </div>

            <!-- Cartão com a foto, o nome e a função do segundo integrante. -->
            <div class="integrante">

                <!-- Área destinada à fotografia do integrante. -->
                <div class="foto-integrante">

                    <img
                        src="<?=URL?>/public/img/jose.png"
                        alt="Jose Javiar Paz é um menino de 17 anos, pele negra, cabelo castanho escuro e liso, cortado baixo. Suas sobrancelhas são escuras, semiarredondadas e grossas, já seus olhos são de um castanho bem profundo.">

                </div>

                <!-- Área que apresenta o nome e as responsabilidades do integrante. -->
                <div class="informacoes-integrante">

                    <h3>
                        Jose Javiar
                        <br>
                        Paz Vaca
                    </h3>

                    <p class="funcao">
                        Desenvolvedor Front-end e Back-end
                    </p>

                </div>

            </div>

            <!-- Cartão com a foto, o nome e a função da terceira integrante. -->
            <div class="integrante">

                <!-- Área destinada à fotografia da integrante. -->
                <div class="foto-integrante">

                    <img
                        src="<?=URL?>/public/img/kal.png"
                        alt="Kalondra Avaroma Vieira é uma menina de 17 anos, tem a pele branca, o cabelo castanho com mechas loiras, levemente ondulado e repartido ao meio com uma franja lateral. Suas sobrancelhas são castanhas e arredondadas e seus olhos são castanhos.">
                </div>

                <!-- Área que apresenta o nome e as responsabilidades da integrante. -->
                <div class="informacoes-integrante">

                    <h3>
                        Kalondra
                        <br>
                        Avaroma Vieira
                    </h3>

                    <p class="funcao">
                        Documentação e Desenvolvedora Front-end
                    </p>

                </div>

            </div>

            <!-- Cartão com a foto, o nome e a função da quarta integrante. -->
            <div class="integrante">

                <!-- Área destinada à fotografia da integrante. -->
                <div class="foto-integrante">

                    <img
                        src="<?=URL?>/public/img/lais.png"
                        alt="Laís Carvalho de Lima é uma menina de 17 anos, de pele branca, cabelo longo e cachos escuros, preso em um penteado meio solto. Suas sobrancelhas são retas com a ponta curvada e seus olhos alongados.">

                </div>

                <!-- Área que apresenta o nome e as responsabilidades da integrante. -->
                <div class="informacoes-integrante">

                    <h3>
                        Laís Carvalho
                        <br>
                        de Lima
                    </h3>

                    <p class="funcao">
                        Desenvolvedora Front-end e Acessibilidade
                    </p>

                </div>

            </div>

            <!-- Cartão com a foto, o nome e a função do quinto integrante. -->
            <div class="integrante">

                <!-- Área destinada à fotografia do integrante. -->
                <div class="foto-integrante">

                    <img
                        src="<?=URL?>/public/img/levi.png"
                        alt="Levi dos Santos Oliveira é um menino de 17 anos de pele clara, cabelo cacheado escuro e volumoso. Seus olhos são castanho escuro e usa óculos retangulares. Suas sobrancelhas são finas e escuras.">

                </div>

                <!-- Área que apresenta o nome e as responsabilidades do integrante. -->
                <div class="informacoes-integrante">

                    <h3>
                        Levi dos Santos
                        <br>
                        de Oliveira
                    </h3>

                    <p class="funcao">
                        Desenvolvedor Front-end e Back-end
                    </p>

                </div>

            </div>

            <!-- Cartão com a foto, o nome e a função da sexta integrante. -->
            <div class="integrante">

                <!-- Área destinada à fotografia da integrante. -->
                <div class="foto-integrante">

                    <img
                        src="<?=URL?>/public/img/quelly.png"
                        alt="Raquelly Tuye Hortiz é uma menina de 17 anos, é parda, tem o cabelo preto com mechas frontais vermelhas e olhos castanhos cor de mel. Suas sobrancelhas são retas e castanhas.">

                </div>

                <!-- Área que apresenta o nome e as responsabilidades da integrante. -->
                <div class="informacoes-integrante">

                    <h3>
                        Raquelly Tuye
                        <br>
                        Hortiz
                    </h3>

                    <p class="funcao">
                        Desenvolvedora Front-end e Acessibilidade
                    </p>

                </div>

            </div>

        </div>

    </section>

</main>

<!-- Inclui o rodapé compartilhado entre as páginas do sistema. -->
<?php include APP . '/Views/paginas/footer.php'; ?>

<!-- Importa o JavaScript responsável pelas funcionalidades das configurações de acessibilidade. -->
<script src="<?= URL ?>/public/js/Configuracoes.js"></script>

</body>
</html>
