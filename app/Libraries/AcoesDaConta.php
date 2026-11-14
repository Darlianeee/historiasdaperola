<?php
// Reúne ações compartilhadas de autenticação, perfil, senha e notificações.

trait AcoesDaConta
{
    
    // Login

    // Verifica os dados informados e realiza o acesso à conta.
    protected function processarLogin($paginaLogin, $somenteAdministrador = false)
    {
        // Se a solicitação não veio de um formulário, retorna para a página de login.
        if (!$this->ehPost()) {
            Url::redirecionar($paginaLogin);
        }

        // Uma tentativa nova de login não pode aproveitar uma sessão anterior.
        // Preserva somente a história escolhida no catálogo, se houver.
        $historiaPendente = $_SESSION['historia_apos_login'] ?? null;
        Sessao::sair();
        if ($historiaPendente) {
            $_SESSION['historia_apos_login'] = (int) $historiaPendente;
        }

        // Recebe o e-mail e a senha informados no formulário.
        $email = mb_strtolower(trim($_POST['email'] ?? ''), 'UTF-8');
        $senha = (string) ($_POST['senha'] ?? '');

        // Guarda o e-mail para que ele continue preenchido caso ocorra algum erro.
        $_SESSION['antigo_email'] = $email;

        // Verifica se os dois campos foram preenchidos.
        if ($email === '' || $senha === '') {
            Sessao::flash('Informe e-mail e senha.', 'erro');
            Url::redirecionar($paginaLogin);
        }

        // Procura no banco de dados uma conta com o e-mail informado.
        $pessoa = $this->model('Pessoa')->buscarPorEmail($email);

        $pessoa = $this->model('Pessoa')->buscarPorEmail($email);

        // Verifica se existe uma conta cadastrada com esse e-mail.
        if (!$pessoa) {
            Sessao::flash('Conta não encontrada. Cadastre-se primeiro.', 'erro');
            Url::redirecionar($paginaLogin);
        }

        // Confere se a senha informada corresponde à senha salva no banco de dados.
        if (!password_verify($senha, $pessoa->pess_senha)) {
            Sessao::flash('E-mail ou senha incorretos.', 'erro');
            Url::redirecionar($paginaLogin);
        }

        // Impede o acesso de contas que estejam inativas.
        if ($pessoa->pess_status !== 'Ativo') {
            Sessao::flash('Sua conta está inativa. Procure um administrador.', 'erro');
            Url::redirecionar($paginaLogin);
        }

        // Quando o acesso for exclusivo de administrador, verifica o tipo da conta.
        if ($somenteAdministrador && $pessoa->perf_nome !== 'Administrador') {
            Sessao::flash('Este acesso é exclusivo para administradores.', 'erro');
            Url::redirecionar($paginaLogin);
        }

        // Remove o e-mail guardado e inicia a sessão da pessoa que entrou na conta.
        unset($_SESSION['antigo_email']);
        Sessao::entrar($pessoa);
        Sessao::flash('Login realizado com sucesso!');

        // Se o login começou no catálogo, o usuário continua para a história escolhida.
        if ($pessoa->perf_nome !== 'Administrador' && !empty($_SESSION['historia_apos_login'])) {
            $historiaId = (int) $_SESSION['historia_apos_login'];
            unset($_SESSION['historia_apos_login']);
            Url::redirecionar('usuarios/historias_user?id=' . $historiaId);
        }

        // Direciona cada tipo de conta para sua página inicial.
        Url::redirecionar(
            $pessoa->perf_nome === 'Administrador' ? 'administrador/inicio_adm' : 'usuarios/inicio_user'
        );
    }

    // Perfil

    // Busca os dados da pessoa que está com a conta aberta.
    protected function pessoaLogada()
    {
        $pessoa = $this->model('Pessoa')->buscarPorId(Sessao::id());

        // Conta excluída ou desativada enquanto estava logada.
        if (!$pessoa || $pessoa->pess_status !== 'Ativo') {
            Sessao::sair();
            Sessao::flash('Sua sessão foi encerrada. Faça login novamente.', 'erro');
            Url::redirecionar('paginas/login');
        }

        // Retorna os dados da pessoa que está logada.
        return $pessoa;
    }

    // Exibe a página de perfil com os dados da pessoa logada.
    protected function mostrarPerfil($view)
    {
        $this->view($view, ['pessoa' => $this->pessoaLogada()]);
    }

