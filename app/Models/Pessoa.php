
<?php

// Consultas e operações relacionadas às pessoas e seus perfis.
class Pessoa
{
    // Códigos utilizados para identificar os tipos de perfil.
    const PERFIL_ADMINISTRADOR = 1;
    const PERFIL_USUARIO = 2;

    private $db;

    // Cria a conexão com o banco de dados.
    public function __construct()
    {
        $this->db = new Database();
    }

    // Reúne os dados da pessoa, seu perfil e seu e-mail em uma consulta.
    private function selectBase()
    {
        return "SELECT
                    p.pess_id,
                    p.pess_nome,
                    p.pess_senha,
                    p.pess_foto_perfil,
                    p.pess_status,
                    p.perf_id,
                    pf.perf_nome,
                    e.emai_nome
                FROM pessoa p
                INNER JOIN perfil pf ON pf.perf_id = p.perf_id
                LEFT JOIN email e ON e.pess_id = p.pess_id";
    }

    // Busca uma pessoa pelo endereço de e-mail.
    public function buscarPorEmail($email)
    {
        $this->db->query($this->selectBase() . " WHERE e.emai_nome = :email LIMIT 1");
        $this->db->bind(':email', $email);
        return $this->db->resultado();
    }

    // Busca uma pessoa pelo seu código.
    public function buscarPorId($id)
    {
        $this->db->query($this->selectBase() . " WHERE p.pess_id = :id LIMIT 1");
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->resultado();
    }

    // Verifica se o e-mail já está cadastrado para outra pessoa.
    // Permite ignorar o código da pessoa que está sendo editada.
    public function emailExiste($email, $ignorarPessoaId = 0)
    {
        $this->db->query(
            "SELECT emai_id FROM email WHERE emai_nome = :email AND pess_id <> :pessoa LIMIT 1"
        );
        $this->db->bind(':email', $email);
        $this->db->bind(':pessoa', (int) $ignorarPessoaId, PDO::PARAM_INT);
        return (bool) $this->db->resultado();
    }

    // Cadastra uma pessoa e seu e-mail. Retorna o código criado ou false.
    public function cadastrar($nome, $email, $senha, $perfil = self::PERFIL_USUARIO)
    {
        try {
            // Inicia uma transação para salvar os dados juntos.
            $this->db->iniciarTransacao();

            $this->db->query(
                "INSERT INTO pessoa (pess_nome, pess_senha, pess_status, perf_id)
                 VALUES (:nome, :senha, 'Ativo', :perfil)"
            );
            $this->db->bind(':nome', $nome);

            // Criptografa a senha antes de armazená-la no banco.
            $this->db->bind(':senha', password_hash($senha, PASSWORD_DEFAULT));
            $this->db->bind(':perfil', (int) $perfil, PDO::PARAM_INT);
            $this->db->executa();

            // Recupera o código da pessoa recém-cadastrada.
            $pessoaId = (int) $this->db->ultimoIdInserido();

            // Cadastra o e-mail e relaciona com a pessoa.
            $this->db->query("INSERT INTO email (emai_nome, pess_id) VALUES (:email, :pessoa)");
            $this->db->bind(':email', $email);
            $this->db->bind(':pessoa', $pessoaId, PDO::PARAM_INT);
            $this->db->executa();

            // Confirma o cadastro quando todas as informações são salvas.
            $this->db->confirmarTransacao();

            return $pessoaId;
        } catch (Throwable $erro) {
            // Desfaz as alterações caso aconteça algum erro no cadastro.
            $this->db->cancelarTransacao();
            error_log('Erro ao cadastrar pessoa: ' . $erro->getMessage());
            return false;
        }
    }

    // Atualiza o nome e, se uma nova foto for enviada, também atualiza a foto do perfil.
    // O e-mail não é alterado por esse método.
    public function atualizarDados($id, $nome, $foto = null)
    {
        try {
            // Atualiza o nome e a foto quando uma nova imagem é informada.
            if ($foto !== null) {
                $this->db->query(
                    "UPDATE pessoa SET pess_nome = :nome, pess_foto_perfil = :foto WHERE pess_id = :id"
                );
                $this->db->bind(':foto', $foto, PDO::PARAM_LOB);
            } else {
                // Se nenhuma foto for enviada, atualiza somente o nome.
                $this->db->query("UPDATE pessoa SET pess_nome = :nome WHERE pess_id = :id");
            }
            $this->db->bind(':nome', $nome);
            $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
            return $this->db->executa();
        } catch (Throwable $erro) {
            error_log('Erro ao atualizar dados da pessoa: ' . $erro->getMessage());
            return false;
        }
    }

