-- Execute este script uma única vez no banco bd_historia.
CREATE TABLE IF NOT EXISTS recuperacao_senha (
    rsen_id INT AUTO_INCREMENT PRIMARY KEY,
    pess_id INT NOT NULL,
    rsen_token_hash CHAR(64) NOT NULL UNIQUE,
    rsen_expira_em DATETIME NOT NULL,
    rsen_criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_recuperacao_pessoa FOREIGN KEY (pess_id) REFERENCES pessoa(pess_id) ON DELETE CASCADE,
    INDEX idx_recuperacao_pessoa (pess_id),
    INDEX idx_recuperacao_expiracao (rsen_expira_em)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