    // Exibe o formulário de edição e salva as alterações do perfil.
    protected function processarEdicaoPerfil($view, $rotaPerfil, $rotaEdicao)
    {
        // Busca os dados da pessoa antes de permitir a edição.
        $pessoa = $this->pessoaLogada();

        // Se o formulário ainda não foi enviado, apenas abre a página de edição.
        if (!$this->ehPost()) {
            $this->view($view, ['pessoa' => $pessoa]);
            return;
        }

        // Recebe o nome informado e remove os espaços desnecessários.
        $nome = trim($_POST['nome'] ?? '');

        // O e-mail é fixo no perfil; ignora qualquer campo email enviado pelo navegador.
        $email = $pessoa->emai_nome;

        // Verifica se o nome possui a quantidade de caracteres permitida.
        if (mb_strlen($nome, 'UTF-8') < 2 || mb_strlen($nome, 'UTF-8') > 100) {
            Sessao::flash('O nome deve ter entre 2 e 100 caracteres.', 'erro');
            Url::redirecionar($rotaEdicao);
        }

        // Carrega o model responsável por atualizar os dados da pessoa.
        $pessoaModel = $this->model('Pessoa');

        // Recebe a foto enviada e verifica se ela está dentro do limite permitido.
        [$foto, $erroFoto] = Html::lerImagemEnviada('fotoPerfil', 2);

        // Se a foto apresentar algum problema, retorna para a página de edição.
        if ($erroFoto) {
            Sessao::flash($erroFoto, 'erro');
            Url::redirecionar($rotaEdicao);
        }

        // Salva o nome e a foto atualizados no banco de dados.
        if (!$pessoaModel->atualizarDados($pessoa->pess_id, $nome, $foto)) {
            Sessao::flash('Não foi possível salvar as alterações. Tente novamente.', 'erro');
            Url::redirecionar($rotaEdicao);
        }

        // Atualiza o nome e o e-mail guardados na sessão.
        $_SESSION['usuario_nome'] = $nome;
        $_SESSION['usuario_email'] = $email;

        // Informa que as alterações foram salvas e retorna ao perfil.
        Sessao::flash('Dados atualizados com sucesso!');
        Url::redirecionar($rotaPerfil);
    }

    // Permite que a pessoa altere a senha da própria conta.
    protected function processarAlteracaoSenha($view, $rotaPerfil, $rotaSenha)
    {
        // Busca os dados da pessoa que está logada.
        $pessoa = $this->pessoaLogada();

        // Se o formulário ainda não foi enviado, exibe a página de alteração de senha.
        if (!$this->ehPost()) {
            $this->view($view);
            return;
        }

        // Recebe a senha atual, a nova senha e sua confirmação.
        $atual = (string) ($_POST['senha_atual'] ?? '');
        $nova = (string) ($_POST['nova_senha'] ?? '');
        $confirmacao = (string) ($_POST['confirmar_senha'] ?? '');

        // Confere se a senha atual informada está correta.
        if (!password_verify($atual, $pessoa->pess_senha)) {
            Sessao::flash('A senha atual está incorreta.', 'erro');
            Url::redirecionar($rotaSenha);
        }

        // Verifica se a nova senha possui entre 8 e 30 caracteres.
        if (strlen($nova) < 8 || strlen($nova) > 30) {
            Sessao::flash('A nova senha precisa ter entre 8 e 30 caracteres.', 'erro');
            Url::redirecionar($rotaSenha);
        }

        // Confere se a nova senha e a confirmação são iguais.
        if ($nova !== $confirmacao) {
            Sessao::flash('A confirmação não confere com a nova senha.', 'erro');
            Url::redirecionar($rotaSenha);
        }

        // Salva a nova senha no banco de dados.
        $this->model('Pessoa')->atualizarSenha($pessoa->pess_id, $nova);

        // Informa que a senha foi alterada e retorna para o perfil.
        Sessao::flash('Senha alterada com sucesso!');
        Url::redirecionar($rotaPerfil);
    }

    // Notificações

    // Busca as notificações da pessoa de acordo com os filtros escolhidos.
    protected function listarNotificacoes($view)
    {
        // Recebe o filtro selecionado ou utiliza "todas" como padrão.
        $filtro = $_GET['filtro'] ?? 'todas';

        // Aceita somente os filtros disponíveis.
        if (!in_array($filtro, ['todas', 'nao_lidas', 'lidas'], true)) {
            $filtro = 'todas';
        }

        // Recebe o texto da pesquisa e a data escolhida.
        $busca = trim($_GET['busca'] ?? '');
        $data = $_GET['data'] ?? '';

        // Verifica se a data foi informada no formato correto.
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
            $data = '';
        }

        // Busca as notificações de acordo com a pessoa, o filtro, a pesquisa e a data.
        $notificacoes = $this->model('Notificacao')->listar(Sessao::id(), $filtro, $busca, $data);

