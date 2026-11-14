
<?php

// Classe responsável por cadastrar, consultar, editar e excluir histórias.
class Historia
{
    private $db;
    private $ultimoId = 0;

    // Cria a conexão com o banco de dados.
    public function __construct()
    {
        $this->db = new Database();
    }

    // Consulta a quantidade total de histórias cadastradas.
    public function totalCadastradas()
    {
        $this->db->query("SELECT fc_total_historias_cadastradas() AS total");
        $resultado = $this->db->resultado();
        return $resultado ? (int) $resultado->total : 0;
    }

    // Cadastra uma história e seus conteúdos nos diferentes idiomas.
    public function cadastrar($imagem, $categoria, $pessoa, $idiomas)
    {
        try {
            // Inicia uma transação para garantir que todos os dados sejam salvos juntos.
            $this->db->iniciarTransacao();

            $this->db->query(
                "INSERT INTO historia (hist_imagem, pess_id, cate_id)
                 VALUES (:imagem, :pessoa, :categoria)"
            );

            $this->db->bind(':imagem', $imagem, PDO::PARAM_LOB);
            $this->db->bind(':pessoa', $pessoa, PDO::PARAM_INT);
            $this->db->bind(':categoria', $categoria, PDO::PARAM_INT);
            $this->db->executa();

            // Guarda o código da história que acabou de ser cadastrada.
            $histId = $this->db->ultimoIdInserido();
            $this->ultimoId = (int) $histId;

            // Cadastra o título, a legenda e o texto de cada idioma.
            foreach ($idiomas as $idioma) {
                $this->db->query(
                    "INSERT INTO historia_idioma
                    (hiid_titulo, hiid_legenda_imagem, hiid_texto, hist_id, idio_id)
                    VALUES
                    (:titulo, :legenda, :texto, :historia, :idioma)"
                );

                $this->db->bind(':titulo', $idioma['titulo']);
                $this->db->bind(':legenda', $idioma['legenda']);
                $this->db->bind(':texto', $idioma['texto']);
                $this->db->bind(':historia', (int) $histId, PDO::PARAM_INT);
                $this->db->bind(':idioma', (int) $idioma['id'], PDO::PARAM_INT);

                $this->db->executa();
            }

            // Confirma o cadastro quando todas as informações são salvas.
            $this->db->confirmarTransacao();

            return true;
        } catch (Throwable $erro) {
            // Cancela as alterações caso aconteça algum erro durante o cadastro.
            $this->db->cancelarTransacao();

            error_log('Erro ao cadastrar história: ' . $erro->getMessage());

            return false;
        }
    }

    // $busca (opcional) procura no título em qualquer idioma.

    // Lista todas as histórias cadastradas.
    public function listarTodas($busca = '')
    {
        // Busca as histórias, suas categorias, imagens e títulos nos idiomas disponíveis.
        $this->db->query(
            "SELECT
            h.hist_id AS id,
            hi.hiid_titulo AS titulo,

            (
                SELECT GROUP_CONCAT(
                    hi_busca.hiid_titulo SEPARATOR ' '
                )
                FROM historia_idioma hi_busca
                WHERE hi_busca.hist_id = h.hist_id
            ) AS titulos_busca,

            (
                SELECT hi2.hiid_titulo
                FROM historia_idioma hi2
                WHERE hi2.hist_id = h.hist_id
                AND hi2.idio_id = 2
                LIMIT 1
            ) AS titulo_es,

            (
                SELECT hi3.hiid_titulo
                FROM historia_idioma hi3
                WHERE hi3.hist_id = h.hist_id
                AND hi3.idio_id = 3
                LIMIT 1
            ) AS titulo_wari,

            c.cate_nome AS categoria,
            h.hist_imagem AS imagem

        FROM historia h

        INNER JOIN categoria c
            ON c.cate_id = h.cate_id

        INNER JOIN historia_idioma hi
            ON hi.hist_id = h.hist_id
            AND hi.idio_id = 1

        ORDER BY h.hist_id DESC"
        );

        $historias = $this->db->resultados();

        // Normaliza o texto para ignorar maiúsculas, minúsculas e acentos.
        $normalizar = function ($texto) {

            $texto = trim((string) $texto);

            $texto = mb_strtolower($texto, 'UTF-8');

            $convertido = iconv(
                'UTF-8',
                'ASCII//TRANSLIT//IGNORE',
                $texto
            );

            if ($convertido !== false) {
                $texto = strtolower($convertido);
            }

            return $texto;
        };

        // Prepara o texto digitado para comparar com os títulos.
        $buscaNormalizada = $normalizar($busca);

        // Filtra as histórias usando os títulos disponíveis em todos os idiomas.
        if ($buscaNormalizada !== '') {

            $historias = array_filter(
                $historias,
                function ($historia) use ($buscaNormalizada, $normalizar) {

                    $titulos = $normalizar(
                        $historia->titulos_busca ?? ''
                    );

                    return strpos(
                        $titulos,
                        $buscaNormalizada
                    ) !== false;
                }
            );

            // Reorganiza os índices depois da filtragem.
            $historias = array_values($historias);
        }

        // Converte as imagens para que possam ser exibidas na página.
        foreach ($historias as &$historia) {

            if (!empty($historia->imagem)) {

                $imagem = $historia->imagem;

                // Identifica o formato do arquivo de imagem.
                $informacoes = new finfo(FILEINFO_MIME_TYPE);
                $tipo = $informacoes->buffer($imagem);

                // Permite somente os formatos de imagem definidos.
                $tiposPermitidos = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                if (in_array($tipo, $tiposPermitidos, true)) {

                    // Converte a imagem para Base64 para exibição na página.
                    $historia->imagem =
                        'data:' . $tipo . ';base64,' .
                        base64_encode($imagem);
                } else {
                    $historia->imagem = '';
                }
            } else {
                $historia->imagem = '';
            }
        }

        unset($historia);

        return $historias;
    }

