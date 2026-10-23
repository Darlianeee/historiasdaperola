<?php

class Paginas extends Controller {

    public function index() {
        $this->view('paginas/index');
    }

    public function esqueceu_senha() {
        $this->view('paginas/esqueceu_senha');
    }

    public function configuracoes() {
        $this->view('paginas/configuracoes');
    }

    public function login() {
        $this->view('paginas/login');
    }

    public function cadastro() {
        $this->view('paginas/cadastro');
    }
}