-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/10/2026 às 17:04
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_historias`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `avai_id` int(11) NOT NULL,
  `avai_data_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `avai_nota` int(11) DEFAULT NULL,
  `hist_id` int(11) NOT NULL,
  `pess_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Acionadores `avaliacao`
--
DELIMITER $$
CREATE TRIGGER `tg_avaliacao_notificacao_pos_ins` AFTER INSERT ON `avaliacao` FOR EACH ROW BEGIN
    DECLARE vn_noti_id INT DEFAULT NULL;
    DECLARE vn_total INT DEFAULT 0;
    DECLARE vs_perfil VARCHAR(100);
    DECLARE vs_titulo VARCHAR(255);

/*
DATA: 11/10/2026
AUTORA: Darliane Arza de Oliveira
OBJETIVO: Manter uma notificação de avaliações por história e atualizar a quantidade de avaliações recebidas.
*/

    SELECT MAX(pf.perf_nome)
    INTO vs_perfil
    FROM pessoa ps
    INNER JOIN perfil pf ON pf.perf_id = ps.perf_id
    WHERE ps.pess_id = NEW.pess_id;

    IF vs_perfil = "Usuário" THEN

        SELECT COUNT(*)
        INTO vn_total
        FROM avaliacao
        WHERE hist_id = NEW.hist_id;

        SELECT hiid_titulo
        INTO vs_titulo
        FROM historia_idioma
        WHERE hist_id = NEW.hist_id
        ORDER BY idio_id
        LIMIT 1;

        SELECT MAX(n.noti_id)
        INTO vn_noti_id
        FROM notificacao n
        INNER JOIN historia_notificacao hn ON hn.noti_id = n.noti_id
        WHERE hn.hist_id = NEW.hist_id
		AND n.noti_titulo = "Novas avaliações";

        IF vn_noti_id IS NULL THEN

            INSERT INTO notificacao (noti_titulo, noti_mensagem, noti_data_hora)
            VALUES ("Novas avaliações", CONCAT("A história ", vs_titulo," recebeu novas avaliações. Total de avaliações: ",vn_total, "."), NOW());
            SET vn_noti_id = LAST_INSERT_ID();

            INSERT INTO historia_notificacao (hist_id, noti_id, hino_data_hora)
            VALUES (NEW.hist_id, vn_noti_id, NOW());

			INSERT INTO pessoa_notificacao (pess_id, noti_id, peno_lida)
			SELECT ps.pess_id, vn_noti_id, 0
			FROM pessoa ps
			INNER JOIN perfil pf ON pf.perf_id = ps.perf_id
			WHERE pf.perf_nome = "Administrador"
			AND ps.pess_status = "Ativo";
        ELSE
            UPDATE notificacao
            SET noti_mensagem = CONCAT("A história ", vs_titulo, " recebeu novas avaliações. Total de avaliações: ", vn_total, "."), 
				noti_data_hora = NOW()
            WHERE noti_id = vn_noti_id;

            UPDATE pessoa_notificacao pn
            INNER JOIN pessoa ps ON ps.pess_id = pn.pess_id
            INNER JOIN perfil pf ON pf.perf_id = ps.perf_id
            SET pn.peno_lida = 0
			WHERE pn.noti_id = vn_noti_id
			AND pf.perf_nome = "Administrador"
			AND ps.pess_status = "Ativo";
        END IF;
    END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `cate_id` int(11) NOT NULL,
  `cate_nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`cate_id`, `cate_nome`) VALUES
(2, 'Lenda'),
(1, 'Mito');

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentario`
--

CREATE TABLE `comentario` (
  `come_id` int(11) NOT NULL,
  `come_texto` text DEFAULT NULL,
  `come_data_pessoa` timestamp NOT NULL DEFAULT current_timestamp(),
  `pess_id` int(11) NOT NULL,
  `hist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `email`
--

