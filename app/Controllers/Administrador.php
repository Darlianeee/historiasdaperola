<?php

class Administrador extends Controller
{
    // Utiliza as funções compartilhadas de login, perfil, senha e notificações.
    use AcoesDaConta;

    // Define quais páginas podem ser acessadas sem estar logado como administrador.
    private $paginasPublicas = ['login_adm', 'login', 'logout'];

    public function __construct()
    {
        // Identifica qual página o administrador está tentando acessar.
        $metodo = explode('/', trim((string) ($_GET['url'] ?? ''), '/'))[1] ?? '';

        // Se a página não for pública, verifica se o administrador está logado.
        if (!in_array($metodo, $this->paginasPublicas, true)) {
            $this->exigirAdministrador();
        }
    }

    // Redireciona o administrador para a página inicial do sistema.
    public function index()
    {
        Url::redirecionar('administrador/inicio_adm');
    }

    // Acesso

    // Verifica se o administrador já está logado e direciona para a página correta.
    public function login_adm()
    {
        if (Sessao::ehAdministrador()) {
            Url::redirecionar('administrador/inicio_adm');
        }

        // Caso não esteja logado, encaminha para a página de login.
        Url::redirecionar('paginas/login');
    }

    // Direciona para a página de login do sistema.
    public function login()
    {
        Url::redirecionar('paginas/login');
    }

    // Encerra a sessão do administrador e mostra uma mensagem de saída.
    public function logout()
    {
        Sessao::sair();
        Sessao::flash('Você saiu da sua conta.');
        Url::redirecionar('paginas/login');
    }

    // Impede o cadastro direto de administradores e direciona para o gerenciamento de perfis.
    public function cadastro_adm()
    {
        Url::redirecionar('administrador/gerenciar_perfis');
    }

    // Perfil

    // Exibe as informações do perfil do administrador logado.
    public function perfil_adm()
    {
        $this->mostrarPerfil('administrador/perfil/perfil_adm');
    }

    // Permite editar as informações do perfil e retornar à página do perfil após a alteração.
    public function editar_perfil_adm()
    {
        $this->processarEdicaoPerfil('administrador/perfil/editar_perfil_adm', 'administrador/perfil/perfil_adm', 'administrador/perfil/editar_perfil_adm');
    }

    // Processa a alteração de senha do administrador.
    public function alterar_senha_adm()
    {
        $this->processarAlteracaoSenha('administrador/perfil/alterar_senha_adm', 'administrador/perfil/perfil_adm', 'administrador/perfil/alterar_senha_adm');
    }

    // Exibe a página inicial do administrador com a quantidade de histórias cadastradas.
    public function inicio_adm()
    {
        $this->view('administrador/inicio_adm', [
            'totalHistorias' => $this->model('Historia')->totalCadastradas()
        ]);
    }

    // Gerenciar perfis

    // Busca todas as pessoas cadastradas e exibe a lista para o administrador.
    public function gerenciar_perfis()
    {
        $this->view('administrador/usuarios/gerenciar_perfis', [
            'pessoas' => $this->model('Pessoa')->listarTodas()
        ]);
    }

