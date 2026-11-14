
<?php

// Responsável por conectar o sistema ao banco de dados e executar consultas SQL.
class Database
{
    // Guarda o endereço do servidor onde o banco de dados está instalado.
    private $host = "localhost";

    // Informa o usuário utilizado para acessar o banco de dados.
    private $usuario = "root";

    // Guarda a senha do banco de dados.
    private $senha = "";

    // Informa o nome do banco de dados utilizado pelo sistema.
    private $banco = "bd_historia";

    // Define a porta utilizada pelo MySQL.
    private $porta = "3307"; // verificar a porta do seu banco

    // Guarda a conexão com o banco de dados.
    private $dbh;

    // Guarda a consulta SQL que será executada.
    private $stmt;

    // Executa automaticamente quando um objeto da classe é criado.
    public function __construct()
    {
        // Monta as informações necessárias para realizar a conexão com o banco.
        // O charset=utf8mb4 permite salvar e exibir corretamente acentos e caracteres especiais.
        $dns = 'mysql:host=' . $this->host . ';port=' . $this->porta . ';dbname=' . $this->banco . ';charset=utf8mb4';

        // Define algumas opções para controlar a conexão e o retorno das consultas.
        $opcoes = [
            // Faz o PDO informar quando acontecer algum erro durante uma consulta.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            // Faz com que os resultados sejam retornados como objetos.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,

            // Evita manter uma conexão permanente com o banco de dados.
            PDO::ATTR_PERSISTENT => false
        ];

        try {
            // Cria a conexão com o banco de dados utilizando o PDO.
            $this->dbh = new PDO($dns, $this->usuario, $this->senha, $opcoes);

            // Usa no MySQL o mesmo fuso horário do PHP (definido em configuracao.php).
            $this->dbh->exec("SET time_zone = '" . date('P') . "'");
        } catch (Throwable $erro) {
            // Registra o erro no arquivo de log para ajudar a identificar o problema.
            error_log('Erro ao conectar ao banco de dados: ' . $erro->getMessage());

            // Exibe uma mensagem explicando o que deve ser verificado na conexão.
            die('<div style="font-family:sans-serif;max-width:640px;margin:40px auto;padding:20px;' .
                'border:1px solid #e0b4b4;background:#fff6f6;color:#9f3a38;border-radius:8px">' .
                '<strong>Não foi possível conectar ao banco de dados.</strong><br><br>' .
                'Verifique se o MySQL do XAMPP está ligado, se o banco <code>' . $this->banco . '</code> ' .
                'foi importado (arquivo <code>bd/bd_historias.sql</code>) e se usuário, senha e porta ' .
                'em <code>app/Libraries/Database.php</code> estão corretos.</div>');
        } //fim do catch
    } //fim do método construtor

    // Prepara uma consulta SQL para ser executada posteriormente.
    public function query($sql)
    {
        // Prepara o comando SQL utilizando a conexão com o banco.
        $this->stmt = $this->dbh->prepare($sql);
    } //fim da função query

    // Vincula os valores informados aos parâmetros da consulta SQL.
    public function bind($parametro, $valor, $tipo = null)
    {
        // Se o tipo não for informado, identifica automaticamente pelo valor recebido.
        if (is_null($tipo)):
            switch (true):

                // Define o tipo inteiro quando o valor for um número inteiro.
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                    break;

                // Define o tipo booleano quando o valor for verdadeiro ou falso.
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                    break;

                // Define o tipo nulo quando o valor estiver vazio.
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                    break;

                // Utiliza texto como tipo padrão para os demais valores.
                default:
                    $tipo = PDO::PARAM_STR;

            endswitch;
        endif;

        // Associa o valor ao parâmetro correspondente da consulta.
        $this->stmt->bindValue($parametro, $valor, $tipo);
    } //fim da função bind

    // Executa a consulta SQL que foi preparada.
    public function executa()
    {
        return $this->stmt->execute();
    } //fim da função executa

    // Executa a consulta e retorna apenas um registro do banco de dados.
    public function resultado()
    {
        // Executa o comando SQL antes de buscar o resultado.
        $this->executa();

        // Retorna o primeiro registro encontrado como um objeto.
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    } //fim da função resultados

    // Executa a consulta e retorna todos os registros encontrados.
    public function resultados()
    {
        // Executa o comando SQL antes de buscar os registros.
        $this->executa();

        // Retorna todos os resultados como uma lista de objetos.
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    } //fim da função resultados

    // Retorna a quantidade de linhas afetadas pela última consulta.
    public function totalResultados()
    {
        return $this->stmt->rowCount();
    } //fim da função totalResultados

    // Retorna o ID do último registro inserido no banco de dados.
    public function ultimoIdInserido()
    {
        return $this->dbh->lastInsertId();
    } //fim da função ultimoIdInserido

    // Inicia uma transação para executar várias operações no banco como um conjunto.
    public function iniciarTransacao()
    {
        $this->dbh->beginTransaction();
    }

    // Confirma as alterações realizadas durante a transação.
    public function confirmarTransacao()
    {
        // Verifica se existe uma transação em andamento antes de confirmar.
        if ($this->dbh->inTransaction()) {
            $this->dbh->commit();
        }
    }

    // Cancela as alterações realizadas durante a transação.
    public function cancelarTransacao()
    {
        try {
            // Verifica se existe uma transação em andamento antes de cancelar.
            if ($this->dbh->inTransaction()) {
                $this->dbh->rollBack();
            }
        } catch (Throwable $erro) {
            // Registra o erro caso não seja possível cancelar a transação.
            error_log(
                'Erro ao cancelar transação: ' . $erro->getMessage()
            );
        }
    }
}//fim da classe Database
