<?php
class Pessoa {
    private Database $db;
    public function __construct() { $this->db = new Database(); }
    public function porEmail(string $email) {
        $this->db->query('SELECT p.pess_id, p.pess_nome, p.pess_senha, p.pess_status, p.perf_id, p.pess_foto_perfil, e.emai_nome FROM pessoa p JOIN email e ON e.pess_id=p.pess_id WHERE e.emai_nome=:email LIMIT 1');
        $this->db->bind(':email',$email); return $this->db->resultado();
    }
    public function porId(int $id) {
        $this->db->query('SELECT p.pess_id, p.pess_nome, p.pess_senha, p.pess_status, p.perf_id, p.pess_foto_perfil, e.emai_nome FROM pessoa p LEFT JOIN email e ON e.pess_id=p.pess_id WHERE p.pess_id=:id LIMIT 1');
        $this->db->bind(':id',$id); return $this->db->resultado();
    }
    public function cadastrar(string $nome,string $email,string $senha): int {
        $this->db->iniciarTransacao();
        try {
            $this->db->query("INSERT INTO pessoa (pess_nome,pess_senha,pess_status,perf_id) VALUES (:nome,:senha,'Ativo',2)");
            $this->db->bind(':nome',$nome);$this->db->bind(':senha',password_hash($senha,PASSWORD_DEFAULT));$this->db->executa();
            $id=(int)$this->db->ultimoIdInserido();
            $this->db->query('INSERT INTO email (emai_nome,pess_id) VALUES (:email,:id)');$this->db->bind(':email',$email);$this->db->bind(':id',$id);$this->db->executa();
            $this->db->confirmarTransacao();return $id;
        } catch(Throwable $e) { $this->db->cancelarTransacao();throw $e; }
    }
    public function atualizar(int $id,string $nome,string $email,?string $foto): void {
        $this->db->iniciarTransacao();
        try {
            if($foto!==null) {$this->db->query('UPDATE pessoa SET pess_nome=:nome,pess_foto_perfil=:foto WHERE pess_id=:id');$this->db->bind(':foto',$foto,PDO::PARAM_LOB);}
            else {$this->db->query('UPDATE pessoa SET pess_nome=:nome WHERE pess_id=:id');}
            $this->db->bind(':nome',$nome);$this->db->bind(':id',$id);$this->db->executa();
            $this->db->query('UPDATE email SET emai_nome=:email WHERE pess_id=:id');$this->db->bind(':email',$email);$this->db->bind(':id',$id);$this->db->executa();
            $this->db->confirmarTransacao();
        } catch(Throwable $e) {$this->db->cancelarTransacao();throw $e;}
    }
    public function senha(int $id,string $nova):void { $this->db->query('UPDATE pessoa SET pess_senha=:senha WHERE pess_id=:id');$this->db->bind(':senha',password_hash($nova,PASSWORD_DEFAULT));$this->db->bind(':id',$id);$this->db->executa(); }
    public function listar():array { $this->db->query('SELECT p.pess_id,p.pess_nome,p.pess_status,p.perf_id,e.emai_nome FROM pessoa p LEFT JOIN email e ON e.pess_id=p.pess_id ORDER BY p.pess_nome');return $this->db->resultados(); }
    public function alterarAcesso(int $id,string $status,int $perfil):void {$this->db->query('UPDATE pessoa SET pess_status=:status,perf_id=:perfil WHERE pess_id=:id');$this->db->bind(':status',$status);$this->db->bind(':perfil',$perfil);$this->db->bind(':id',$id);$this->db->executa();}
}