CREATE TABLE `email` (
  `emai_id` int(11) NOT NULL,
  `emai_nome` varchar(200) NOT NULL,
  `pess_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `email`
--

INSERT INTO `email` (`emai_id`, `emai_nome`, `pess_id`) VALUES
(1, 'darlianearza27@gmail.com', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `historia`
--

CREATE TABLE `historia` (
  `hist_id` int(11) NOT NULL,
  `hist_imagem` blob NOT NULL,
  `pess_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historia_idioma`
--

CREATE TABLE `historia_idioma` (
  `hiid_titulo` varchar(100) NOT NULL,
  `hiid_legenda_imagem` varchar(100) NOT NULL,
  `hiid_texto` text NOT NULL,
  `hist_id` int(11) NOT NULL,
  `idio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historia_notificacao`
--

CREATE TABLE `historia_notificacao` (
  `hino_data_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `hist_id` int(11) NOT NULL,
  `noti_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `idioma`
--

CREATE TABLE `idioma` (
  `idio_id` int(11) NOT NULL,
  `idio_nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `idioma`
--

INSERT INTO `idioma` (`idio_id`, `idio_nome`) VALUES
(2, 'Espanhol'),
(1, 'Português'),
(3, 'Wari\'\' Oro Nao');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacao`
--

CREATE TABLE `notificacao` (
  `noti_id` int(11) NOT NULL,
  `noti_mensagem` text NOT NULL,
  `noti_data_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `noti_titulo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `perf_id` int(11) NOT NULL,
  `perf_nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`perf_id`, `perf_nome`) VALUES