    // Permite alterar o perfil e o status de uma pessoa cadastrada.
    public function editar_usuarios()
    {
        $pessoaModel = $this->model('Pessoa');

        // Verifica se o formulário foi enviado para salvar as alterações.
        if ($this->ehPost()) {
            $id = $this->idRecebido('id', INPUT_POST);
            $perfil = filter_input(INPUT_POST, 'perfil', FILTER_VALIDATE_INT);
            $status = $_POST['status'] ?? '';
            $pessoa = $id ? $pessoaModel->buscarPorId($id) : false;

            // Confere se a pessoa existe e se os dados escolhidos são válidos.
            if (
                !$pessoa || !in_array($perfil, [Pessoa::PERFIL_ADMINISTRADOR, Pessoa::PERFIL_USUARIO], true)
                || !in_array($status, ['Ativo', 'Inativo'], true)
            ) {
                Sessao::flash('Dados inválidos.', 'erro');
                Url::redirecionar('administrador/gerenciar_perfis');
            }

            // Verifica se o administrador está tentando manter seu próprio acesso.
            $continuaAdminAtivo = $perfil === Pessoa::PERFIL_ADMINISTRADOR && $status === 'Ativo';

            // Impede que o administrador retire seu próprio acesso ao sistema.
            if ($id === Sessao::id() && !$continuaAdminAtivo) {
                Sessao::flash('Você não pode remover o seu próprio acesso de administrador.', 'erro');
                Url::redirecionar('administrador/editar_usuarios?id=' . $id);
            }

            // Salva o novo perfil e o status da pessoa no banco de dados.
            $pessoaModel->atualizarPerfilEStatus($id, $perfil, $status);

            Sessao::flash('Alterações salvas com sucesso!');
            Url::redirecionar('administrador/gerenciar_perfis');
        }

        // Busca os dados da pessoa selecionada para preencher o formulário de edição.
        $id = $this->idRecebido();
        $pessoa = $id ? $pessoaModel->buscarPorId($id) : false;

        // Se a pessoa não for encontrada, retorna para a lista de perfis.
        if (!$pessoa) {
            Sessao::flash('Selecione uma pessoa na lista para editar.', 'erro');
            Url::redirecionar('administrador/gerenciar_perfis');
        }

        // Abre a página de edição enviando os dados da pessoa e os perfis disponíveis.
        $this->view('administrador/usuarios/editar_usuarios', [
            'pessoa' => $pessoa,
            'perfis' => $pessoaModel->listarPerfis()
        ]);
    }

    // Exclui uma pessoa cadastrada, desde que ela não seja o próprio administrador.
    public function excluir_pessoa()
    {
        $id = $this->idRecebido('id', INPUT_POST);
        $pessoaModel = $this->model('Pessoa');

        // Confere se a solicitação foi enviada pelo formulário e se recebeu um ID válido.
        if (!$this->ehPost() || !$id) {
            Url::redirecionar('administrador/gerenciar_perfis');
        }

        // Impede que o administrador exclua a própria conta.
        if ($id === Sessao::id()) {
            Sessao::flash('Você não pode excluir a sua própria conta.', 'erro');
            Url::redirecionar('administrador/gerenciar_perfis');
        }

        // Verifica quantas histórias foram cadastradas pela pessoa.
        $totalHistorias = $pessoaModel->totalHistoriasCadastradas($id);

        // Não permite excluir pessoas que possuem histórias cadastradas.
        if ($totalHistorias > 0) {
            Sessao::flash(
                'Esta pessoa cadastrou ' . $totalHistorias . ' história(s) e não pode ser excluída. ' .
                    'Edite e marque como "Inativo" para bloquear o acesso.',
                'erro'
            );
            Url::redirecionar('administrador/gerenciar_perfis');
        }

        // Tenta excluir a pessoa e mostra uma mensagem conforme o resultado.
        if ($pessoaModel->excluir($id)) {
            Sessao::flash('Pessoa excluída com sucesso.');
        } else {
            Sessao::flash('Não foi possível excluir esta pessoa.', 'erro');
        }

        Url::redirecionar('administrador/gerenciar_perfis');
    }

    // Histórias

    // Exibe o menu principal da área administrativa.
    public function menu_adm()
    {
        $this->view('administrador/menu_adm');
    }

    // Abre o formulário utilizado para cadastrar uma nova história.
    public function nova_historia()
    {
        $this->view('administrador/historias/nova_historia');
    }

    // Recebe os dados do formulário e realiza o cadastro de uma nova história.
    public function salvar_historia()
    {
        // Verifica se o cadastro foi enviado pelo método POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . '/administrador/nova_historia');
            exit;
        }