    // Atualiza a senha da pessoa, armazenando seu hash no banco de dados.
    public function atualizarSenha($id, $novaSenha)
    {
        $this->db->query("UPDATE pessoa SET pess_senha = :senha WHERE pess_id = :id");
        $this->db->bind(':senha', password_hash($novaSenha, PASSWORD_DEFAULT));
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->executa();
    }

    // Lista as pessoas cadastradas para a tela "Gerenciar Perfis".
    public function listarTodas()
    {
        // Consulta as tabelas diretamente para não depender de uma view desatualizada.
        $this->db->query(
            "SELECT p.pess_id, p.pess_nome, e.emai_nome,
                    p.perf_id, pf.perf_nome, p.pess_status
             FROM pessoa p
             INNER JOIN perfil pf ON pf.perf_id = p.perf_id
             LEFT JOIN email e ON e.pess_id = p.pess_id
             ORDER BY p.perf_id, p.pess_nome"
        );
        return $this->db->resultados();
    }

    // Lista os perfis disponíveis no sistema.
    public function listarPerfis()
    {
        $this->db->query("SELECT perf_id, perf_nome FROM perfil ORDER BY perf_id");
        return $this->db->resultados();
    }

    // Atualiza o perfil e o status de uma pessoa.
    public function atualizarPerfilEStatus($id, $perfilId, $status)
    {
        $this->db->query(
            "UPDATE pessoa SET perf_id = :perfil, pess_status = :status WHERE pess_id = :id"
        );
        $this->db->bind(':perfil', (int) $perfilId, PDO::PARAM_INT);
        $this->db->bind(':status', $status);
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return $this->db->executa();
    }

    // Conta quantas histórias foram cadastradas por uma pessoa.
    public function totalHistoriasCadastradas($id)
    {
        $this->db->query("SELECT COUNT(*) AS total FROM historia WHERE pess_id = :id");
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        return (int) $this->db->resultado()->total;
    }

    // Conta quantos administradores estão ativos no sistema.
    public function totalAdministradoresAtivos()
    {
        $this->db->query(
            "SELECT COUNT(*) AS total FROM pessoa
             WHERE perf_id = :perfil AND pess_status = 'Ativo'"
        );
        $this->db->bind(':perfil', self::PERFIL_ADMINISTRADOR, PDO::PARAM_INT);
        return (int) $this->db->resultado()->total;
    }

    // Exclui uma pessoa e seus registros relacionados em uma única transação.
    // O controlador impede a exclusão de pessoas que cadastraram histórias
    // e da própria conta do administrador.
    public function excluir($id)
    {
        $id = (int) $id;

        // Impede a exclusão caso o código informado seja inválido.
        if ($id < 1) {
            return false;
        }

        try {
            $this->db->iniciarTransacao();

            // Remove os vínculos da pessoa antes de excluir sua conta.
            $this->db->query("DELETE FROM pessoa_notificacao WHERE pess_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();

            // Exclui os comentários feitos pela pessoa.
            $this->db->query("DELETE FROM comentario WHERE pess_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();

            // Exclui as avaliações feitas pela pessoa.
            $this->db->query("DELETE FROM avaliacao WHERE pess_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();

            // Remove o e-mail relacionado à conta.
            $this->db->query("DELETE FROM email WHERE pess_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();

            // Exclui o registro principal da pessoa.
            $this->db->query("DELETE FROM pessoa WHERE pess_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();
            $excluiu = $this->db->totalResultados() > 0;

            // Cancela a operação caso nenhum registro tenha sido excluído.
            if (!$excluiu) {
                $this->db->cancelarTransacao();
                return false;
            }

            // Confirma a exclusão de todos os registros.
            $this->db->confirmarTransacao();
            return true;
        } catch (Throwable $erro) {
            // Desfaz as alterações caso aconteça algum erro durante a exclusão.
            $this->db->cancelarTransacao();
            error_log('Erro ao excluir pessoa ID ' . $id . ': ' . $erro->getMessage());
            return false;
        }
    }
}