        // Envia as notificações e os filtros para a página.
        $this->view($view, [
            'notificacoes' => $notificacoes,
            'filtro' => $filtro,
            'busca' => $busca,
            'data' => $data
        ]);
    }

    // Exibe os detalhes de uma notificação selecionada.
    protected function detalharNotificacao($view, $rotaLista)
    {
        // Recebe o ID da notificação e procura os dados correspondentes.
        $id = $this->idRecebido();
        $model = $this->model('Notificacao');
        $notificacao = $id ? $model->buscar(Sessao::id(), $id) : false;

        // Se a notificação não existir, retorna para a lista.
        if (!$notificacao) {
            Sessao::flash('Notificação não encontrada.', 'erro');
            Url::redirecionar($rotaLista);
        }

        // Abrir a notificação já marca como lida.
        $model->marcarComoLida(Sessao::id(), $id);

        // Envia os dados da notificação e o ID da história relacionada para a página.
        $this->view($view, [
            'notificacao' => $notificacao,
            'historiaId' => (int) ($notificacao->hist_id ?? 0)
        ]);
    }

    // Marca uma notificação como lida.
    protected function marcarNotificacaoLida($rotaLista)
    {
        // Recebe o ID da notificação selecionada.
        $id = $this->idRecebido();

        // Se o ID for válido, atualiza o status da notificação.
        if ($id) {
            $this->model('Notificacao')->marcarComoLida(Sessao::id(), $id);
            Sessao::flash('Notificação marcada como lida.');
        }

        // Retorna para a lista de notificações.
        Url::redirecionar($rotaLista);
    }

    // Exibe a confirmação de exclusão e remove a notificação quando solicitado.
    protected function excluirNotificacao($view, $rotaLista)
    {
        // Carrega o model responsável pelas notificações.
        $model = $this->model('Notificacao');

        // Verifica se a pessoa confirmou a exclusão pelo formulário.
        if ($this->ehPost()) {
            // Recebe o ID enviado pelo formulário.
            $id = $this->idRecebido('id', INPUT_POST);

            // Tenta excluir a notificação e mostra o resultado da operação.
            if ($id && $model->remover(Sessao::id(), $id)) {
                Sessao::flash('Notificação excluída.');
            } else {
                Sessao::flash('Não foi possível excluir a notificação.', 'erro');
            }

            // Depois da tentativa, retorna para a lista de notificações.
            Url::redirecionar($rotaLista);
        }

        // Busca a notificação que será exibida na tela de confirmação.
        $id = $this->idRecebido();
        $notificacao = $id ? $model->buscar(Sessao::id(), $id) : false;

        // Se a notificação não existir, retorna para a lista.
        if (!$notificacao) {
            Sessao::flash('Notificação não encontrada.', 'erro');
            Url::redirecionar($rotaLista);
        }

        // Envia os dados da notificação e da história relacionada para a página.
        $this->view($view, [
            'notificacao' => $notificacao,
            'historiaId' => (int) ($notificacao->hist_id ?? 0)
        ]);
    }

    // Leitura de história (dados comuns às telas de usuário e admin)

    // Busca e organiza as informações necessárias para exibir uma história.
    protected function dadosLeituraHistoria($rotaVoltar)
    {
        // Recebe o ID da história e procura seus dados no banco.
        $id = $this->idRecebido();
        $historia = $id ? $this->model('Historia')->buscarPorId($id) : false;

        // Se a história não existir, retorna para a página indicada.
        if (!$historia) {
            Sessao::flash('História não encontrada.', 'erro');
            Url::redirecionar($rotaVoltar);
        }

        // Relaciona cada idioma ao seu código usado no sistema.
        $codigos = ['pt' => 1, 'es' => 2, 'wari' => 3];

        // Recebe o idioma escolhido ou utiliza o português como padrão.
        $idiomaAtual = $_GET['lang'] ?? 'pt';

        // Se o idioma não existir ou não estiver disponível para a história,
        // utiliza o português como idioma padrão.
        if (!isset($codigos[$idiomaAtual]) || !isset($historia->idiomas[$codigos[$idiomaAtual]])) {
            $idiomaAtual = 'pt';
        }

        // Garante um texto mesmo se faltar o português (dados antigos).
        $versao = $historia->idiomas[$codigos[$idiomaAtual]] ?? reset($historia->idiomas);

        // Prepara a lista dos idiomas que possuem tradução cadastrada para essa história.
        $disponiveis = [];
        foreach ($codigos as $codigo => $idiomaId) {
            if (isset($historia->idiomas[$idiomaId])) {
                $disponiveis[] = $codigo;
            }
        }

        // Carrega o model responsável pelas avaliações das histórias.
        $avaliacaoModel = $this->model('Avaliacao');

        // Retorna todas as informações que serão utilizadas na página de leitura.
        return [
            'historia' => $historia,
            'titulo_lenda' => $versao->titulo ?? '',
            'legenda_imagem' => $versao->legenda ?? '',
            'texto_lenda' => $versao->texto ?? '',
            'idioma_atual' => $idiomaAtual,
            'idiomas_disponiveis' => $disponiveis,
            'comentarios' => $this->model('Comentario')->listarPorHistoria($historia->id),
            'totalComentarios' => $this->model('Comentario')->totalPorHistoria($historia->id),
            'avaliacao' => $avaliacaoModel->resumo($historia->id),
            'minha_nota' => $avaliacaoModel->notaDaPessoa($historia->id, Sessao::id())
        ];
    }
}
