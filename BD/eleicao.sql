-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Out-2022 às 17:40
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `eleicao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_candidatos`
--

CREATE TABLE `tb_candidatos` (
  `td_id` int(10) NOT NULL,
  `td_id_voto` varchar(3) NOT NULL,
  `td_nome` varchar(100) NOT NULL,
  `td_funcao` varchar(100) NOT NULL,
  `td_status` char(1) DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_eleicand`
--

CREATE TABLE `tb_eleicand` (
  `td_id` int(11) NOT NULL,
  `td_candidatosid` varchar(11) NOT NULL,
  `td_eleicaoid` int(11) NOT NULL,
  `td_status` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_eleicao`
--

CREATE TABLE `tb_eleicao` (
  `td_id` int(11) NOT NULL,
  `td_nome` varchar(100) NOT NULL,
  `td_status` char(1) NOT NULL,
  `td_data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_votacao`
--

CREATE TABLE `tb_votacao` (
  `td_id` int(11) NOT NULL,
  `td_candidatos` varchar(3) NOT NULL,
  `td_voto` int(1) NOT NULL DEFAULT 1,
  `td_eleicao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_candidatos`
--
ALTER TABLE `tb_candidatos`
  ADD PRIMARY KEY (`td_id`),
  ADD UNIQUE KEY `td_id_voto` (`td_id_voto`);

--
-- Índices para tabela `tb_eleicand`
--
ALTER TABLE `tb_eleicand`
  ADD PRIMARY KEY (`td_id`);

--
-- Índices para tabela `tb_eleicao`
--
ALTER TABLE `tb_eleicao`
  ADD PRIMARY KEY (`td_id`);

--
-- Índices para tabela `tb_votacao`
--
ALTER TABLE `tb_votacao`
  ADD PRIMARY KEY (`td_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_candidatos`
--
ALTER TABLE `tb_candidatos`
  MODIFY `td_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `tb_eleicand`
--
ALTER TABLE `tb_eleicand`
  MODIFY `td_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `tb_eleicao`
--
ALTER TABLE `tb_eleicao`
  MODIFY `td_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `tb_votacao`
--
ALTER TABLE `tb_votacao`
  MODIFY `td_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
