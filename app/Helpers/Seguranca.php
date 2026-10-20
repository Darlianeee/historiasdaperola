<?php
class Seguranca {
 public static function iniciar():void {if(session_status()!==PHP_SESSION_ACTIVE) session_start();}
 public static function usuario():int {self::iniciar();return (int)($_SESSION['pess_id']??0);}
 public static function admin():bool {self::iniciar();return (int)($_SESSION['perf_id']??0)===1;}
 public static function token():string {self::iniciar();return $_SESSION['csrf']??=bin2hex(random_bytes(32));}
 public static function validar():void {self::iniciar();if(!hash_equals(self::token(),(string)($_POST['csrf']??''))) {http_response_code(419);exit('Formulário expirado. Recarregue a página.');}}
 public static function exigir(bool $admin=false):void {if(!self::usuario()||($admin&&!self::admin())){header('Location: '.URL.($admin?'/administrador/login_adm':'/usuarios/login_user'));exit;}}
 public static function erro(string $mensagem):void {http_response_code(400);echo '<meta charset="utf-8"><p>'.htmlspecialchars($mensagem,ENT_QUOTES,'UTF-8').'</p><p><a href="javascript:history.back()">Voltar</a></p>';exit;}
}
