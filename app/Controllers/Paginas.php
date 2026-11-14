
<?php

// Controla as páginas públicas, o catálogo de histórias e as funções de autenticação.
class Paginas extends Controller
{
    // Utiliza as funções compartilhadas de login, perfil, senha e notificações.
    use AcoesDaConta;

    // Exibe a página inicial com as histórias cadastradas e permite pesquisar pelo título.
    public function index()
    {
        // Recebe o texto digitado na pesquisa e remove os espaços desnecessários.
        $busca = trim($_GET['busca'] ?? '');

        // Busca as histórias de acordo com a pesquisa e envia os dados para a página inicial.
        $this->view('paginas/index', [
            'historias' => $this->model('Historia')->listarTodas($busca),
            'busca' => $busca
        ]);
    }

    // ---------------------------------------------------------------
    // Recuperação de senha
    // ---------------------------------------------------------------

    // Permite que a pessoa solicite um link para criar uma nova senha.
    public function esqueceu_senha()
    {
        // Se a página ainda não recebeu o formulário, apenas exibe a tela de recuperação.
        if (!$this->ehPost()) {
            $this->view('paginas/autenticacao/esqueceu_senha');
            return;
        }

        // Recebe o e-mail informado, remove espaços e transforma as letras em minúsculas.
        $email = mb_strtolower(trim($_POST['email'] ?? ''), 'UTF-8');

        // Verifica se o e-mail possui um formato válido e não ultrapassa o limite permitido.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email, 'UTF-8') > 200) {
            Sessao::flash('Digite um e-mail válido. Exemplo: nome@email.com', 'erro');
            Url::redirecionar('paginas/esqueceu_senha');
        }

        // Evita que a mesma pessoa solicite vários links de recuperação em pouco tempo.
        $agora = time();
        $ultimoPedido = (int) ($_SESSION['recuperacao_ultimo_pedido'] ?? 0);

        // Exige um intervalo de pelo menos um minuto entre as solicitações.
        if ($agora - $ultimoPedido < 60) {
            Sessao::flash('Aguarde um minuto antes de pedir um novo link.', 'erro');
            Url::redirecionar('paginas/esqueceu_senha');
        }

        // Guarda o horário da solicitação para controlar os próximos pedidos.
        $_SESSION['recuperacao_ultimo_pedido'] = $agora;

        // Procura no banco de dados uma conta cadastrada com o e-mail informado.
        $pessoa = $this->model('Pessoa')->buscarPorEmail($email);

        // Envia o link somente se a conta existir e estiver ativa.
        // A mensagem exibida é a mesma mesmo quando o e-mail não está cadastrado.
        if ($pessoa && $pessoa->pess_status === 'Ativo' && !RecuperacaoSenha::enviarLink($pessoa)) {
            unset($_SESSION['recuperacao_ultimo_pedido']);
            Sessao::flash('Não foi possível enviar o e-mail agora. Tente novamente em alguns instantes.', 'erro');
            Url::redirecionar('paginas/esqueceu_senha');
        }

        // Mostra uma mensagem informando que, caso o e-mail esteja cadastrado,
        // o link foi enviado e poderá ser utilizado dentro do prazo estabelecido.
        Sessao::flash(
            'Se este e-mail estiver cadastrado, enviamos um link para criar uma nova senha. ' .
                'Ele vale por ' . RecuperacaoSenha::validadeEmMinutos() . ' minutos. ' .
                'Se não encontrar a mensagem, olhe também a caixa de spam.'
        );

