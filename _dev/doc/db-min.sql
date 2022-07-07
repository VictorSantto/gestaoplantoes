-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01-Jan-1900 às 00:00
-- Versão do servidor: 5.7.31
-- versão do PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `getz`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cores`
--

DROP TABLE IF EXISTS `cores`;
CREATE TABLE IF NOT EXISTS `cores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cor` varchar(80) NOT NULL,
  `hexadecimal` varchar(20) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `tipo_cor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_cor` (`tipo_cor`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cores`
--

INSERT INTO `cores` (`id`, `cor`, `hexadecimal`, `cadastrado`, `modificado`, `tipo_cor`) VALUES
(1, 'gz-red-tag', '#cc2b2b', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1),
(2, 'gz-green-tag', '#00695c', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1),
(3, 'gz-blue-tag', '#0057ff', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1),
(4, 'gz-yellow-tag', '#f4b400', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1),
(5, 'gz-gray-tag', '#eeeeee', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(80) NOT NULL,
  `link` varchar(255) NOT NULL,
  `ordem` int(11) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `tipo_menu` int(11) NOT NULL,
  `situacao_registro` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_menu` (`tipo_menu`),
  KEY `situacao_registro` (`situacao_registro`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `menus`
--

INSERT INTO `menus` (`id`, `menu`, `link`, `ordem`, `cadastrado`, `modificado`, `tipo_menu`, `situacao_registro`) VALUES
(1, 'Barra de menu', '', 0, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1),
(2, 'Cadastros', '', 0, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1),
(3, 'Configurações', '', 0, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1),
(4, 'Subpasta', '', 0, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1),
(5, 'Não aplicável', '', 0, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1),
(6, 'Relatórios', '', 0, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1),
(7, 'Pré-cadastros', '', 0, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu_submenus`
--

DROP TABLE IF EXISTS `menu_submenus`;
CREATE TABLE IF NOT EXISTS `menu_submenus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_submenu` varchar(80) NOT NULL,
  `link` varchar(255) NOT NULL,
  `ordem` int(11) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `menu` int(11) NOT NULL,
  `situacao_registro` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu` (`menu`),
  KEY `situacao_registro` (`situacao_registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_tela`
--

DROP TABLE IF EXISTS `perfil_tela`;
CREATE TABLE IF NOT EXISTS `perfil_tela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `perfil` int(11) NOT NULL,
  `tela` int(11) NOT NULL,
  `tipo_permissao` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `perfil` (`perfil`),
  KEY `tela` (`tela`),
  KEY `permissao` (`tipo_permissao`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `perfil_tela`
--

INSERT INTO `perfil_tela` (`id`, `cadastrado`, `modificado`, `perfil`, `tela`, `tipo_permissao`) VALUES
(1, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1, 4),
(2, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 2, 4),
(3, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 3, 4),
(4, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 4, 4),
(5, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 5, 4),
(6, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 6, 4),
(7, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 7, 4),
(8, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 8, 4),
(9, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 9, 4),
(10, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 10, 4),
(11, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 11, 4),
(12, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 12, 4),
(13, '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 13, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfis`
--

DROP TABLE IF EXISTS `perfis`;
CREATE TABLE IF NOT EXISTS `perfis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(80) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `perfis`
--

INSERT INTO `perfis` (`id`, `perfil`, `cadastrado`, `modificado`) VALUES
(1, 'Developer', '1900-01-01 00:00:00', '1900-01-01 00:00:00'),
(2, 'User', '1900-01-01 00:00:00', '1900-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacoes_registros`
--

DROP TABLE IF EXISTS `situacoes_registros`;
CREATE TABLE IF NOT EXISTS `situacoes_registros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `situacao_registro` varchar(80) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `cor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cor` (`cor`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `situacoes_registros`
--

INSERT INTO `situacoes_registros` (`id`, `situacao_registro`, `cadastrado`, `modificado`, `cor`) VALUES
(1, 'Ativo', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 2),
(2, 'Desativado', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `telas`
--

DROP TABLE IF EXISTS `telas`;
CREATE TABLE IF NOT EXISTS `telas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tela` varchar(80) NOT NULL,
  `identificador` varchar(80) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `menu` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `telas`
--

INSERT INTO `telas` (`id`, `tela`, `identificador`, `cadastrado`, `modificado`, `menu`) VALUES
(1, 'Menus', 'menus', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 5),
(2, 'Telas', 'telas', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 3),
(3, 'Perfis', 'perfis', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 3),
(4, 'Telas do perfil', 'perfil_tela', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 4),
(5, 'Usuários', 'usuarios', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 3),
(6, 'Situações de registros', 'situacoes_registros', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 5),
(7, 'Permissões', 'permissoes', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 5),
(8, 'Dashboard', 'dashboard', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1),
(9, 'Minha conta', 'minha_conta', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1),
(10, 'Mudar foto', 'mudar_foto', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1),
(11, 'Cores', 'cores', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 5),
(12, 'Submenus do menu', 'menu_submenus', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 4),
(13, 'Tipos de cores', 'tipos_cores', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_cores`
--

DROP TABLE IF EXISTS `tipos_cores`;
CREATE TABLE IF NOT EXISTS `tipos_cores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_cor` varchar(80) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipos_cores`
--

INSERT INTO `tipos_cores` (`id`, `tipo_cor`, `cadastrado`, `modificado`) VALUES
(1, 'CMS', '1900-01-01 00:00:00', '1900-01-01 00:00:00'),
(2, 'Page', '1900-01-01 00:00:00', '1900-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_menus`
--

DROP TABLE IF EXISTS `tipos_menus`;
CREATE TABLE IF NOT EXISTS `tipos_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_menu` varchar(80) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipos_menus`
--

INSERT INTO `tipos_menus` (`id`, `tipo_menu`, `cadastrado`, `modificado`) VALUES
(1, 'CMS', '1900-01-01 00:00:00', '1900-01-01 00:00:00'),
(2, 'Page', '1900-01-01 00:00:00', '1900-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_permissoes`
--

DROP TABLE IF EXISTS `tipos_permissoes`;
CREATE TABLE IF NOT EXISTS `tipos_permissoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_permissao` varchar(80) NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `cor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cor` (`cor`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipos_permissoes`
--

INSERT INTO `tipos_permissoes` (`id`, `tipo_permissao`, `cadastrado`, `modificado`, `cor`) VALUES
(1, 'Somente leitura', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 5),
(2, 'Leitura e escrita', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 3),
(3, 'Leitura, escrita e edição', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 4),
(4, 'Controle total', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(80) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `email` varchar(160) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `foto` varchar(40) NOT NULL,
  `access_token` varchar(80) NOT NULL,
  `access_token_expiration` datetime NOT NULL,
  `password_token` varchar(80) NOT NULL,
  `password_token_expiration` datetime NOT NULL,
  `activation_token` varchar(80) NOT NULL,
  `activation_token_expiration` datetime NOT NULL,
  `cadastrado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `perfil` int(11) NOT NULL,
  `situacao_registro` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `situacao_registro` (`situacao_registro`),
  KEY `perfil` (`perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `cpf`, `email`, `senha`, `foto`, `access_token`, `access_token_expiration`, `password_token`, `password_token_expiration`, `activation_token`, `activation_token_expiration`, `cadastrado`, `modificado`, `perfil`, `situacao_registro`) VALUES
(1, 'Root', '111.111.111-11', 'root@wtag.com.br', '21232f297a57a5a743894a0e4a801fc3', '', '', '1900-01-01 00:00:00', '', '1900-01-01 00:00:00', '', '1900-01-01 00:00:00', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 1, 1);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cores`
--
ALTER TABLE `cores`
  ADD CONSTRAINT `cores_ibfk_1` FOREIGN KEY (`tipo_cor`) REFERENCES `tipos_cores` (`id`);

--
-- Limitadores para a tabela `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`tipo_menu`) REFERENCES `tipos_menus` (`id`),
  ADD CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`situacao_registro`) REFERENCES `situacoes_registros` (`id`);

--
-- Limitadores para a tabela `menu_submenus`
--
ALTER TABLE `menu_submenus`
  ADD CONSTRAINT `menu_submenus_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `menu_submenus_ibfk_2` FOREIGN KEY (`situacao_registro`) REFERENCES `situacoes_registros` (`id`);

--
-- Limitadores para a tabela `perfil_tela`
--
ALTER TABLE `perfil_tela`
  ADD CONSTRAINT `perfil_tela_ibfk_1` FOREIGN KEY (`perfil`) REFERENCES `perfis` (`id`),
  ADD CONSTRAINT `perfil_tela_ibfk_2` FOREIGN KEY (`tipo_permissao`) REFERENCES `tipos_permissoes` (`id`),
  ADD CONSTRAINT `perfil_tela_ibfk_3` FOREIGN KEY (`tela`) REFERENCES `telas` (`id`);

--
-- Limitadores para a tabela `situacoes_registros`
--
ALTER TABLE `situacoes_registros`
  ADD CONSTRAINT `situacoes_registros_ibfk_1` FOREIGN KEY (`cor`) REFERENCES `cores` (`id`);

--
-- Limitadores para a tabela `telas`
--
ALTER TABLE `telas`
  ADD CONSTRAINT `telas_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `menus` (`id`);

--
-- Limitadores para a tabela `tipos_permissoes`
--
ALTER TABLE `tipos_permissoes`
  ADD CONSTRAINT `tipos_permissoes_ibfk_1` FOREIGN KEY (`cor`) REFERENCES `cores` (`id`);

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`situacao_registro`) REFERENCES `situacoes_registros` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_6` FOREIGN KEY (`perfil`) REFERENCES `perfis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;