(1, 'Administrador'),
(2, 'Usuário');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `pess_id` int(11) NOT NULL,
  `pess_nome` varchar(100) NOT NULL,
  `pess_senha` varchar(200) NOT NULL,
  `pess_foto_perfil` blob DEFAULT NULL,
  `pess_status` enum('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
  `perf_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`pess_id`, `pess_nome`, `pess_senha`, `pess_foto_perfil`, `pess_status`, `perf_id`) VALUES
(2, 'Darliane', '$2y$10$0zp.xUWt00OI.sPVUwIubeZSqCM8FnbRu/XZacsnlSnViu66xIIEm', NULL, 'Ativo', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa_notificacao`
--

CREATE TABLE `pessoa_notificacao` (
  `peno_data_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `pess_id` int(11) NOT NULL,
  `noti_id` int(11) NOT NULL,
  `peno_lida` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_avaliacoes`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_avaliacoes` (
`avai_id` int(11)
,`avai_nota` int(11)
,`avai_data_hora` timestamp
,`pess_id` int(11)
,`pess_nome` varchar(100)
,`hist_id` int(11)
,`hiid_titulo` varchar(100)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_comentarios`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_comentarios` (
`come_id` int(11)
,`come_texto` text
,`come_data_pessoa` timestamp
,`pess_id` int(11)
,`pess_nome` varchar(100)
,`hist_id` int(11)
,`hiid_titulo` varchar(100)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_historias`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_historias` (
`hist_id` int(11)
,`hiid_titulo` varchar(100)
,`hiid_legenda_imagem` varchar(100)
,`hiid_texto` text
,`idio_nome` varchar(50)
,`cate_nome` varchar(50)
,`pess_id` int(11)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_notificacoes`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_notificacoes` (
`pess_id` int(11)
,`noti_id` int(11)
,`noti_titulo` varchar(100)
,`noti_mensagem` text
,`noti_data_hora` timestamp
,`peno_data_hora` timestamp
,`peno_lida` tinyint(4)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_usuarios`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_usuarios` (
`pess_id` int(11)
,`pess_nome` varchar(100)
,`emai_nome` varchar(200)
,`perf_nome` varchar(100)
,`pess_status` enum('Ativo','Inativo')
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_avaliacoes`
--
DROP TABLE IF EXISTS `vw_avaliacoes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `vw_avaliacoes`  AS SELECT `a`.`avai_id` AS `avai_id`, `a`.`avai_nota` AS `avai_nota`, `a`.`avai_data_hora` AS `avai_data_hora`, `p`.`pess_id` AS `pess_id`, `p`.`pess_nome` AS `pess_nome`, `h`.`hist_id` AS `hist_id`, `hi`.`hiid_titulo` AS `hiid_titulo` FROM (((`avaliacao` `a` join `pessoa` `p` on(`a`.`pess_id` = `p`.`pess_id`)) join `historia` `h` on(`a`.`hist_id` = `h`.`hist_id`)) left join `historia_idioma` `hi` on(`h`.`hist_id` = `hi`.`hist_id` and `hi`.`idio_id` = 1)) ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_comentarios`
--
DROP TABLE IF EXISTS `vw_comentarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `vw_comentarios`  AS SELECT `c`.`come_id` AS `come_id`, `c`.`come_texto` AS `come_texto`, `c`.`come_data_pessoa` AS `come_data_pessoa`, `p`.`pess_id` AS `pess_id`, `p`.`pess_nome` AS `pess_nome`, `h`.`hist_id` AS `hist_id`, `hi`.`hiid_titulo` AS `hiid_titulo` FROM (((`comentario` `c` join `pessoa` `p` on(`c`.`pess_id` = `p`.`pess_id`)) join `historia` `h` on(`c`.`hist_id` = `h`.`hist_id`)) left join `historia_idioma` `hi` on(`h`.`hist_id` = `hi`.`hist_id` and `hi`.`idio_id` = 1)) ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_historias`
--
DROP TABLE IF EXISTS `vw_historias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `vw_historias`  AS SELECT `h`.`hist_id` AS `hist_id`, `hi`.`hiid_titulo` AS `hiid_titulo`, `hi`.`hiid_legenda_imagem` AS `hiid_legenda_imagem`, `hi`.`hiid_texto` AS `hiid_texto`, `i`.`idio_nome` AS `idio_nome`, `c`.`cate_nome` AS `cate_nome`, `h`.`pess_id` AS `pess_id` FROM (((`historia` `h` join `historia_idioma` `hi` on(`h`.`hist_id` = `hi`.`hist_id`)) join `idioma` `i` on(`hi`.`idio_id` = `i`.`idio_id`)) join `categoria` `c` on(`h`.`cate_id` = `c`.`cate_id`)) ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_notificacoes`
--
DROP TABLE IF EXISTS `vw_notificacoes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `vw_notificacoes`  AS SELECT `pn`.`pess_id` AS `pess_id`, `n`.`noti_id` AS `noti_id`, `n`.`noti_titulo` AS `noti_titulo`, `n`.`noti_mensagem` AS `noti_mensagem`, `n`.`noti_data_hora` AS `noti_data_hora`, `pn`.`peno_data_hora` AS `peno_data_hora`, `pn`.`peno_lida` AS `peno_lida` FROM (`pessoa_notificacao` `pn` join `notificacao` `n` on(`pn`.`noti_id` = `n`.`noti_id`)) ;

-- --------------------------------------------------------

--
-- Estrutura para view `vw_usuarios`
--
DROP TABLE IF EXISTS `vw_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `vw_usuarios`  AS SELECT `p`.`pess_id` AS `pess_id`, `p`.`pess_nome` AS `pess_nome`, `e`.`emai_nome` AS `emai_nome`, `pf`.`perf_nome` AS `perf_nome`, `p`.`pess_status` AS `pess_status` FROM ((`pessoa` `p` join `perfil` `pf` on(`p`.`perf_id` = `pf`.`perf_id`)) left join `email` `e` on(`p`.`pess_id` = `e`.`pess_id`)) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`avai_id`),
  ADD KEY `ix_avaliacao_historia` (`hist_id`),
  ADD KEY `ix_avaliacao_pessoa` (`pess_id`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`cate_id`),
  ADD KEY `ix_categoria_nome` (`cate_nome`);

--
-- Índices de tabela `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`come_id`),
  ADD KEY `ix_comentario_pessoa` (`pess_id`),
  ADD KEY `ix_comentario_historia` (`hist_id`);

--
-- Índices de tabela `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`emai_id`),
  ADD KEY `ix_email_pessoa` (`pess_id`),
  ADD KEY `ix_email_nome` (`emai_nome`);

--
-- Índices de tabela `historia`
--
ALTER TABLE `historia`
  ADD PRIMARY KEY (`hist_id`),
  ADD KEY `ix_historia_pessoa` (`pess_id`),
  ADD KEY `ix_historia_categoria` (`cate_id`);

--
-- Índices de tabela `historia_idioma`
--
ALTER TABLE `historia_idioma`
  ADD PRIMARY KEY (`hist_id`,`idio_id`),
  ADD KEY `ix_historia_idioma_titulo` (`hiid_titulo`),
  ADD KEY `ix_historia_idioma_idioma` (`idio_id`);