        Url::redirecionar('paginas/login');
    }

    // Permite que a pessoa crie uma nova senha utilizando o link recebido por e-mail.
    public function redefinir_senha()
    {
        // Impede que o link de recuperação seja repassado automaticamente para outros sites
        // ou que a página fique armazenada no cache do navegador.
        header('Referrer-Policy: no-referrer');
        header('Cache-Control: no-store');

        // Recebe o código de recuperação enviado pelo formulário ou pela URL.
        $token = $this->ehPost()
            ? (string) ($_POST['token'] ?? '')
            : (string) ($_GET['token'] ?? '');

        // Carrega o model responsável por buscar as informações da pessoa cadastrada.
        $pessoaModel = $this->model('Pessoa');

        // Verifica se o código recebido pertence a uma solicitação válida e ainda está dentro do prazo.
        try {
            $pessoa = RecuperacaoSenha::pessoaDoToken($token, $pessoaModel);
        } catch (Throwable $erro) {
            // Registra o erro para consulta e considera o link inválido.
            error_log('Erro ao validar o link de redefinição: ' . $erro->getMessage());
            $pessoa = false;
        }

        // Se o código não for encontrado ou estiver vencido, solicita um novo link.
        if (!$pessoa) {
            Sessao::flash('Este link é inválido ou expirou. Peça um novo link.', 'erro');
            Url::redirecionar('paginas/esqueceu_senha');
        }

        // Se a pessoa ainda não enviou o formulário, exibe a página para criar a nova senha.
        if (!$this->ehPost()) {
            $this->view('paginas/autenticacao/redefinir_senha', ['token' => $token]);
            return;
        }

        // Guarda o endereço da página para retornar caso alguma informação esteja incorreta.
        $voltar = 'paginas/redefinir_senha?token=' . rawurlencode($token);

        // Recebe a nova senha e a confirmação informadas no formulário.
        $nova = (string) ($_POST['nova_senha'] ?? '');
        $confirmacao = (string) ($_POST['confirmar_senha'] ?? '');

        // Verifica se a senha possui pelo menos uma letra, um número e um caractere especial.
        $temLetra = preg_match('/[a-zA-ZÀ-ÿ]/u', $nova);
        $temNumero = preg_match('/[0-9]/', $nova);
        $temSimbolo = preg_match('/[^a-zA-Z0-9À-ÿ\\s]/u', $nova);

        // Exige que a senha tenha entre 8 e 30 caracteres e atenda aos critérios estabelecidos.
        if (
            strlen($nova) < 8 || strlen($nova) > 30
            || !$temLetra || !$temNumero || !$temSimbolo
        ) {
            Sessao::flash(
                'A senha precisa ter entre 8 e 30 caracteres, pelo menos uma letra, um número e um caractere especial.',
                'erro'
            );
            Url::redirecionar($voltar);
        }

        // Confere se a senha e sua confirmação foram digitadas da mesma maneira.
        if ($nova !== $confirmacao) {
            Sessao::flash('A confirmação não confere com a nova senha.', 'erro');
            Url::redirecionar($voltar);
        }

        // Atualiza a senha da pessoa e faz com que o link utilizado não possa ser usado novamente.
        try {
            $pessoaModel->atualizarSenha($pessoa->pess_id, $nova);
        } catch (Throwable $erro) {
            // Registra o erro caso aconteça algum problema ao salvar a nova senha.
            error_log('Erro ao redefinir a senha: ' . $erro->getMessage());
            Sessao::flash('Não foi possível salvar a nova senha. Tente novamente.', 'erro');
            Url::redirecionar($voltar);
        }

        // Informa que a senha foi alterada e direciona a pessoa para fazer login novamente.
        Sessao::flash('Senha alterada com sucesso! Entre com a nova senha.');
        Url::redirecionar('paginas/login');
    }

    // Exibe a página de configurações do sistema.
    public function configuracoes()
    {
        $this->view('paginas/Configuracoes');
    }

    // ---------------------------------------------------------------
    // Telas públicas e autenticação
    // ---------------------------------------------------------------

    // Exibe a página de login e processa os dados informados pela pessoa.
    public function login()
    {
        // Se o formulário for enviado, verifica os dados de acesso antes de continuar.
        if ($this->ehPost()) {
            $this->processarLogin('paginas/login');
        }

        // Recebe o ID de uma história que a pessoa tentou acessar antes de fazer login.
        $historiaId = filter_input(INPUT_GET, 'historia', FILTER_VALIDATE_INT);

        // Guarda o ID para que a pessoa possa voltar à história depois de entrar na conta.
        if ($historiaId && $historiaId > 0) {
            $_SESSION['historia_apos_login'] = $historiaId;
        }

        // Exibe a página de login.
        $this->view('paginas/autenticacao/login');
    }

    // Exibe o formulário de cadastro de uma nova pessoa.
    public function cadastro()
    {
        // Verifica se a pessoa tentou acessar uma história antes de realizar o cadastro.
        $historiaId = filter_input(INPUT_GET, 'historia', FILTER_VALIDATE_INT);

        // Guarda o ID da história para permitir que ela seja acessada depois do cadastro.
        if ($historiaId && $historiaId > 0) {
            $_SESSION['historia_apos_login'] = $historiaId;
        }

        // Abre a página de cadastro.
        $this->view('paginas/autenticacao/cadastro');
    }

    // Exibe a página com as informações sobre o projeto.
    public function sobre_nos()
    {
        $this->view('paginas/sobre_nos');
    }

    // Exibe a tela de confirmação de saída de acordo com o tipo de conta que está logada.
    public function sair()
    {
        // Se não existir uma pessoa logada, retorna diretamente para a página de login.
        if (!Sessao::estaLogado()) {
            Url::redirecionar('paginas/login');
            return;
        }

        // Verifica se a conta logada pertence a um administrador.
        $administrador = Sessao::ehAdministrador();

        // Define para qual página a pessoa poderá voltar caso não queira sair da conta.
        $paginaInicio = $administrador
            ? 'administrador/inicio_adm'
            : 'usuarios/inicio_user';

        // Abre a tela de confirmação e envia o endereço da página inicial correspondente.
        $this->view('paginas/autenticacao/sair', [
            'paginaInicio' => $paginaInicio
        ]);
    }

    // Encerra a sessão somente quando a pessoa confirma a saída.
    public function logout()
    {
        // Finaliza a sessão atual e informa que a pessoa saiu da conta.
        Sessao::sair();
        Sessao::flash('Você saiu da sua conta.');

        // Direciona para a página de login após encerrar a sessão.
        Url::redirecionar('paginas/login');
    }
}
