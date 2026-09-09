<?php
class Controller{
    public function model($model){
        require_once APP.'/Models/'.$model.'.php';
        return new $model;
    }

    public function view($view, $dados = []){
        $arquivo = APP.'/Views/'.$view.'.php';
        if(file_exists($arquivo)){
            require_once $arquivo;
        }else{
            die("O arquivo não existe: ".$view);
        }
    }
}