        // Recebe a categoria escolhida e verifica se ela é válida.
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_VALIDATE_INT);

        if (!$categoria || !in_array($categoria, [1, 2], true)) {
            die('Selecione uma categoria válida.');
        }

        // Reúne os títulos, legendas e textos enviados nos três idiomas disponíveis.
        $todosIdiomas = [
            [
                'id' => 1,
                'titulo' => trim($_POST['titulo_pt'] ?? ''),
                'legenda' => trim($_POST['legenda_pt'] ?? ''),
                'texto' => trim($_POST['texto_pt'] ?? '')
            ],
            [
                'id' => 2,
                'titulo' => trim($_POST['titulo_es'] ?? ''),
                'legenda' => trim($_POST['legenda_es'] ?? ''),
                'texto' => trim($_POST['texto_es'] ?? '')
            ],
            [
                'id' => 3,
                'titulo' => trim($_POST['titulo_wari'] ?? ''),
                'legenda' => trim($_POST['legenda_wari'] ?? ''),
                'texto' => trim($_POST['texto_wari'] ?? '')
            ]
        ];

        // Guarda somente os idiomas que poderão ser cadastrados.
        $idiomas = [];

        foreach ($todosIdiomas as $idioma) {
            // Verifica quais campos do idioma foram preenchidos.
            $tituloPreenchido = $idioma['titulo'] !== '';
            $legendaPreenchida = $idioma['legenda'] !== '';
            $textoPreenchido = $idioma['texto'] !== '';

            // Verifica se pelo menos um dos campos recebeu alguma informação.
            $algumPreenchido =
                $tituloPreenchido ||
                $legendaPreenchida ||
                $textoPreenchido;

            // Verifica se todos os campos daquele idioma foram preenchidos.
            $todosPreenchidos =
                $tituloPreenchido &&
                $legendaPreenchida &&
                $textoPreenchido;

            // Exige que o título, a legenda e o texto em português sejam preenchidos.
            if ($idioma['id'] === 1 && !$todosPreenchidos) {
                die('Preencha título, legenda e texto em português.');
            }

            // Nas traduções, exige que todos os campos sejam preenchidos ou deixados vazios.
            if ($idioma['id'] !== 1 && $algumPreenchido && !$todosPreenchidos) {
                die('Preencha título, legenda e texto da tradução escolhida, ' .
                    'ou deixe os três campos vazios.');
            }

            // Adiciona à lista somente os idiomas que estão completamente preenchidos.
            if ($todosPreenchidos) {
                $idiomas[] = $idioma;
            }
        }

        // Verifica se uma imagem foi enviada corretamente pelo formulário.
        if (
            !isset($_FILES['imagem']) ||
            $_FILES['imagem']['error'] !== UPLOAD_ERR_OK
        ) {
            die('Selecione uma imagem válida.');
        }

        // Impede o envio de imagens maiores que 5 MB.
        if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) {
            die('A imagem deve ter no máximo 5 MB.');
        }

        // Identifica o tipo do arquivo enviado para conferir se ele é permitido.
        $arquivoTemporario = $_FILES['imagem']['tmp_name'];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $tipoImagem = $finfo->file($arquivoTemporario);

        // Define os formatos de imagem aceitos pelo sistema.
        $tiposPermitidos = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        // Impede o cadastro caso o arquivo não seja de um dos formatos permitidos.
        if (!in_array($tipoImagem, $tiposPermitidos, true)) {
            die('Use uma imagem JPG, PNG ou WEBP.');
        }

        // Lê o conteúdo da imagem para que ela possa ser enviada ao model.
        $imagem = file_get_contents($arquivoTemporario);

        if ($imagem === false) {
            die('Não foi possível ler a imagem.');
        }

        // Identifica o administrador responsável pelo cadastro da história.
        $pessoa = Sessao::id();

        // Carrega o model responsável pelas operações relacionadas às histórias.
        $historia = $this->model('Historia');

        // Envia a imagem, a categoria, o administrador e os idiomas para realizar o cadastro.
        $cadastroRealizado = $historia->cadastrar(
            $imagem,
            $categoria,
            $pessoa,
            $idiomas
        );

        // Se o cadastro for concluído, mostra uma mensagem e retorna à lista de histórias.
        if ($cadastroRealizado) {
            Sessao::flash('História cadastrada com sucesso!');
            Url::redirecionar('administrador/gerenciar_historia_adm');
        }

        // Caso ocorra algum problema, informa que o cadastro não foi realizado.
        Sessao::flash(
            'Não foi possível cadastrar a história. Verifique os dados e tente novamente. ' .
                'Se a imagem for grande, confira o max_allowed_packet do MySQL (veja o README).',
            'erro'
        );
        Url::redirecionar('administrador/nova_historia');
    }

    // Busca todas as histórias cadastradas e exibe a lista na área administrativa.
    public function gerenciar_historia_adm()
    {
        $historiaModel = $this->model('Historia');

        // Busca as informações de todas as histórias.
        $historias = $historiaModel->listarTodas();

        // Busca a quantidade total de histórias cadastradas.
        $totalHistorias = $historiaModel->totalCadastradas();

        // Envia as informações para a página de gerenciamento.
        $this->view('administrador/historias/gerenciar_historia_adm', [
            'historias' => $historias,
            'totalHistorias' => $totalHistorias
        ]);
    }

    // Redireciona a rota antiga de edição para a lista de histórias.
    public function editar_historia()
    {
        Url::redirecionar('administrador/gerenciar_historia_adm');
    }

    // Busca uma história específica e abre o formulário para editar suas informações.
    public function editar_historia_adm()
    {
        // Recebe e valida o ID da história enviado pela URL.
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Se o ID não for válido, retorna para a lista de histórias.
        if (!$id || $id < 1) {
            header('Location: ' . URL . '/administrador/gerenciar_historia_adm');
            exit;
        }

        // Carrega o model e busca a história correspondente ao ID recebido.
        $historiaModel = $this->model('Historia');
        $historia = $historiaModel->buscarPorId($id);

        // Se a história não existir, retorna para a lista.
        if (!$historia) {
            header('Location: ' . URL . '/administrador/gerenciar_historia_adm');
            exit;
        }

        // Abre a página de edição enviando os dados da história encontrada.
        $this->view('administrador/historias/editar_historia', [
            'historia' => $historia
        ]);
    }

    // Recebe as alterações do formulário e atualiza uma história cadastrada.
    public function atualizar_historia()
    {
        // Verifica se o formulário foi enviado corretamente.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . '/administrador/gerenciar_historia_adm');
            exit;
        }

        // Recebe o ID da história e a categoria escolhida.
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_VALIDATE_INT);

        // Confere se o ID e a categoria recebidos são válidos.
        if (!$id || $id < 1 || !$categoria || !in_array($categoria, [1, 2], true)) {
            die('Dados inválidos para editar a história.');
        }

        // Busca a história atual para verificar se ela existe.
        $historiaModel = $this->model('Historia');
        $historiaAtual = $historiaModel->buscarPorId($id);

        if (!$historiaAtual) {
            die('História não encontrada.');
        }

        // Reúne os novos títulos, legendas e textos enviados em cada idioma.
        $todosIdiomas = [
            [
                'id' => 1,
                'titulo' => trim($_POST['titulo_pt'] ?? ''),
                'legenda' => trim($_POST['legenda_pt'] ?? ''),
                'texto' => trim($_POST['texto_pt'] ?? '')
            ],
            [
                'id' => 2,
                'titulo' => trim($_POST['titulo_es'] ?? ''),
                'legenda' => trim($_POST['legenda_es'] ?? ''),
                'texto' => trim($_POST['texto_es'] ?? '')
            ],
            [
                'id' => 3,
                'titulo' => trim($_POST['titulo_wari'] ?? ''),
                'legenda' => trim($_POST['legenda_wari'] ?? ''),
                'texto' => trim($_POST['texto_wari'] ?? '')
            ]
        ];

        // Guarda os idiomas que possuem todos os campos preenchidos.
        $idiomasParaSalvar = [];

        foreach ($todosIdiomas as $idioma) {
            // Verifica se algum campo do idioma recebeu uma informação.
            $algumPreenchido =
                $idioma['titulo'] !== '' ||
                $idioma['legenda'] !== '' ||
                $idioma['texto'] !== '';

            // Verifica se título, legenda e texto foram preenchidos.
            $todosPreenchidos =
                $idioma['titulo'] !== '' &&
                $idioma['legenda'] !== '' &&
                $idioma['texto'] !== '';

            // Mantém o português como idioma obrigatório.
            if ($idioma['id'] === 1 && !$todosPreenchidos) {
                die('Preencha título, legenda e texto em português.');
            }

            // Exige que as traduções sejam preenchidas por completo ou deixadas vazias.
            if ($idioma['id'] !== 1 && $algumPreenchido && !$todosPreenchidos) {
                die('Preencha todos os campos da tradução escolhida.');
            }

            // Adiciona somente os idiomas que estão completos.
            if ($todosPreenchidos) {
                $idiomasParaSalvar[] = $idioma;
            }
        }

        // Começa sem uma nova imagem, mantendo a imagem atual da história.
        $imagem = null;

        // Verifica se o administrador escolheu enviar uma nova imagem.
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {

            // Confere se o envio da nova imagem aconteceu corretamente.
            if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
                die('Não foi possível enviar a imagem.');
            }

            // Limita o tamanho da nova imagem a 5 MB.
            if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) {
                die('A imagem deve ter no máximo 5 MB.');
            }

            // Identifica o formato da imagem para verificar se ele é permitido.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tipoImagem = $finfo->file($_FILES['imagem']['tmp_name']);

            if (!in_array($tipoImagem, ['image/jpeg', 'image/png', 'image/webp'], true)) {
                die('Use uma imagem JPG, PNG ou WEBP.');
            }

            // Lê o conteúdo da nova imagem para enviar ao model.
            $imagem = file_get_contents($_FILES['imagem']['tmp_name']);

            if ($imagem === false) {
                die('Não foi possível ler a imagem.');
            }
        }

        // Envia os dados atualizados para salvar as alterações no banco de dados.
        $salvou = $historiaModel->salvarEdicao(
            $id,
            $categoria,
            $imagem,
            $idiomasParaSalvar
        );

        // Se a edição for concluída, envia uma notificação e retorna à lista de histórias.
        if ($salvou) {
            $this->model('Notificacao')->enviarParaPerfil(
                Pessoa::PERFIL_ADMINISTRADOR,
                'História editada',
                'A história "' . $idiomasParaSalvar[0]['titulo'] . '" foi editada por ' . Sessao::nome() . '.',
                $id
            );

            Sessao::flash('História atualizada com sucesso!');
            Url::redirecionar('administrador/gerenciar_historia_adm');
        }

        // Informa caso não seja possível salvar as alterações.
        die('Não foi possível atualizar a história. Verifique os dados e tente novamente.');
    }

    // Mantém a rota antiga funcionando, utilizando a mesma função de exclusão.
    public function excluir_historia()
    {
        $this->excluir_historia_adm();
    }

    // Exibe a confirmação de exclusão e, após a confirmação, remove a história.
    public function excluir_historia_adm()
    {
        $historiaModel = $this->model('Historia');

        // Verifica se a solicitação de exclusão foi enviada pelo formulário.
        if ($this->ehPost()) {

            // Recebe o ID enviado e verifica se ele corresponde a um número válido.
            $idPost = $_POST['id'] ?? null;
            $id = filter_var($idPost, FILTER_VALIDATE_INT);

            // Utiliza o método auxiliar caso o ID não tenha sido encontrado no formato esperado.
            $id = ($id && $id > 0) ? (int) $id : $this->idRecebido('id', INPUT_POST);

            // Tenta excluir a história e informa se a operação foi realizada.
            if ($id && $historiaModel->excluir($id)) {
                Sessao::flash('História excluída com sucesso.');
            } else {
                Sessao::flash('Não foi possível excluir a história.', 'erro');
            }

            Url::redirecionar('administrador/gerenciar_historia_adm');
        }

        // Busca o ID e o título da história que será excluída.
        $id = $this->idRecebido();
        $titulo = $id ? $historiaModel->tituloPorId($id) : '';

        // Se a história não for encontrada, retorna para a lista.
        if ($titulo === '') {
            Sessao::flash('História não encontrada.', 'erro');
            Url::redirecionar('administrador/gerenciar_historia_adm');
        }

        // Abre a página de confirmação enviando o ID e o título da história.
        $this->view('administrador/historias/excluir_historia', ['id' => $id, 'titulo' => $titulo]);
    }

    // Exibe uma história específica junto com os dados utilizados na sua leitura.
    public function historias_adm()
    {
        $this->view('administrador/historias/historias_adm', $this->dadosLeituraHistoria('administrador/gerenciar_historia_adm'));
    }

    // Comentários

    // Redireciona a antiga página de comentários para o gerenciamento de histórias.
    public function comentarios_adm()
    {
        Url::redirecionar('administrador/gerenciar_historia_adm');
    }

    // Permite que o administrador exclua comentários publicados nas histórias.
    public function excluir_comentario()
    {
        $comentarioModel = $this->model('Comentario');

        // Verifica se a solicitação de exclusão foi enviada pelo formulário.
        if ($this->ehPost()) {
            $id = $this->idRecebido('excluir_comentario', INPUT_POST) ?: $this->idRecebido('id', INPUT_POST);

            // Busca o comentário que será excluído.
            $comentario = $id ? $comentarioModel->buscarPorId($id) : false;

            // Exclui o comentário e retorna para a história onde ele foi publicado.
            if ($comentario && $comentarioModel->excluir($id, null, Sessao::id())) {
                Sessao::flash('Comentário excluído.');
                Url::redirecionar('administrador/historias_adm?id=' . $comentario->hist_id . '#comentarios');
            }

            // Caso não consiga excluir, informa o problema e retorna ao gerenciamento.
            Sessao::flash('Não foi possível excluir o comentário.', 'erro');
            Url::redirecionar('administrador/gerenciar_historia_adm');
        }

        // Busca o comentário para exibir a tela de confirmação da exclusão.
        $id = $this->idRecebido();
        $comentario = $id ? $comentarioModel->buscarPorId($id) : false;

        // Se o comentário não existir, retorna para o gerenciamento de histórias.
        if (!$comentario) {
            Sessao::flash('Comentário não encontrado.', 'erro');
            Url::redirecionar('administrador/gerenciar_historia_adm');
        }

        // Abre a página de confirmação enviando os dados do comentário.
        $this->view('administrador/usuarios/excluir_comentario', ['comentario' => $comentario]);
    }

    // Mantém a rota antiga funcionando e retorna para a área de comentários da história.
    public function responder_comentario()
    {
        $id = $this->idRecebido();
        $comentario = $id ? $this->model('Comentario')->buscarPorId($id) : false;

        Url::redirecionar($comentario ? 'administrador/historias_adm?id=' . $comentario->hist_id . '#comentarios' : 'administrador/gerenciar_historia_adm');
    }

    // Notificações

    // Exibe as notificações recebidas pelo administrador.
    public function notificacoes_adm()
    {
        $this->listarNotificacoes('administrador/notificacao/notificacoes_adm');
    }

    // Abre uma notificação específica para mostrar suas informações.
    public function detalhe_notificacao_adm()
    {
        $this->detalharNotificacao('administrador/notificacao/detalhe_notificacao_adm', 'administrador/notificacao/notificacoes_adm');
    }

    // Marca uma notificação como lida.
    public function marcar_lida()
    {
        $this->marcarNotificacaoLida('administrador/notificacao/notificacoes_adm');
    }

    // Permite excluir uma notificação da lista do administrador.
    public function excluir_notificacao_adm()
    {
        $this->excluirNotificacao('administrador/notificacao/excluir_notificacao_adm', 'administrador/notificacao/notificacoes_adm');
    }

    // Páginas simples

    // Direciona o administrador para a página pública "Sobre nós".
    public function sobre_nos_adm()
    {
        Url::redirecionar('paginas/sobre_nos');
    }

    // Exibe a tela de confirmação de saída, sem encerrar a sessão imediatamente.
    public function sair_adm()
    {
        $this->view('paginas/autenticacao/sair');
    }
}
