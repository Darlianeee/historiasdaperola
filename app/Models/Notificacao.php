<?php
class Notificacao {
 private Database $db;
 public function __construct(){$this->db=new Database();}
 public function listar(int $pessoa):array {$this->db->query('SELECT n.noti_id,n.noti_titulo,n.noti_mensagem,n.noti_data_hora,p.peno_lida FROM pessoa_notificacao p JOIN notificacao n ON n.noti_id=p.noti_id WHERE p.pess_id=:id ORDER BY n.noti_data_hora DESC');$this->db->bind(':id',$pessoa);return $this->db->resultados();}
 public function ler(int $pessoa,int $notificacao):void {$this->db->query('UPDATE pessoa_notificacao SET peno_lida=1 WHERE pess_id=:p AND noti_id=:n');$this->db->bind(':p',$pessoa);$this->db->bind(':n',$notificacao);$this->db->executa();}
}
