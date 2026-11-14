
<?php

// Classe responsável por identificar a página e o método que serão acessados.
class Rota
{
   private $controlador = "Paginas";
   private $metodo = 'index';
   private $parametros = [];

   // Identifica o controlador, o método e os parâmetros da URL.
   public function __construct()
   {
      // Obtém as informações da URL ou utiliza uma lista vazia.
      $url = $this->url() ? $this->url() : [];

      // Verifica se o controlador informado existe no sistema.
      if (isset($url[0]) && file_exists(APP.'/Controllers/'.ucwords($url[0]).'.php')) {
         $this->controlador = ucwords($url[0]);
         unset($url[0]);
      }

      // Carrega o controlador e cria seu objeto.
      require_once APP.'/Controllers/'.$this->controlador.'.php';
      $this->controlador = new $this->controlador;

      // Verifica se o método informado existe no controlador.
      if (isset($url[1]) && method_exists($this->controlador, $url[1])) {
         $this->metodo = $url[1];
         unset($url[1]);
      }

      // Organiza os parâmetros restantes da URL.
      $this->parametros = $url ? array_values($url) : [];

      // Executa o método escolhido, passando os parâmetros recebidos.
      call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
   }

   // URL

   // Obtém e organiza o endereço informado pelo usuário.
   private function url()
   {
      $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

      // Remove espaços e barras extras antes de separar o endereço.
      if (isset($url) && $url !== '') {
         $url = trim(rtrim($url, '/'));
         return explode('/', $url);
      }

      // Retorna uma lista vazia quando não existe uma URL informada.
      return [];
   }
}
?>
