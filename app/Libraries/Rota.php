<?php
class Rota{
   private $controlador = "Paginas";
   private $metodo = 'index';
   private $parametros = [];

   public function __construct(){
      $url = $this->url() ? $this->url() : [];

      if(isset($url[0]) && file_exists(APP.'/Controllers/'.ucwords($url[0]).'.php')){
         $this->controlador = ucwords($url[0]);
         unset($url[0]);
      }

      require_once APP.'/Controllers/'.$this->controlador.'.php';
      $this->controlador = new $this->controlador;

      if(isset($url[1]) && method_exists($this->controlador, $url[1]) && (new ReflectionMethod($this->controlador, $url[1]))->getDeclaringClass()->getName() === get_class($this->controlador) && (new ReflectionMethod($this->controlador, $url[1]))->isPublic() && $url[1][0] !== '_'){
         $this->metodo = $url[1];
         unset($url[1]);
      }

      $this->parametros = $url ? array_values($url) : [];
      $classe = get_class($this->controlador);
      if ($classe === 'Administrador' && !in_array($this->metodo,['login','login_adm'],true)) Seguranca::exigir(true);
      if ($classe === 'Usuarios' && !in_array($this->metodo,['login','login_user','cadastro_user'],true)) Seguranca::exigir();
      call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
   }

   private function url(){
      $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

      if(isset($url) && $url !== ''){
         $url = trim(rtrim($url, '/'));
         return explode('/', $url);
      }

      return [];
   }
}
?>
