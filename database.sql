-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/04/2026 às 21:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestao_escolar`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ano` int(11) NOT NULL,
  `turma` varchar(5) NOT NULL,
  `turno` enum('Matutino','Vespertino') NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `ano`, `turma`, `turno`, `data_cadastro`) VALUES
(1, 'Akylis Oliveira Jos?', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(2, 'Antonio Kalebe Cardoso Parente', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(3, 'Arthur Pereira Santos', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(4, 'Elloah Santos Flores', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(5, 'Eloisa Araujo Silva', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(6, 'Emanuella Sousa Pinto', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(7, 'Emanuelly da Silva Rodrigues', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(8, 'Emanuelly Silva Brito', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(9, 'Eryane Rodrigues Cardoso', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(10, 'Hadassa Louise Pereira Alves', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(11, 'Haylla Jullyana da Silva e Silva', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(12, 'Isac Bezerra da Silva', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(13, 'Jo?o Guilherme De Souza Bonzon', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(14, 'Jo?o Rafael Soares Bastos', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(15, 'Jos? Rafael Nascimento de Oliveira Gomes', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(16, 'J?lia Tavares Pereira', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(17, 'Luyz Ghael Barbosa Sales', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(18, 'Luiz Felipe de Sousa da Silva Lima', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(19, 'Maria Clara da Silva Sousa', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(20, 'Maria Eurides Silva de Sousa', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(21, 'Maria Laura Gomes Campelo', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(22, 'Matheus Vale Rodrigues', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(23, 'Melynda da Costa Barros', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(24, 'Nicolas Gabriel Mota Barros', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(25, 'Pedro Antonio de Jesus Prado', 3, 'A', 'Matutino', '2026-04-05 18:41:38'),
(26, 'Wellington Rafael Sousa Ferreira', 3, 'A', 'Matutino', '2026-04-05 18:41:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `oficinas`
--

CREATE TABLE `oficinas` (
  `id` int(11) NOT NULL,
  `nome_oficina` varchar(50) DEFAULT 'Informática/Robótica',
  `aluno_id` int(11) DEFAULT NULL,
  `dia_semana` varchar(20) DEFAULT NULL,
  `bloco` varchar(10) DEFAULT NULL,
  `turno` enum('Matutino','Vespertino') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `oficinas`
--

INSERT INTO `oficinas` (`id`, `nome_oficina`, `aluno_id`, `dia_semana`, `bloco`, `turno`) VALUES
(1, 'Informática', 1, 'Segunda, Quarta', 'Bloco 2', 'Vespertino'),
(2, 'Informática', 2, 'Segunda, Quarta', 'Bloco 2', 'Vespertino'),
(3, 'Informática', 3, 'Segunda, Quarta', 'Bloco 2', 'Vespertino'),
(4, 'Informática', 4, 'Segunda, Quarta', 'Bloco 2', 'Vespertino');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `oficinas`
--
ALTER TABLE `oficinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_id` (`aluno_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `oficinas`
--
ALTER TABLE `oficinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `oficinas`
--
ALTER TABLE `oficinas`
  ADD CONSTRAINT `oficinas_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
