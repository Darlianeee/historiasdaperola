
<?php

// Classe responsável por criar, enviar, consultar e remover notificações.
class Notificacao
{
    private $db;

    // Cria a conexão com o banco de dados.
    public function __construct()
    {
        $this->db = new Database();
    }

    // Cria uma notificação e, se informado, faz o vínculo com uma história.
    // Retorna o código da notificação criada.
    private function criar($titulo, $mensagem, $historiaId = null)
    {
        $this->db->query(
            "INSERT INTO notificacao (noti_titulo, noti_mensagem) VALUES (:titulo, :mensagem)"
        );
        $this->db->bind(':titulo', mb_substr($titulo, 0, 100, 'UTF-8'));
        $this->db->bind(':mensagem', $mensagem);
        $this->db->executa();

        // Recupera o código da notificação recém-cadastrada.
        $notificacaoId = (int) $this->db->ultimoIdInserido();

        // Vincula a notificação à história, caso tenha sido informada.
        if ($historiaId) {
            $this->db->query(
                "INSERT INTO historia_notificacao (hist_id, noti_id) VALUES (:historia, :noti)"
            );
            $this->db->bind(':historia', (int) $historiaId, PDO::PARAM_INT);
            $this->db->bind(':noti', $notificacaoId, PDO::PARAM_INT);
            $this->db->executa();
        }

        return $notificacaoId;
    }

    // Envia uma notificação para todas as pessoas ativas de um perfil.
    // $excetoPessoaId permite deixar uma pessoa de fora do envio.
    public function enviarParaPerfil($perfilId, $titulo, $mensagem, $historiaId = null, $excetoPessoaId = 0)
    {
        try {
            // Cria a notificação antes de relacioná-la às pessoas.
            $notificacaoId = $this->criar($titulo, $mensagem, $historiaId);

            $this->db->query(
                "INSERT INTO pessoa_notificacao (pess_id, noti_id, peno_lida)
                 SELECT pess_id, :noti, 0
                 FROM pessoa
                 WHERE perf_id = :perfil
                 AND pess_status = 'Ativo'
                 AND pess_id <> :exceto"
            );
            $this->db->bind(':noti', $notificacaoId, PDO::PARAM_INT);
            $this->db->bind(':perfil', (int) $perfilId, PDO::PARAM_INT);
            $this->db->bind(':exceto', (int) $excetoPessoaId, PDO::PARAM_INT);
            $this->db->executa();

            return true;
        } catch (Throwable $erro) {
            // Registra o erro caso não seja possível enviar a notificação.
            error_log('Erro ao enviar notificação: ' . $erro->getMessage());
            return false;
        }
    }

    // Envia uma notificação para uma pessoa específica.
    public function enviarParaPessoa($pessoaId, $titulo, $mensagem, $historiaId = null)
    {
        try {
            // Cria a notificação e guarda seu código.
            $notificacaoId = $this->criar($titulo, $mensagem, $historiaId);

            // Relaciona a notificação à pessoa que deverá recebê-la.
            $this->db->query(
                "INSERT INTO pessoa_notificacao (pess_id, noti_id, peno_lida) VALUES (:pessoa, :noti, 0)"
            );
            $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
            $this->db->bind(':noti', $notificacaoId, PDO::PARAM_INT);
            $this->db->executa();

            return true;
        } catch (Throwable $erro) {
            // Registra o erro caso não seja possível enviar a notificação.
            error_log('Erro ao enviar notificação: ' . $erro->getMessage());
            return false;
        }
    }

