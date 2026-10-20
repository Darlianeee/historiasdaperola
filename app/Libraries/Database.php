<?php
class Database {
    private PDO $dbh;
    private PDOStatement $stmt;
    public function __construct() {
        try {
            $this->dbh = new PDO(sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST') ?: '127.0.0.1', getenv('DB_PORT') ?: '3306', getenv('DB_NAME') ?: 'bd_historias'), getenv('DB_USER') ?: 'root', getenv('DB_PASSWORD') ?: '', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ, PDO::ATTR_EMULATE_PREPARES=>false]);
        } catch (PDOException $e) { error_log('Conexão de banco falhou: '.$e->getMessage()); throw new RuntimeException('Banco indisponível. Verifique o XAMPP e a configuração.'); }
    }
    public function query($sql) { $this->stmt = $this->dbh->prepare($sql); }
    public function bind($p,$v,$tipo=null) { $tipo ??= (is_int($v) ? PDO::PARAM_INT : (is_null($v) ? PDO::PARAM_NULL : PDO::PARAM_STR)); $this->stmt->bindValue($p,$v,$tipo); }
    public function executa() { return $this->stmt->execute(); }
    public function resultado() { $this->executa(); return $this->stmt->fetch(); }
    public function resultados() { $this->executa(); return $this->stmt->fetchAll(); }
    public function totalResultados() { return $this->stmt->rowCount(); }
    public function ultimoIdInserido() { return $this->dbh->lastInsertId(); }
    public function iniciarTransacao() { $this->dbh->beginTransaction(); }
    public function confirmarTransacao() { if($this->dbh->inTransaction()) $this->dbh->commit(); }
    public function cancelarTransacao() { if($this->dbh->inTransaction()) $this->dbh->rollBack(); }
}
