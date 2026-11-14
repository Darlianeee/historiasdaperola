
<?php

// Classe responsável por cadastrar, consultar e excluir comentários das histórias.
class Comentario
{
    private $db;

    // Cria a conexão com o banco de dados.
    public function __construct()
    {
        $this->db = new Database();
    }

    // Lista os comentários de uma história, mostrando primeiro os mais recentes.
    public function listarPorHistoria($historiaId)
    {
        $this->db->query(
            "SELECT come_id, come_texto, come_data_pessoa, pess_id, pess_nome
             FROM vw_comentarios
             WHERE hist_id = :historia
             ORDER BY come_data_pessoa DESC, come_id DESC"
        );
        $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
        return $this->db->resultados();
    }

    // Busca um comentário pelo seu código.
    public function buscarPorId($id)
    {
        $this->db->query(
            "SELECT come_id, come_texto, come_data_pessoa, pess_id, pess_nome, hist_id, hiid_titulo
             FROM vw_comentarios
             WHERE come_id = :id
             LIMIT 1"
        );
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->resultado();
    }

    // Consulta a quantidade de comentários de uma história.
    public function totalPorHistoria($historiaId)
    {
        $this->db->query("SELECT fc_total_comentarios_historia(:historia) AS total");
        $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
        $resultado = $this->db->resultado();
        return $resultado ? (int) $resultado->total : 0;
    }

    // Cadastra um novo comentário no banco de dados.
    public function cadastrar($historiaId, $pessoaId, $texto)
    {
        try {
            $this->db->query(
                "INSERT INTO comentario (come_texto, pess_id, hist_id) VALUES (:texto, :pessoa, :historia)"
            );
            $this->db->bind(':texto', $texto);
            $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
            $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
            $this->db->executa();
            return true;
        } catch (Throwable $erro) {
            // Registra o erro caso não seja possível cadastrar o comentário.
            error_log('Erro ao cadastrar comentário: ' . $erro->getMessage());
            return false;
        }
    }

    // Se $pessoaId for informado, só exclui se o comentário for dessa pessoa.
    // $atorId identifica quem executou a exclusão para o gatilho SQL.
    public function excluir($id, $pessoaId = null, $atorId = null)
    {
        // Na exclusão feita pela própria pessoa, ela também é identificada como responsável pela ação.
        // Na exclusão administrativa, o controller informa quem realizou a ação.
        if ($atorId === null && $pessoaId !== null) {
            $atorId = $pessoaId;
        }

        // Informa ao banco quem está realizando a exclusão.
        $this->db->query("SET @user_pess_id = :ator");
        $this->db->bind(':ator', $atorId === null ? null : (int) $atorId, $atorId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $this->db->executa();

        // Monta o comando para excluir o comentário pelo seu código.
        $sql = "DELETE FROM comentario WHERE come_id = :id";

        // Se o código da pessoa for informado, verifica também se ela é a autora do comentário.
        if ($pessoaId !== null) {
            $sql .= " AND pess_id = :pessoa";
        }

        $this->db->query($sql);
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);

        if ($pessoaId !== null) {
            $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
        }

        // Executa a exclusão e verifica se algum comentário foi removido.
        $this->db->executa();
        return $this->db->totalResultados() > 0;
    }
}
