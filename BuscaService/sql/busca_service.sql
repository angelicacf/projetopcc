-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Maio-2023 às 18:26
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `busca_service`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `idcli` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(18) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `perfil` varchar(3) NOT NULL DEFAULT 'CLI' COMMENT 'ADM=Administrador\\nPRO=Profissional\\nCLI=Cliente',
  `status` tinyint(1) NOT NULL COMMENT 'Somente "0" ou "1"',
  `dataregcli` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`idcli`, `nome`, `email`, `senha`, `cpf`, `telefone`, `cep`, `estado`, `cidade`, `bairro`, `perfil`, `status`, `dataregcli`) VALUES
(1, 'robosto', 'larb@gamil.com', '123', '234.753.570-87', '', '72220-240', 'DF', 'brasilia', 'ceilandia', 'CLI', 1, '2023-05-12 11:59:22'),
(2, 'rob', 'larb@gail.com', '123', '234.754.570-87', '', '72220-240', 'DF', 'brasilia', 'ceilandia', 'CLI', 0, '2023-05-12 12:00:08'),
(3, 'Henrique', 'baolb@gamil.com', '123', '234.753.570-48', '', '72220-210', 'DF', 'brasilia', 'taguatinga', 'CLI', 0, '2023-05-12 12:42:58'),
(4, 'lukakoooo', 'lukakooo@gmail.com', '202cb962ac59075b964b07152d234b70', '325.456.786-98', '(32)45678-9056', '72220-240', 'DF', 'Brasília', 'Ceilândia Sul (Ceilândia)', 'CLI', 1, '2023-05-12 13:07:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `idpag` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `valor` decimal(9,2) NOT NULL,
  `numero` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `cliente_idcli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profissional`
--

CREATE TABLE `profissional` (
  `idpro` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(18) NOT NULL,
  `telefone2` varchar(18) DEFAULT NULL,
  `cep` varchar(9) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricaonegocio` text NOT NULL,
  `fotoprin` blob NOT NULL,
  `fotosec` blob DEFAULT NULL,
  `fotosec2` blob DEFAULT NULL,
  `perfil` varchar(3) NOT NULL DEFAULT 'PRO' COMMENT 'ADM=Administrador\\nPRO=Profissional\\nCLI=Cliente',
  `status` tinyint(1) NOT NULL COMMENT 'Somente "0" ou "1"',
  `dataregpro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `profissional_has_servico`
--

CREATE TABLE `profissional_has_servico` (
  `profissional_idpro` int(11) NOT NULL,
  `servico_idserv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `idserv` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `categoria` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT 'Somente "0" ou "1"',
  `dataregserv` datetime NOT NULL DEFAULT current_timestamp(),
  `cliente_idcli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcli`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`);

--
-- Índices para tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`idpag`,`cliente_idcli`),
  ADD KEY `fk_pagamento_cliente1_idx` (`cliente_idcli`);

--
-- Índices para tabela `profissional`
--
ALTER TABLE `profissional`
  ADD PRIMARY KEY (`idpro`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`);

--
-- Índices para tabela `profissional_has_servico`
--
ALTER TABLE `profissional_has_servico`
  ADD PRIMARY KEY (`profissional_idpro`,`servico_idserv`),
  ADD KEY `fk_profissional_has_servico_servico1_idx` (`servico_idserv`),
  ADD KEY `fk_profissional_has_servico_profissional1_idx` (`profissional_idpro`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`idserv`,`cliente_idcli`),
  ADD KEY `fk_servico_cliente1_idx` (`cliente_idcli`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `idpag` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `profissional`
--
ALTER TABLE `profissional`
  MODIFY `idpro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `idserv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `fk_pagamento_cliente1` FOREIGN KEY (`cliente_idcli`) REFERENCES `cliente` (`idcli`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `profissional_has_servico`
--
ALTER TABLE `profissional_has_servico`
  ADD CONSTRAINT `fk_profissional_has_servico_profissional1` FOREIGN KEY (`profissional_idpro`) REFERENCES `profissional` (`idpro`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profissional_has_servico_servico1` FOREIGN KEY (`servico_idserv`) REFERENCES `servico` (`idserv`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `servico`
--
ALTER TABLE `servico`
  ADD CONSTRAINT `fk_servico_cliente1` FOREIGN KEY (`cliente_idcli`) REFERENCES `cliente` (`idcli`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
