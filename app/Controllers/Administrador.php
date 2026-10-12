<?php

class Administrador extends Controller {

    public function login_adm() {
        $this->view('administrador/login_adm');
    }

    public function cadastro_adm() {
        $this->view('administrador/cadastro_adm');
    }

    public function alterar_senha_adm() {
        $this->view('administrador/alterar_senha_adm');
    }

    public function perfil_adm() {
        $this->view('administrador/perfil_adm');
    }

    public function comentarios_adm() {
        $this->view('administrador/comentarios_adm');
    }

    public function editar_historia() {
        $this->view('administrador/editar_historia');
    }

    public function editar_perfil_adm() {
        $this->view('administrador/editar_perfil_adm');
    }

    public function excluir_historia() {
        $this->view('administrador/excluir_historia');
    }

    public function menu_adm() {
        $this->view('administrador/menu_adm');
    }

    public function nova_historia() {
        $this->view('administrador/nova_historia');
    }

   public function salvar_historia(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL . '/administrador/nova_historia');
            exit;
        }

        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_VALIDATE_INT);

        $idiomas = [
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

        if (!$categoria || !in_array($categoria, [1, 2], true)) {
            die('Selecione uma categoria válida.');
        }

        foreach ($idiomas as $idioma) {
            if (
                $idioma['titulo'] === '' ||
                $idioma['legenda'] === '' ||
                $idioma['texto'] === ''
            ) {
                die('Preencha título, legenda e texto nos três idiomas.');
            }
        }

        if (
            !isset($_FILES['imagem']) ||
            $_FILES['imagem']['error'] !== UPLOAD_ERR_OK
        ) {
            die('Selecione uma imagem válida.');
        }

        if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) {
            die('A imagem deve ter no máximo 5 MB.');
        }

        $arquivoTemporario = $_FILES['imagem']['tmp_name'];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $tipoImagem = $finfo->file($arquivoTemporario);

        $tiposPermitidos = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!in_array($tipoImagem, $tiposPermitidos, true)) {
            die('Use uma imagem JPG, PNG ou WEBP.');
        }

        $imagem = file_get_contents($arquivoTemporario);

        if ($imagem === false) {
            die('Não foi possível ler a imagem.');
        }


        $pessoa = 1;

        $historia = $this->model('Historia');

        $cadastroRealizado = $historia->cadastrar(
            $imagem,
            $categoria,
            $pessoa,
            $idiomas
        );

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($cadastroRealizado) {
            $_SESSION['mensagem_sucesso'] =
                'História cadastrada com sucesso!';

            header('Location: ' . URL . '/administrador/gerenciar_historia_adm');
            exit;
        }

        $_SESSION['mensagem_erro'] =
            'Não foi possível cadastrar a história. Verifique os dados e tente novamente.';

        header('Location: ' . URL . '/administrador/nova_historia');
        exit;

    }

    public function gerenciar_historia_adm() {
        $historiaModel = $this->model('Historia');

        $historias = $historiaModel->listarTodas();

        $mensagem = '';

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['mensagem_sucesso'])) {
            $mensagem = $_SESSION['mensagem_sucesso'];
            unset($_SESSION['mensagem_sucesso']);
        }

        $this->view('administrador/gerenciar_historia_adm', [
            'historias' => $historias,
            'mensagem' => $mensagem
        ]);
    }


    public function editar_historia_adm() {
        $this->view('administrador/editar_historia');
    }

    public function excluir_historia_adm() {
        $this->view('administrador/excluir_historia');
    }

    public function notificacoes_adm() {
        $this->view('administrador/notificacoes_adm');
    }

    public function sobre_nos_adm() {
        $this->view('administrador/sobre_nos_adm');
    }

    public function sair_adm() {
        $this->view('administrador/sair_adm');
    }

    public function inicio_adm() {
        $this->view('administrador/inicio_adm');
    }

    public function detalhe_notificacao_adm() {
        $this->view('administrador/detalhe_notificacao_adm');
    }

    public function excluir_notificacao_adm() {
        $this->view('administrador/excluir_notificacao_adm');
    }

    public function excluir_comentario() {
        $this->view('administrador/excluir_comentario');
    }

    public function responder_comentario() {
        $this->view('administrador/responder_comentario');
    }

    public function historias_adm() {
        $this->view('administrador/historias_adm');
    }
}