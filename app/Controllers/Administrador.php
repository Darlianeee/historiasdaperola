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

    public function perfil_adm() {
        $this->view('administrador/perfil_adm');
    }

    public function gerenciar_historia_adm() {
        $this->view('administrador/gerenciar_historia_adm');
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