CREATE DATABASE IF NOT EXISTS `Projeto_Final` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `Projeto_Final`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `categorias_lixo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `descricao` text,
  `instrucoes_descarte` text,
  `icone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pontos_recolha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `morada` varchar(255) NOT NULL,
  `freguesia` varchar(100) DEFAULT NULL,
  `latitude` decimal(10, 8) NOT NULL,
  `longitude` decimal(11, 8) NOT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `tipo_local` enum('Centro de Receção','Ecocentro','Entrajuda','Ponto Eletrão','Câmara Municipal') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pontos_categorias` (
  `ponto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`ponto_id`,`categoria_id`),
  FOREIGN KEY (`ponto_id`) REFERENCES `pontos_recolha` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`categoria_id`) REFERENCES `categorias_lixo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `info_home` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo`  varchar(255) NOT NULL,
  `info`  varchar(1000) NOT NULL,
  `tipo_texto` enum('Informacao','Noticia') NOT NULL,
  PRIMARY KEY (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `info_sobre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo`  varchar(255) NOT NULL,
  `info`  varchar(1000) NOT NULL,
  `tipo_texto` enum('Informacao') NOT NULL,
  PRIMARY KEY (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;