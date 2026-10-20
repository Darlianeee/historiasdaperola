<?php

class Usuarios extends Controller {

    public function login_user() {
        $this->view('usuarios/login_user');
    }

    public function cadastro_user() {
      if($_SERVER['REQUEST_METHOD']==='POST') {
        Seguranca::validar();$nome=trim($_POST['nome']??'');$email=strtolower(trim($_POST['email']??''));$senha=(string)($_POST['senha']??'');
        if(strlen($nome)<2 || strlen($nome)>100 || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($senha)<8) Seguranca::erro('Preencha nome, e-mail e senha (mínimo 8 caracteres).');
        $m=$this->model('Pessoa');if($m->porEmail($email))Seguranca::erro('E-mail já cadastrado.');
        try{$m->cadastrar($nome,$email,$senha);}catch(Throwable $e){error_log($e->getMessage());Seguranca::erro('Não foi possível concluir o cadastro.');}
        header('Location: '.URL.'/usuarios/login_user');exit;
      }$this->view('usuarios/cadastro_user');
    }



    public function menu_user() {
        $this->view('usuarios/menu_user');
    }

    public function notificacoes_user() {
      $m=$this->model('Notificacao');$id=Seguranca::usuario();
      if($_SERVER['REQUEST_METHOD']==='POST'){Seguranca::validar();$m->ler($id,(int)($_POST['notificacao']??0));header('Location: '.URL.'/usuarios/notificacoes_user');exit;}
      $this->view('usuarios/notificacoes_user',['notificacoes'=>$m->listar($id)]);
    }

public function inicio_user() {
        $this->view('usuarios/inicio_user');
    }

public function detalhes_notificacao_user() {
        $this->view('usuarios/detalhes_notificacao_user');
    }

    public function excluir_notificacao_user() {
        $this->view('usuarios/excluir_notificacao_user');
    }

    public function sobre_nos_user() {
        $this->view('usuarios/sobre_nos_user');
    }

    public function sair_user() {
        $this->view('usuarios/sair_user');
    }

    public function footer_user() {
        $this->view('usuarios/footer_user');
    }
    public function login() {
        if($_SERVER['REQUEST_METHOD']!=='POST') {header('Location: '.URL.'/usuarios/login_user');exit;}
        Seguranca::validar(); $email=strtolower(trim($_POST['email']??''));$senha=(string)($_POST['senha']??'');
        $p=$this->model('Pessoa')->porEmail($email);
        if(!$p || $p->pess_status!=='Ativo' || !password_verify($senha,$p->pess_senha) || (int)$p->perf_id!==2) Seguranca::erro('E-mail ou senha incorretos.');
        Seguranca::iniciar();session_regenerate_id(true);$_SESSION['pess_id']=(int)$p->pess_id;$_SESSION['perf_id']=2;
        header('Location: '.URL.'/usuarios/inicio_user');exit;
    }
    public function logout() {Seguranca::iniciar();$_SESSION=[];session_destroy();header('Location: '.URL.'/usuarios/login_user');exit;}
    public function perfil_user() {Seguranca::exigir();$p=$this->model('Pessoa')->porId(Seguranca::usuario());$this->view('usuarios/perfil_user',['pessoa'=>$p]);}
    public function editar_perfil_user() {
       Seguranca::exigir();$m=$this->model('Pessoa');
       if($_SERVER['REQUEST_METHOD']==='POST') {
          Seguranca::validar();$nome=trim($_POST['nome']??'');$email=strtolower(trim($_POST['email']??''));
          if(strlen($nome)<2||!filter_var($email,FILTER_VALIDATE_EMAIL))Seguranca::erro('Nome ou e-mail inválido.');
          $outro=$m->porEmail($email);if($outro&&(int)$outro->pess_id!==Seguranca::usuario())Seguranca::erro('E-mail já cadastrado.');
          $foto=null;
          if(isset($_FILES['fotoPerfil'])&&$_FILES['fotoPerfil']['error']===UPLOAD_ERR_OK){if($_FILES['fotoPerfil']['size']>2*1024*1024)Seguranca::erro('Foto muito grande.');$tipo=(new finfo(FILEINFO_MIME_TYPE))->file($_FILES['fotoPerfil']['tmp_name']);if(!in_array($tipo,['image/jpeg','image/png','image/webp'],true))Seguranca::erro('Formato de foto inválido.');$foto=file_get_contents($_FILES['fotoPerfil']['tmp_name']);}
          try {$m->atualizar(Seguranca::usuario(),$nome,$email,$foto);}catch(Throwable $e){error_log($e->getMessage());Seguranca::erro('Não foi possível salvar os dados.');}
          header('Location: '.URL.'/usuarios/perfil_user');exit;
       }
       $this->view('usuarios/editar_perfil_user',['pessoa'=>$m->porId(Seguranca::usuario())]);
    }
    public function alterar_senha_user() {
      Seguranca::exigir();if($_SERVER['REQUEST_METHOD']==='POST'){
        Seguranca::validar();$m=$this->model('Pessoa');$p=$m->porId(Seguranca::usuario());
        if(!password_verify((string)($_POST['atual']??''),$p->pess_senha))Seguranca::erro('Senha atual incorreta.');
        $nova=(string)($_POST['nova']??'');if(strlen($nova)<8||$nova!==($_POST['confirmacao']??''))Seguranca::erro('Nova senha inválida ou confirmação diferente.');
        $m->senha(Seguranca::usuario(),$nova);header('Location: '.URL.'/usuarios/perfil_user');exit;
      }$this->view('usuarios/alterar_senha_user');
    }
    public function escolher_historia_user() {$historias=$this->model('Historia')->listarTodas();$this->view('usuarios/escolher_historia_user',['historias'=>$historias]);}
    public function historias_user() {
      $id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
      if(!$id)Seguranca::erro('Escolha uma história no catálogo.');
      $h=$this->model('Historia')->buscarPorId($id);if(!$h)Seguranca::erro('História não encontrada.');
      $m=$this->model('Comentario');
      if($_SERVER['REQUEST_METHOD']==='POST'){
        Seguranca::validar();
        if(isset($_POST['excluir_comentario'])){$m->excluir((int)$_POST['excluir_comentario'],Seguranca::usuario(),false);}
        else {$texto=trim($_POST['comentario']??'');if($texto===''||strlen($texto)>1000)Seguranca::erro('Comentário inválido.');$m->criar($id,Seguranca::usuario(),$texto);}
        header('Location: '.URL.'/usuarios/historias_user?id='.$id);exit;
      }
      $lang=$_GET['lang']??'pt';$idioma=['pt'=>1,'es'=>2,'wari'=>3][$lang]??1;$trad=$h->idiomas[$idioma]??$h->idiomas[1]??null;
      $this->view('usuarios/historias_user',['titulo_lenda'=>$trad->titulo??'', 'legenda_imagem'=>$trad->legenda??'', 'texto_lenda'=>$trad->texto??'', 'imagem_historia'=>$h->imagem_uri, 'comentarios'=>$m->listar($id), 'historia_id'=>$id]);
    }
}