--
-- Índices de tabela `historia_notificacao`
--
ALTER TABLE `historia_notificacao`
  ADD PRIMARY KEY (`hist_id`,`noti_id`),
  ADD KEY `ix_historia_notificacao_notificacao` (`noti_id`);

--
-- Índices de tabela `idioma`
--
ALTER TABLE `idioma`
  ADD PRIMARY KEY (`idio_id`),
  ADD KEY `ix_idioma_nome` (`idio_nome`);

--
-- Índices de tabela `notificacao`
--
ALTER TABLE `notificacao`
  ADD PRIMARY KEY (`noti_id`),
  ADD KEY `ix_notificacao_titulo` (`noti_titulo`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`perf_id`);

--
-- Índices de tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`pess_id`),
  ADD UNIQUE KEY `uq_pess_id` (`pess_id`),
  ADD KEY `ix_pessoa_perfil` (`perf_id`),
  ADD KEY `ix_pessoa_status` (`pess_status`);

--
-- Índices de tabela `pessoa_notificacao`
--
ALTER TABLE `pessoa_notificacao`
  ADD PRIMARY KEY (`pess_id`,`noti_id`),
  ADD KEY `ix_pessoa_notificacao_notificacao` (`noti_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `avai_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `comentario`
--
ALTER TABLE `comentario`
  MODIFY `come_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `email`
--
ALTER TABLE `email`
  MODIFY `emai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `historia`
--
ALTER TABLE `historia`
  MODIFY `hist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacao`
--
ALTER TABLE `notificacao`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `pess_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `fk_avaliacao_historia` FOREIGN KEY (`hist_id`) REFERENCES `historia` (`hist_id`),
  ADD CONSTRAINT `fk_avaliacao_pessoa` FOREIGN KEY (`pess_id`) REFERENCES `pessoa` (`pess_id`);

--
-- Restrições para tabelas `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `fk_comentario_historia` FOREIGN KEY (`hist_id`) REFERENCES `historia` (`hist_id`),
  ADD CONSTRAINT `fk_comentario_pessoa` FOREIGN KEY (`pess_id`) REFERENCES `pessoa` (`pess_id`);

--
-- Restrições para tabelas `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `fk_email_pessoa` FOREIGN KEY (`pess_id`) REFERENCES `pessoa` (`pess_id`);

--
-- Restrições para tabelas `historia`
--
ALTER TABLE `historia`
  ADD CONSTRAINT `fk_historia_categoria` FOREIGN KEY (`cate_id`) REFERENCES `categoria` (`cate_id`),
  ADD CONSTRAINT `fk_historia_pessoa` FOREIGN KEY (`pess_id`) REFERENCES `pessoa` (`pess_id`);

--
-- Restrições para tabelas `historia_idioma`
--
ALTER TABLE `historia_idioma`
  ADD CONSTRAINT `fk_historia_idioma_historia` FOREIGN KEY (`hist_id`) REFERENCES `historia` (`hist_id`),
  ADD CONSTRAINT `fk_historia_idioma_idioma` FOREIGN KEY (`idio_id`) REFERENCES `idioma` (`idio_id`);

--
-- Restrições para tabelas `historia_notificacao`
--
ALTER TABLE `historia_notificacao`
  ADD CONSTRAINT `fk_historia_notificacao_historia` FOREIGN KEY (`hist_id`) REFERENCES `historia` (`hist_id`),
  ADD CONSTRAINT `fk_historia_notificacao_notificacao` FOREIGN KEY (`noti_id`) REFERENCES `notificacao` (`noti_id`);

--
-- Restrições para tabelas `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `fk_pessoa_perfil` FOREIGN KEY (`perf_id`) REFERENCES `perfil` (`perf_id`);

--
-- Restrições para tabelas `pessoa_notificacao`
--
ALTER TABLE `pessoa_notificacao`
  ADD CONSTRAINT `fk_pessoa_notificacao_notificacao` FOREIGN KEY (`noti_id`) REFERENCES `notificacao` (`noti_id`),
  ADD CONSTRAINT `fk_pessoa_notificacao_pessoa` FOREIGN KEY (`pess_id`) REFERENCES `pessoa` (`pess_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
