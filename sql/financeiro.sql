-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 12/02/2025 às 04:15
-- Versão do servidor: 8.4.3
-- Versão do PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financeiro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `banco`
--

CREATE TABLE `banco` (
  `id_banco` int NOT NULL,
  `id_usuario` int NOT NULL,
  `banco` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `agencia` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `conta` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `senha` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `banco`
--

INSERT INTO `banco` (`id_banco`, `id_usuario`, `banco`, `agencia`, `conta`, `saldo`, `senha`) VALUES
(1, 1, 'Neom', '655', '543139', 102.53, '123'),
(2, 1, 'Mercado Pago', '1', '2964951634', 54.77, '123'),
(3, 1, 'Pic Pay', '1', '11965328', 0.00, '123'),
(4, 1, 'SumUp', '1', '168407942', 0.00, '111'),
(5, 1, 'Dinheiro', '0', '0', 0.00, '123'),
(18, 1, '99 Pay', '0', '0', 87.17, '2');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartao`
--

CREATE TABLE `cartao` (
  `id_cartao` int NOT NULL,
  `cartao` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `limite` int NOT NULL,
  `fechamento` int NOT NULL,
  `vencimento` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cartao`
--

INSERT INTO `cartao` (`id_cartao`, `cartao`, `limite`, `fechamento`, `vencimento`) VALUES
(1, 'Carrefour', 2300, 6, 15),
(2, 'Digio', 800, 11, 15),
(3, 'Itau Multiplo internacional', 1500, 10, 17),
(4, 'Itau click visa', 1000, 10, 15),
(5, 'Itau click master', 1000, 28, 8),
(6, 'Itau digital', 1000, 28, 21),
(9, 'Mercado livre', 1400, 11, 17),
(10, 'Neom', 3500, 6, 11),
(11, 'banco pan', 3002, 1, 8);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartao_categoria`
--

CREATE TABLE `cartao_categoria` (
  `id_categoria_cartao` int NOT NULL,
  `categoria_cartao` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cartao_categoria`
--

INSERT INTO `cartao_categoria` (`id_categoria_cartao`, `categoria_cartao`) VALUES
(1, 'Ferramentas'),
(2, 'Pc Gamer'),
(3, 'Palio'),
(4, 'Moto'),
(5, 'Clio'),
(6, 'Revenda'),
(7, 'Emprestimo'),
(8, 'Casa'),
(9, 'Saude'),
(10, 'Pessoal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartao_fatura`
--

CREATE TABLE `cartao_fatura` (
  `id_fatura` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_cartao` int NOT NULL,
  `id_categoria` int NOT NULL,
  `item` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `valor_Total` decimal(10,2) NOT NULL,
  `valor_Parcela` decimal(10,2) NOT NULL,
  `numero_Parcelas` int NOT NULL,
  `data_compra` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cartao_fatura`
--

INSERT INTO `cartao_fatura` (`id_fatura`, `id_usuario`, `id_cartao`, `id_categoria`, `item`, `valor_Total`, `valor_Parcela`, `numero_Parcelas`, `data_compra`) VALUES
(10, 1, 2, 7, 'lua', 500.00, 50.00, 10, '2025-02-03'),
(11, 1, 5, 10, 'celular', 1000.00, 100.00, 10, '2025-02-28'),
(12, 1, 1, 8, 'Laterna Esquerda', 50000.00, 5000.00, 10, '2025-02-07'),
(13, 1, 1, 7, 'monito Curvo', 100.00, 50.00, 2, '2025-02-07'),
(14, 1, 1, 8, '11', 111.00, 111.00, 1, '2025-02-07'),
(15, 1, 1, 8, '32323232', 232323.00, 1046.50, 222, '2025-02-07'),
(17, 1, 1, 8, 'remedio11', 111.00, 111.00, 1, '2025-02-07'),
(18, 5, 2, 5, 'maquina de vidro', 1000.00, 100.00, 10, '2025-02-08'),
(19, 1, 1, 8, 'remedio', 11.00, 11.00, 1, '2025-02-09'),
(20, 1, 1, 8, 'monitor', 222.00, 111.00, 2, '2025-02-09'),
(21, 1, 1, 8, 'monitor', 222.00, 111.00, 2, '2025-02-09'),
(22, 4, 9, 5, 'Máquina de vidro', 500.00, 50.00, 10, '2025-02-09'),
(23, 4, 6, 8, 'Célula ', 699.00, 69.90, 10, '2025-02-09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartao_usuario`
--

CREATE TABLE `cartao_usuario` (
  `id_usuario` int NOT NULL,
  `usuario` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `ativo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cartao_usuario`
--

INSERT INTO `cartao_usuario` (`id_usuario`, `usuario`, `ativo`) VALUES
(1, 'Christopher', 1),
(2, 'Larissa', 1),
(4, 'Pai', 1),
(5, 'Bruna', 1),
(6, 'Geraldo', 1),
(7, 'Sueli', 1),
(8, 'Luiz', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesa_categoria`
--

CREATE TABLE `despesa_categoria` (
  `id_categoria` int NOT NULL,
  `categoria` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `despesa_categoria`
--

INSERT INTO `despesa_categoria` (`id_categoria`, `categoria`) VALUES
(1, 'Alimentacao'),
(2, 'Refrigerante'),
(3, 'Gasolina'),
(4, 'Compra'),
(5, 'Copasa'),
(6, 'Cemig'),
(7, 'Leite '),
(8, 'Tim'),
(9, 'Vero'),
(10, 'Corte de cabelo'),
(11, 'Chips'),
(12, 'Pão'),
(13, 'Carne'),
(14, 'Outros'),
(15, 'Chocolate'),
(16, 'Receita'),
(17, 'Biscoito'),
(18, 'Ruffles');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dividas`
--

CREATE TABLE `dividas` (
  `id_divida` int NOT NULL,
  `divida` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_prevista` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dividas`
--

INSERT INTO `dividas` (`id_divida`, `divida`, `valor`, `data_prevista`) VALUES
(1, 'Gastos Mensais', 438.00, '2025-02-05'),
(9, 'Lis', 385.00, '2025-02-11'),
(10, 'Larissa', 300.00, '2025-02-11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `receber`
--

CREATE TABLE `receber` (
  `id_receber` int NOT NULL,
  `devedor` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_prevista` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `receber`
--

INSERT INTO `receber` (`id_receber`, `devedor`, `valor`, `data_prevista`) VALUES
(113, 'Luiz ', 180.00, '2025-02-20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `todo_lista`
--

CREATE TABLE `todo_lista` (
  `id_lista_todo` int NOT NULL,
  `id_categoria` int NOT NULL,
  `itemCategoria` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `dataASerCumprida` date NOT NULL,
  `status` enum('pendente','concluido','atrasado','pausado') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `todo_lista`
--

INSERT INTO `todo_lista` (`id_lista_todo`, `id_categoria`, `itemCategoria`, `dataASerCumprida`, `status`) VALUES
(9, 1, 'marco para porta do banheiro', '2025-02-06', 'pendente'),
(14, 1, 'colocar porta do banheiro', '2025-02-14', 'pendente'),
(17, 2, 'Pintar porta malas', '2025-02-06', 'pendente'),
(19, 1, 'vazamento pia cozinha', '2025-02-08', 'pendente'),
(21, 3, 'procurar cubo magico', '2025-02-08', 'pendente'),
(22, 4, 'Ler 10 paginas por dia', '2025-02-09', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `todo_lista_categoria`
--

CREATE TABLE `todo_lista_categoria` (
  `id_categoria` int NOT NULL,
  `categoria_lista` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `todo_lista_categoria`
--

INSERT INTO `todo_lista_categoria` (`id_categoria`, `categoria_lista`) VALUES
(1, 'Casa'),
(2, 'Palio'),
(3, 'Pessoal'),
(4, 'Rotina');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transacoes`
--

CREATE TABLE `transacoes` (
  `id_transacao` int NOT NULL,
  `id_conta_origem` int NOT NULL,
  `id_conta_destino` int DEFAULT NULL,
  `id_categoria` int NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_transacao` date DEFAULT NULL,
  `local_transacao` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo_transacao` enum('transferencia','despesa','receita','estorno') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `transacoes`
--

INSERT INTO `transacoes` (`id_transacao`, `id_conta_origem`, `id_conta_destino`, `id_categoria`, `valor`, `data_transacao`, `local_transacao`, `tipo_transacao`) VALUES
(1, 2, 1, 0, 20.00, '2025-02-01', NULL, 'transferencia'),
(2, 1, NULL, 12, 4.15, '2025-02-01', 'Padaria', 'despesa'),
(3, 1, NULL, 15, 2.00, '2025-02-01', 'Padaria', 'despesa'),
(4, 1, NULL, 11, 8.00, '2025-02-01', 'Lalade', 'despesa'),
(5, 2, NULL, 2, 12.56, '2025-02-01', 'Epa', 'despesa'),
(7, 2, NULL, 14, 1.18, '2025-02-01', 'Epa', 'despesa'),
(8, 2, NULL, 17, 5.96, '2025-02-01', 'Epa', 'despesa'),
(9, 2, NULL, 15, 6.18, '2025-02-01', 'Epa', 'despesa'),
(10, 5, NULL, 0, 4.00, '2025-02-02', 'Pai', 'receita'),
(11, 1, NULL, 12, 4.20, '2025-02-02', 'padaria', 'despesa'),
(12, 2, 1, 0, 14.12, '2025-02-02', NULL, 'transferencia'),
(13, 5, NULL, 1, 4.00, '2025-02-03', 'TESTE', 'despesa'),
(22, 5, NULL, 0, 4.00, '2025-02-03', ' - ', 'estorno'),
(25, 1, NULL, 12, 3.96, '2025-02-03', 'padaria', 'despesa'),
(26, 1, NULL, 7, 5.50, '2025-02-03', 'Rubinho', 'despesa'),
(31, 1, NULL, 0, 80.00, '2025-02-03', 'Larissa Itau', 'receita'),
(32, 1, NULL, 14, 50.00, '2025-02-03', 'Jonathan / peça palio', 'despesa'),
(33, 1, NULL, 3, 20.00, '2025-02-03', 'Gasolina Palio', 'despesa'),
(34, 1, NULL, 14, 5.93, '2025-02-04', 'padaria / Larissa', 'despesa'),
(35, 5, NULL, 0, 6.00, '2025-02-04', 'Larissa', 'receita'),
(36, 5, NULL, 12, 4.00, '2025-02-04', 'padaria jaquerina', 'despesa'),
(37, 1, NULL, 17, 3.00, '2025-02-04', 'lalade', 'despesa'),
(38, 1, NULL, 0, 10.00, '2025-02-05', 'larissa', 'receita'),
(39, 1, NULL, 0, 10.00, '2025-02-05', ' - ', 'estorno'),
(40, 1, NULL, 2, 7.00, '2025-02-05', 'Lalade', 'despesa'),
(41, 1, NULL, 17, 3.00, '2025-02-05', 'Lalade', 'despesa'),
(42, 5, NULL, 12, 2.00, '2025-02-05', 'padaria jaquerina', 'despesa'),
(43, 18, NULL, 0, 466.51, '2025-02-06', 'Luiz', 'receita'),
(44, 18, NULL, 0, 278.00, '2025-02-06', 'Grace', 'receita'),
(45, 1, NULL, 2, 7.00, '2025-02-06', 'Lalade', 'despesa'),
(46, 18, 1, 0, 50.00, '2025-02-06', NULL, 'transferencia'),
(47, 1, NULL, 2, 12.56, '2025-02-06', 'Epa', 'despesa'),
(48, 1, NULL, 18, 12.80, '2025-02-06', 'Epa', 'despesa'),
(49, 1, NULL, 17, 2.98, '2025-02-06', 'Epa', 'despesa'),
(50, 1, NULL, 15, 2.36, '2025-02-06', 'Epa', 'despesa'),
(51, 1, NULL, 1, 6.98, '2025-02-06', 'Epa', 'despesa'),
(52, 1, NULL, 15, 6.98, '2025-02-06', 'Epa', 'despesa'),
(53, 1, NULL, 12, 2.00, '2025-02-06', 'padaria', 'despesa'),
(63, 18, NULL, 2, 12.56, '2025-02-07', 'Epa', 'despesa'),
(64, 18, NULL, 13, 17.80, '2025-02-07', 'Epa', 'despesa'),
(67, 18, NULL, 17, 5.96, '2025-02-07', 'Epa', 'despesa'),
(68, 18, NULL, 13, 6.80, '2025-02-07', 'Epa', 'despesa'),
(69, 18, NULL, 14, 500.00, '2025-02-08', 'LARISSA', 'despesa'),
(70, 1, NULL, 14, 4.99, '2025-02-07', 'Hamburguer', 'despesa'),
(73, 18, NULL, 0, 100.00, '2025-02-08', 'samuel', 'receita'),
(74, 1, NULL, 12, 4.00, '2025-02-08', 'padaria jaquerina', 'despesa'),
(90, 1, NULL, 12, 4.30, '2025-02-09', 'Padaria', 'despesa'),
(91, 1, NULL, 12, 3.00, '2025-02-09', 'Padaria ', 'despesa'),
(92, 18, NULL, 1, 28.00, '2025-02-09', '2 cachorro quente', 'despesa'),
(95, 18, NULL, 2, 7.00, '2025-02-09', 'Araujo', 'despesa'),
(96, 18, NULL, 18, 9.00, '2025-02-09', 'Araujo', 'despesa'),
(97, 18, NULL, 17, 3.00, '2025-02-09', 'Araujo', 'despesa'),
(98, 18, NULL, 14, 12.90, '2025-02-09', 'Araujo - Livro', 'despesa'),
(99, 18, NULL, 15, 5.75, '2025-02-09', 'Araujo', 'despesa'),
(100, 5, NULL, 0, 1815.00, '2025-02-09', 'Seguro Desemprego', 'receita'),
(101, 5, NULL, 0, 20.00, '2025-02-09', 'Paulinho', 'receita'),
(103, 18, NULL, 14, 26.90, '2025-02-10', 'Torneira tanque fan', 'despesa'),
(104, 18, NULL, 18, 9.00, '2025-02-10', 'Araujo', 'despesa'),
(105, 18, NULL, 17, 2.89, '2025-02-10', 'Araujo', 'despesa'),
(106, 18, NULL, 15, 6.39, '2025-02-10', 'Araujo', 'despesa'),
(107, 18, NULL, 2, 7.29, '2025-02-10', 'Araujo', 'despesa'),
(108, 1, NULL, 12, 3.00, '2025-02-11', 'padaria', 'despesa'),
(109, 1, NULL, 14, 8.00, '2025-02-11', 'engate compressor', 'despesa'),
(110, 1, NULL, 17, 3.00, '2025-02-11', 'Lalade', 'despesa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `usuario` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ativo` enum('1','0') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `senha`, `ativo`) VALUES
(1, 'chris8', '073996', '1');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`id_banco`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `cartao`
--
ALTER TABLE `cartao`
  ADD PRIMARY KEY (`id_cartao`);

--
-- Índices de tabela `cartao_categoria`
--
ALTER TABLE `cartao_categoria`
  ADD PRIMARY KEY (`id_categoria_cartao`);

--
-- Índices de tabela `cartao_fatura`
--
ALTER TABLE `cartao_fatura`
  ADD PRIMARY KEY (`id_fatura`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cartao` (`id_cartao`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices de tabela `cartao_usuario`
--
ALTER TABLE `cartao_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices de tabela `despesa_categoria`
--
ALTER TABLE `despesa_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `dividas`
--
ALTER TABLE `dividas`
  ADD PRIMARY KEY (`id_divida`);

--
-- Índices de tabela `receber`
--
ALTER TABLE `receber`
  ADD PRIMARY KEY (`id_receber`);

--
-- Índices de tabela `todo_lista`
--
ALTER TABLE `todo_lista`
  ADD PRIMARY KEY (`id_lista_todo`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices de tabela `todo_lista_categoria`
--
ALTER TABLE `todo_lista_categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `transacoes`
--
ALTER TABLE `transacoes`
  ADD PRIMARY KEY (`id_transacao`),
  ADD KEY `id_conta_destino` (`id_conta_destino`),
  ADD KEY `id_conta_origem` (`id_conta_origem`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `banco`
--
ALTER TABLE `banco`
  MODIFY `id_banco` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `cartao`
--
ALTER TABLE `cartao`
  MODIFY `id_cartao` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `cartao_categoria`
--
ALTER TABLE `cartao_categoria`
  MODIFY `id_categoria_cartao` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `cartao_fatura`
--
ALTER TABLE `cartao_fatura`
  MODIFY `id_fatura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `cartao_usuario`
--
ALTER TABLE `cartao_usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `despesa_categoria`
--
ALTER TABLE `despesa_categoria`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `dividas`
--
ALTER TABLE `dividas`
  MODIFY `id_divida` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `receber`
--
ALTER TABLE `receber`
  MODIFY `id_receber` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de tabela `todo_lista`
--
ALTER TABLE `todo_lista`
  MODIFY `id_lista_todo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `todo_lista_categoria`
--
ALTER TABLE `todo_lista_categoria`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `transacoes`
--
ALTER TABLE `transacoes`
  MODIFY `id_transacao` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cartao_fatura`
--
ALTER TABLE `cartao_fatura`
  ADD CONSTRAINT `cartao_fatura_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `cartao_usuario` (`id_usuario`),
  ADD CONSTRAINT `cartao_fatura_ibfk_2` FOREIGN KEY (`id_cartao`) REFERENCES `cartao` (`id_cartao`),
  ADD CONSTRAINT `cartao_fatura_ibfk_3` FOREIGN KEY (`id_categoria`) REFERENCES `cartao_categoria` (`id_categoria_cartao`);

--
-- Restrições para tabelas `todo_lista`
--
ALTER TABLE `todo_lista`
  ADD CONSTRAINT `todo_lista_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `todo_lista_categoria` (`id_categoria`);

--
-- Restrições para tabelas `transacoes`
--
ALTER TABLE `transacoes`
  ADD CONSTRAINT `transacoes_ibfk_1` FOREIGN KEY (`id_conta_destino`) REFERENCES `banco` (`id_banco`),
  ADD CONSTRAINT `transacoes_ibfk_2` FOREIGN KEY (`id_conta_origem`) REFERENCES `banco` (`id_banco`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
