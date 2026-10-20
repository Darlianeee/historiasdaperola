<?php
class Comentario {
 private Database $db;
 public function __construct() {$this->db=new Database();}
 public function listar(int $hist):array { $this->db->query("SELECT c.come_id id,c.come_texto texto,c.pess_id, p.pess_nome nome,DATE_FORMAT(c.come_data_pessoa,'%d/%m/%Y %H:%i') data FROM comentario c JOIN pessoa p ON p.pess_id=c.pess_id WHERE c.hist_id=:id ORDER BY c.come_data_pessoa DESC");$this->db->bind(':id',$hist);return array_map(fn($a)=>(array)$a,$this->db->resultados()); }
 public function criar(int $hist,int $pessoa,string $texto):void {$this->db->query('INSERT INTO comentario (come_texto,pess_id,hist_id) VALUES (:texto,:pess,:hist)');$this->db->bind(':texto',$texto);$this->db->bind(':pess',$pessoa);$this->db->bind(':hist',$hist);$this->db->executa();}
 public function excluir(int $id,int $pessoa,bool $admin):void {$this->db->query('DELETE FROM comentario WHERE come_id=:id'.($admin?'':' AND pess_id=:pess'));$this->db->bind(':id',$id);if(!$admin)$this->db->bind(':pess',$pessoa);$this->db->executa();}
}