    // Busca uma história pelo seu código e retorna seus conteúdos nos idiomas cadastrados.
    public function buscarPorId($id)
    {
        $this->db->query(
            "SELECT
                h.hist_id AS id,
                h.hist_imagem AS imagem,
                h.cate_id AS categoria_id,
                c.cate_nome AS categoria
            FROM historia h
            INNER JOIN categoria c
                ON c.cate_id = h.cate_id
            WHERE h.hist_id = :id
            LIMIT 1"
        );

        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);

        $historia = $this->db->resultado();

        // Retorna falso caso a história não seja encontrada.
        if (!$historia) {
            return false;
        }

        // Verifica o formato da imagem antes de prepará-la para exibição.
        if (!empty($historia->imagem)) {
            $informacoes = new finfo(FILEINFO_MIME_TYPE);
            $tipo = $informacoes->buffer($historia->imagem);

            $tiposPermitidos = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (in_array($tipo, $tiposPermitidos, true)) {
                $historia->imagem_uri =
                    'data:' . $tipo . ';base64,' .
                    base64_encode($historia->imagem);
            } else {
                $historia->imagem_uri = '';
            }
        } else {
            $historia->imagem_uri = '';
        }

        // Busca os textos e títulos cadastrados para cada idioma da história.
        $this->db->query(
            "SELECT
                idio_id AS idioma_id,
                hiid_titulo AS titulo,
                hiid_legenda_imagem AS legenda,
                hiid_texto AS texto
            FROM historia_idioma
            WHERE hist_id = :id
            ORDER BY idio_id"
        );

        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);

        $idiomas = $this->db->resultados();

        // Organiza os conteúdos usando o código de cada idioma como índice.
        $historia->idiomas = [];

        foreach ($idiomas as $idioma) {
            $historia->idiomas[(int) $idioma->idioma_id] = $idioma;
        }

        return $historia;
    }

    // Salva as alterações feitas em uma história e em seus conteúdos.
    public function salvarEdicao($id, $categoria, $imagem, $idiomas)
    {
        try {
            $this->db->iniciarTransacao();

            // Atualiza a categoria e a imagem quando uma nova imagem é enviada.
            if ($imagem !== null) {
                $this->db->query(
                    "UPDATE historia
                    SET cate_id = :categoria,
                        hist_imagem = :imagem
                    WHERE hist_id = :id"
                );

                $this->db->bind(':categoria', (int) $categoria, PDO::PARAM_INT);
                $this->db->bind(':imagem', $imagem, PDO::PARAM_LOB);
                $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
            } else {
                // Se nenhuma imagem nova for enviada, mantém a imagem atual.
                $this->db->query(
                    "UPDATE historia
                    SET cate_id = :categoria
                    WHERE hist_id = :id"
                );

                $this->db->bind(':categoria', (int) $categoria, PDO::PARAM_INT);
                $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
            }

            $this->db->executa();

            // Verifica se cada idioma já possui um conteúdo cadastrado.
            foreach ($idiomas as $idioma) {
                $this->db->query(
                    "SELECT hist_id
                    FROM historia_idioma
                    WHERE hist_id = :historia
                    AND idio_id = :idioma
                    LIMIT 1"
                );

                $this->db->bind(':historia', (int) $id, PDO::PARAM_INT);
                $this->db->bind(':idioma', (int) $idioma['id'], PDO::PARAM_INT);

                $existe = $this->db->resultado();

                // Atualiza o conteúdo caso ele já exista.
                if ($existe) {
                    $this->db->query(
                        "UPDATE historia_idioma
                        SET hiid_titulo = :titulo,
                            hiid_legenda_imagem = :legenda,
                            hiid_texto = :texto
                        WHERE hist_id = :historia
                        AND idio_id = :idioma"
                    );
                } else {
                    // Cadastra o conteúdo caso ainda não exista para esse idioma.
                    $this->db->query(
                        "INSERT INTO historia_idioma
                        (hiid_titulo, hiid_legenda_imagem, hiid_texto, hist_id, idio_id)
                        VALUES
                        (:titulo, :legenda, :texto, :historia, :idioma)"
                    );
                }

                $this->db->bind(':titulo', $idioma['titulo']);
                $this->db->bind(':legenda', $idioma['legenda']);
                $this->db->bind(':texto', $idioma['texto']);
                $this->db->bind(':historia', (int) $id, PDO::PARAM_INT);
                $this->db->bind(':idioma', (int) $idioma['id'], PDO::PARAM_INT);

                $this->db->executa();
            }

            // Confirma as alterações quando tudo é atualizado corretamente.
            $this->db->confirmarTransacao();

            return true;
        } catch (Throwable $erro) {
            // Desfaz as alterações caso aconteça algum erro durante a edição.
            $this->db->cancelarTransacao();

            error_log('Erro ao editar história: ' . $erro->getMessage());

            return false;
        }
    }

    // Retorna o título da história para uso nas notificações.
    public function tituloPorId($id)
    {
        $this->db->query(
            "SELECT hiid_titulo FROM historia_idioma
             WHERE hist_id = :id
             ORDER BY idio_id
             LIMIT 1"
        );
        $this->db->bind(':id', (int) $id, PDO::PARAM_INT);
        $linha = $this->db->resultado();
        return $linha ? $linha->hiid_titulo : '';
    }

    // Retorna o código da última história cadastrada.
    public function ultimoIdCadastrado()
    {
        return $this->ultimoId;
    }

    // Exclui a história e seus comentários, avaliações, traduções e vínculos de notificações.
    public function excluir($id)
    {
        $id = (int) $id;

        // Impede a exclusão caso o código informado seja inválido.
        if ($id < 1) {
            return false;
        }

        try {
            $this->db->iniciarTransacao();

            // Confirma que a história existe antes de iniciar a remoção.
            $this->db->query(
                "SELECT hist_id FROM historia WHERE hist_id = :id LIMIT 1"
            );
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $historia = $this->db->resultado();

            if (!$historia) {
                $this->db->confirmarTransacao();
                error_log('Exclusão de história cancelada: ID inexistente ' . $id);
                return false;
            }

            // Remove os comentários e as avaliações relacionados à história.
            $this->db->query("DELETE FROM comentario WHERE hist_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();

            $this->db->query("DELETE FROM avaliacao WHERE hist_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();

            // Busca as notificações vinculadas à história.
            $this->db->query(
                "SELECT noti_id FROM historia_notificacao WHERE hist_id = :id"
            );
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $notificacoes = $this->db->resultados();

            foreach ($notificacoes as $notificacao) {
                $notiId = (int) $notificacao->noti_id;

                // Remove o vínculo entre a história e a notificação.
                $this->db->query(
                    "DELETE FROM historia_notificacao WHERE hist_id = :id AND noti_id = :noti_id"
                );
                $this->db->bind(':id', $id, PDO::PARAM_INT);
                $this->db->bind(':noti_id', $notiId, PDO::PARAM_INT);
                $this->db->executa();

                // Verifica se a notificação ainda está ligada a outra história.
                $this->db->query(
                    "SELECT noti_id FROM historia_notificacao WHERE noti_id = :noti_id LIMIT 1"
                );
                $this->db->bind(':noti_id', $notiId, PDO::PARAM_INT);
                $aindaVinculada = $this->db->resultado();

                // Exclui a notificação somente se ela não estiver mais vinculada a nenhuma história.
                if (!$aindaVinculada) {
                    $this->db->query(
                        "DELETE FROM pessoa_notificacao WHERE noti_id = :noti_id"
                    );
                    $this->db->bind(':noti_id', $notiId, PDO::PARAM_INT);
                    $this->db->executa();

                    $this->db->query(
                        "DELETE FROM notificacao WHERE noti_id = :noti_id"
                    );
                    $this->db->bind(':noti_id', $notiId, PDO::PARAM_INT);
                    $this->db->executa();
                }
            }

            // Remove os conteúdos cadastrados nos diferentes idiomas.
            $this->db->query("DELETE FROM historia_idioma WHERE hist_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();

            // Por último, exclui o registro principal da história.
            $this->db->query("DELETE FROM historia WHERE hist_id = :id");
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->executa();
            $excluida = $this->db->totalResultados() > 0;

            // Gera um erro caso nenhuma história tenha sido excluída.
            if (!$excluida) {
                throw new RuntimeException('A exclusão não removeu nenhuma linha da tabela historia. ID: ' . $id);
            }

            // Confirma a exclusão de todos os registros relacionados.
            $this->db->confirmarTransacao();
            return true;
        } catch (Throwable $erro) {
            // Desfaz todas as exclusões caso aconteça algum erro.
            $this->db->cancelarTransacao();
            error_log('Erro ao excluir história ID ' . $id . ': ' . $erro->getMessage());
            return false;
        }
    }
}
