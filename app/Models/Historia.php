<?php

class Historia {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function cadastrar($imagem, $categoria, $pessoa, $idiomas) {
        try {
            $this->db->iniciarTransacao();

            $this->db->query(
                "INSERT INTO historia (hist_imagem, pess_id, cate_id)
                 VALUES (:imagem, :pessoa, :categoria)"
            );

            $this->db->bind(':imagem', $imagem, PDO::PARAM_LOB);
            $this->db->bind(':pessoa', $pessoa, PDO::PARAM_INT);
            $this->db->bind(':categoria', $categoria, PDO::PARAM_INT);
            $this->db->executa();

            $histId = $this->db->ultimoIdInserido();

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

            $this->db->confirmarTransacao();

            return true;
        } catch (Throwable $erro) {
            $this->db->cancelarTransacao();

            error_log('Erro ao cadastrar história: ' . $erro->getMessage());

            return false;
        }
    }

    
        public function listarTodas() {
            $this->db->query(
                "SELECT
                    h.hist_id AS id,
                    hi.hiid_titulo AS titulo,
                    c.cate_nome AS categoria,
                    h.hist_imagem AS imagem
                FROM historia h
                INNER JOIN categoria c
                    ON c.cate_id = h.cate_id
                INNER JOIN historia_idioma hi
                    ON hi.hist_id = h.hist_id
                WHERE hi.idio_id = 1
                ORDER BY h.hist_id DESC"
            );

            $historias = $this->db->resultados();

            foreach ($historias as &$historia) {
                if (!empty($historia->imagem)) {
                    $imagem = $historia->imagem;
                    $informacoes = new finfo(FILEINFO_MIME_TYPE);
                    $tipo = $informacoes->buffer($imagem);

                    $tiposPermitidos = [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ];

                    if (in_array($tipo, $tiposPermitidos, true)) {
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

}