<?php
class Database{
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $banco = "bd_historias";
    private $porta = "3306"; //verificar a porta do seu banco
    private $dbh;
    private $stmt;

    public function __construct(){
        //fonte de dados ou DNS  que contém as informações para conectar ao banco de dados.
        $dns = 'mysql:host='.$this->host.';port='.$this->porta.';dbname='.$this->banco;
        
        $opcoes = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false
        ];
        try{
            //cria a instacia do PDO
            $this->dbh = new PDO($dns, $this->usuario, $this->senha, $opcoes);
        } catch (Throwable $erro) {

            error_log(
                'Erro original ao cadastrar história: ' .
                $erro->getMessage()
            );

            try {
                $this->dbh->cancelarTransacao();
            } catch (Throwable $erroTransacao) {
                error_log(
                    'Erro ao desfazer a transação: ' .
                    $erroTransacao->getMessage()
                );
            }

            return false;
        }//fim do catch
    }//fim do método construtor

    // prepara o statement com query
    public function query($sql){
        //prepara a consulta sql
        $this->stmt= $this->dbh->prepare($sql);
    }//fim da função query
    //vincula um valor a um parâmetro
    public function bind($parametro, $valor, $tipo= null){
        if(is_null($tipo)):
            switch(true):
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                    break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                    break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                    break;
                default:
                    $tipo = PDO::PARAM_STR;
            endswitch;
        endif;
        $this->stmt->bindValue($parametro, $valor, $tipo);
    }//fim da função bind

       public function executa(){
        return $this->stmt->execute();
    }//fim da função executa

    //obtem um único registro
    public function resultado(){
        $this->executa();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }//fim da função resultados

    //obtem um conjunto de registros
    public function resultados(){
        $this->executa();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }//fim da função resultados

    //retorna o número de linhas afetadas pela última instrução SQL
    public function totalResultados(){
        return $this->stmt->rowCount();
    }//fim da função totalResultados
   
    //retorna o último id inserido no banco de dados
    public function ultimoIdInserido(){
        return $this->dbh->lastInsertId();
    }//fim da função ultimoIdInserido

    public function iniciarTransacao()
    {
        $this->dbh->beginTransaction();
    }

    public function confirmarTransacao()
    {
        if ($this->dbh->inTransaction()) {
            $this->dbh->commit();
        }
    }

    public function cancelarTransacao()
    {
        if ($this->dbh->inTransaction()) {
            $this->dbh->rollBack();
        }
    }

}//fim da classe Database