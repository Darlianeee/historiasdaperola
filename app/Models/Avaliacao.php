
<?php

// Classe responsável por registrar e consultar as avaliações das histórias.
class Avaliacao
{
    private $db;

    // Cria a conexão com o banco de dados.
    public function __construct()
    {
        $this->db = new Database();
    }

    // Salva a nota da história ou atualiza uma avaliação já existente.
    public function salvar($historiaId, $pessoaId, $nota)
    {
        try {
            // Verifica se a pessoa já avaliou essa história.
            $this->db->query(
                "SELECT avai_id FROM avaliacao WHERE hist_id = :historia AND pess_id = :pessoa LIMIT 1"
            );
            $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
            $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
            $existente = $this->db->resultado();

            // Atualiza a nota quando já existe uma avaliação.
            if ($existente) {
                $this->db->query(
                    "UPDATE avaliacao SET avai_nota = :nota, avai_data_hora = NOW() WHERE avai_id = :id"
                );
                $this->db->bind(':id', (int) $existente->avai_id, PDO::PARAM_INT);
            } else {
                // Registra uma nova avaliação quando a pessoa ainda não avaliou.
                $this->db->query(
                    "INSERT INTO avaliacao (avai_nota, hist_id, pess_id) VALUES (:nota, :historia, :pessoa)"
                );
                $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
                $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
            }

            // Informa a nota que será salva no banco de dados.
            $this->db->bind(':nota', (int) $nota, PDO::PARAM_INT);
            $this->db->executa();
            return true;
        } catch (Throwable $erro) {
            // Registra o erro caso não seja possível salvar a avaliação.
            error_log('Erro ao salvar avaliação: ' . $erro->getMessage());
            return false;
        }
    }

    // Resumo das avaliações da história.

    // Consulta a quantidade de avaliações e a média das notas da história.
    public function resumo($historiaId)
    {
        $this->db->query(
            "SELECT COUNT(*) AS total,
                fc_media_avaliacoes_historia(:historia) AS media
         FROM avaliacao
         WHERE hist_id = :historia_contagem"
        );

        // Informa o ID da história para realizar a consulta.
        $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
        $this->db->bind(':historia_contagem', (int) $historiaId, PDO::PARAM_INT);

        return $this->db->resultado();
    }

    // Consulta a nota que uma pessoa deu para determinada história.
    public function notaDaPessoa($historiaId, $pessoaId)
    {
        $this->db->query(
            "SELECT avai_nota FROM avaliacao WHERE hist_id = :historia AND pess_id = :pessoa LIMIT 1"
        );
        $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
        $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
        $linha = $this->db->resultado();

        // Retorna a nota encontrada ou zero quando não existe avaliação.
        return $linha ? (int) $linha->avai_nota : 0;
    }
}
