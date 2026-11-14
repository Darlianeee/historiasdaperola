<?php
// Métodos comuns aos controllers, incluindo as verificações de acesso.

class Controller
{
    // Carrega o model informado para acessar suas funções e dados.
    public function model($model)
    {
        // Inclui o arquivo do model e cria um objeto para utilizá-lo.
        require_once APP . '/Models/' . $model . '.php';
        return new $model;
    }

    // Carrega uma página e envia os dados necessários para ela.
    public function view($view, $dados = [])
    {
        // Monta o caminho do arquivo da página que será aberta.
        $arquivo = APP . '/Views/' . $view . '.php';

        // Verifica se o arquivo da página existe.
        if (file_exists($arquivo)) {

            // Verifica se existe uma pessoa logada com perfil de administrador ou usuário.
            if (
                Sessao::estaLogado()
                && in_array(
                    $_SESSION['usuario_perfil'] ?? '',
                    ['Administrador', 'Usuário'],
                    true
                )
            ) {
                // Carrega o model responsável pelas notificações.
                $notificacaoModel = $this->model('Notificacao');

                // Conta quantas notificações ainda não foram lidas pela pessoa.
                $dados['quantidadeNotificacoesNaoLidas'] =
                    $notificacaoModel->contarNaoLidas(Sessao::id());
            }

            // Disponibiliza os dados enviados para serem utilizados na página.
            extract($dados);

            // Abre o arquivo da página.
            require_once $arquivo;
        } else {
            // Exibe uma mensagem caso a página solicitada não seja encontrada.
            die("O arquivo não existe: " . $view);
        }
    }

    // Verifica se a pessoa está logada e se a conta continua ativa.
    protected function exigirLogin($paginaLogin = 'usuarios/login_user')
    {
        // Se não houver uma pessoa logada, retorna para a página de login.
        if (!Sessao::estaLogado()) {
            Sessao::flash('Faça login para continuar.', 'erro');
            Url::redirecionar($paginaLogin);
            return;
        }

        // Busca no banco de dados os dados da pessoa que está logada.
        $pessoa = $this->model('Pessoa')->buscarPorId(Sessao::id());

        // Encerra a sessão se a conta não existir mais ou estiver inativa.
        if (!$pessoa || $pessoa->pess_status !== 'Ativo') {
            Sessao::sair();
            Sessao::flash('Sua conta está inativa ou não existe mais. Faça login novamente.', 'erro');
            Url::redirecionar($paginaLogin);
            return;
        }

        // Atualiza os dados da sessão sem gerar outro identificador.
        $_SESSION['usuario_nome'] = $pessoa->pess_nome;
        $_SESSION['usuario_email'] = $pessoa->emai_nome;
        $_SESSION['usuario_perfil'] = $pessoa->perf_nome;
    }

    // Verifica se a pessoa está logada, ativa e possui perfil de administrador.
    protected function exigirAdministrador()
    {
        // Se não houver uma pessoa logada, direciona para o login do administrador.
        if (!Sessao::estaLogado()) {
            Sessao::flash('Acesso restrito a administradores. Faça login.', 'erro');
            Url::redirecionar('administrador/login_adm');
            return;
        }

        // Busca os dados da conta que está tentando acessar a área administrativa.
        $pessoa = $this->model('Pessoa')->buscarPorId(Sessao::id());

        // Verifica se a conta existe, está ativa e pertence a um administrador.
        if (
            !$pessoa || $pessoa->pess_status !== 'Ativo'
            || $pessoa->perf_nome !== 'Administrador'
        ) {
            // Encerra a sessão caso a conta não tenha permissão para acessar essa área.
            Sessao::sair();
            Sessao::flash('Sua conta não possui acesso administrativo ativo.', 'erro');
            Url::redirecionar('administrador/login_adm');
            return;
        }

        // Atualiza os dados da sessão sem gerar outro identificador.
        $_SESSION['usuario_nome'] = $pessoa->pess_nome;
        $_SESSION['usuario_email'] = $pessoa->emai_nome;
        $_SESSION['usuario_perfil'] = $pessoa->perf_nome;
    }

    // Verifica se a página recebeu informações por meio de um formulário.
    protected function ehPost()
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    // Lê um ID inteiro positivo enviado pela URL ou por um formulário.
    protected function idRecebido($nome = 'id', $origem = INPUT_GET)
    {
        // Recebe o valor e verifica se ele é um número inteiro válido.
        $id = filter_input($origem, $nome, FILTER_VALIDATE_INT);

        // Retorna o ID somente se ele for maior que zero; caso contrário, retorna zero.
        return ($id && $id > 0) ? $id : 0;
    }
}