    // Lista as notificações de uma pessoa com filtros opcionais.
    // $filtro: todas | nao_lidas | lidas ; $data: AAAA-MM-DD
    public function listar($pessoaId, $filtro = 'todas', $busca = '', $data = '')
    {
        // Busca somente as notificações relacionadas à pessoa informada.
        $sql = "SELECT noti_id, noti_titulo, noti_mensagem, noti_data_hora, peno_lida
                FROM vw_notificacoes
                WHERE pess_id = :pessoa";

        // Aplica o filtro de acordo com o estado de leitura das notificações.
        if ($filtro === 'nao_lidas') {
            $sql .= " AND peno_lida = 0";
        } elseif ($filtro === 'lidas') {
            $sql .= " AND peno_lida = 1";
        }

        // Adiciona a busca pelo título ou pela mensagem.
        if ($busca !== '') {
            $sql .= " AND (noti_titulo LIKE :busca1 OR noti_mensagem LIKE :busca2)";
        }

        // Filtra as notificações pela data informada.
        if ($data !== '') {
            $sql .= " AND DATE(noti_data_hora) = :data";
        }

        // Organiza as notificações das mais recentes para as mais antigas.
        $sql .= " ORDER BY noti_data_hora DESC, noti_id DESC";

        $this->db->query($sql);
        $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);

        // Preenche os parâmetros da busca, quando informados.
        if ($busca !== '') {
            $this->db->bind(':busca1', '%' . $busca . '%');
            $this->db->bind(':busca2', '%' . $busca . '%');
        }

        if ($data !== '') {
            $this->db->bind(':data', $data);
        }

        return $this->db->resultados();
    }

    // Busca uma notificação específica da pessoa e verifica se ela está ligada a uma história.
    public function buscar($pessoaId, $notificacaoId)
    {
        $this->db->query(
            "SELECT vn.noti_id, vn.noti_titulo, vn.noti_mensagem, vn.noti_data_hora,
                    vn.peno_lida, hn.hist_id
             FROM vw_notificacoes vn
             LEFT JOIN historia_notificacao hn ON hn.noti_id = vn.noti_id
             WHERE vn.pess_id = :pessoa AND vn.noti_id = :noti
             LIMIT 1"
        );
        $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
        $this->db->bind(':noti', (int) $notificacaoId, PDO::PARAM_INT);
        return $this->db->resultado();
    }

    // Marca uma notificação como lida para a pessoa.
    public function marcarComoLida($pessoaId, $notificacaoId)
    {
        $this->db->query(
            "UPDATE pessoa_notificacao SET peno_lida = 1 WHERE pess_id = :pessoa AND noti_id = :noti"
        );
        $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
        $this->db->bind(':noti', (int) $notificacaoId, PDO::PARAM_INT);
        return $this->db->executa();
    }

    // Remove a notificação da caixa da pessoa.
    // Se nenhuma outra pessoa estiver vinculada a ela, também exclui do banco.
    public function remover($pessoaId, $notificacaoId)
    {
        try {
            // Remove o vínculo entre a pessoa e a notificação.
            $this->db->query(
                "DELETE FROM pessoa_notificacao WHERE pess_id = :pessoa AND noti_id = :noti"
            );
            $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);
            $this->db->bind(':noti', (int) $notificacaoId, PDO::PARAM_INT);
            $this->db->executa();

            // Verifica se o vínculo foi removido.
            $removeu = $this->db->totalResultados() > 0;

            // Exclui a notificação somente se nenhuma pessoa ainda estiver vinculada a ela.
            $this->db->query(
                "DELETE FROM notificacao
                 WHERE noti_id = :noti
                 AND NOT EXISTS (SELECT 1 FROM pessoa_notificacao WHERE noti_id = :noti2)"
            );
            $this->db->bind(':noti', (int) $notificacaoId, PDO::PARAM_INT);
            $this->db->bind(':noti2', (int) $notificacaoId, PDO::PARAM_INT);
            $this->db->executa();

            return $removeu;
        } catch (Throwable $erro) {
            // Registra o erro caso não seja possível remover a notificação.
            error_log('Erro ao remover notificação: ' . $erro->getMessage());
            return false;
        }
    }

    // Conta quantas notificações ainda não foram lidas pela pessoa.
    public function contarNaoLidas($pessoaId)
    {
        $this->db->query(
            "SELECT COUNT(*) AS total
         FROM pessoa_notificacao
         WHERE pess_id = :pessoa
         AND peno_lida = 0"
        );

        $this->db->bind(':pessoa', (int) $pessoaId, PDO::PARAM_INT);

        $resultado = $this->db->resultado();

        return (int) ($resultado->total ?? 0);
    }
}
