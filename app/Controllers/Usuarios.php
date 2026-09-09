<?php

class Usuarios extends Controller {

    public function login_user() {
        $this->view('usuarios/login_user');
    }

    public function cadastro_user() {
        $this->view('usuarios/cadastro_user');
    }

    public function alterar_senha_user() {
        $this->view('usuarios/alterar_senha_user');
    }

    public function editar_perfil_user() {
        $this->view('usuarios/editar_perfil_user');
    }

    public function menu_user() {
        $this->view('usuarios/menu_user');
    }

    public function notificacoes_user() {
        $this->view('usuarios/notificacoes_user');
    }

    public function perfil_user() {
        $this->view('usuarios/perfil_user');
    }

    public function inicio_user() {
        $this->view('usuarios/inicio_user');
    }

    public function historias_user() {
        $this->view('usuarios/historias_user');
    }

    public function escolher_historia_user() {
        $this->view('usuarios/escolher_historia_user');
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
}