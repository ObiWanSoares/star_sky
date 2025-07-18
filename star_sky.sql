-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Jul-2025 às 23:55
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `star_sky`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `characters`
--

CREATE TABLE `characters` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `characters`
--

INSERT INTO `characters` (`id`, `player_id`, `nome`) VALUES
(1, 5, 'Obi Wan Soares');

-- --------------------------------------------------------

--
-- Estrutura da tabela `character_skill`
--

CREATE TABLE `character_skill` (
  `id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `character_skill`
--

INSERT INTO `character_skill` (`id`, `character_id`, `skill_id`, `level`) VALUES
(2, 1, 1, 1),
(3, 1, 2, 1),
(4, 1, 3, 0),
(5, 1, 4, 1),
(6, 1, 5, 1),
(7, 1, 6, 3),
(8, 1, 7, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires_at` datetime DEFAULT NULL,
  `char_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `players`
--

INSERT INTO `players` (`id`, `username`, `email`, `password`, `is_admin`, `created_at`, `reset_token`, `reset_expires_at`, `char_name`) VALUES
(5, '', 'obiwansoares@gmail.com', '$2y$10$gTUi86JiD6oLshErCPYD4eCoASmkdY1i6Od3YvZuSjKtP2rh2FViC', 0, '2025-07-14 23:01:14', NULL, NULL, 'Obi Wan Soares');

-- --------------------------------------------------------

--
-- Estrutura da tabela `player_location`
--

CREATE TABLE `player_location` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `tile_x` tinyint(4) NOT NULL DEFAULT 0,
  `tile_y` tinyint(4) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `races`
--

CREATE TABLE `races` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` text DEFAULT NULL,
  `is_playable` tinyint(1) NOT NULL DEFAULT 1,
  `bonus_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bonus_json`)),
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `races`
--

INSERT INTO `races` (`id`, `name`, `description`, `is_playable`, `bonus_json`, `image_url`) VALUES
(4, 'Humano', 'Adaptável e versátil, exímio em pilotagem e produção, mas menos diplomático.', 1, '{\"Pilotagem\":2, \"Produção\":2, \"Diplomacia\":-1}', NULL),
(5, 'Sylvani', 'Ligados à natureza, excelentes em combate e construção, mas maus pilotos.', 1, '{\"Combate\":2, \"Construção\":2, \"Pilotagem\":-1}', NULL),
(6, 'Aquarion', 'Mestres de inteligência e diplomacia, mas fracos em combate.', 1, '{\"Inteligência\":2, \"Diplomacia\":2, \"Combate\":-1}', NULL),
(7, 'Elionar', 'Místicos e curiosos, excelentes em exploração e ciência, mas vulneráveis em batalha.', 0, '{\"Ciência\":2, \"Exploração\":2, \"Combate\":-2}', NULL),
(8, 'Thrylok', 'Robustos e resistentes, superiores em defesa, mas lentos em investigação.', 0, '{\"Defesa\":2, \"Investigação\":-2, \"Resistência\":2}', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `skills`
--

INSERT INTO `skills` (`id`, `name`) VALUES
(1, 'Combate'),
(2, 'Construção'),
(3, 'Diplomacia'),
(8, 'Haki'),
(4, 'Inteligência'),
(5, 'Perceção'),
(6, 'Pilotagem'),
(7, 'Produção');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Índices para tabela `character_skill`
--
ALTER TABLE `character_skill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `character_id` (`character_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Índices para tabela `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `player_location`
--
ALTER TABLE `player_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Índices para tabela `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices para tabela `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `characters`
--
ALTER TABLE `characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `character_skill`
--
ALTER TABLE `character_skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `player_location`
--
ALTER TABLE `player_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `races`
--
ALTER TABLE `races`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);

--
-- Limitadores para a tabela `character_skill`
--
ALTER TABLE `character_skill`
  ADD CONSTRAINT `character_skill_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`),
  ADD CONSTRAINT `character_skill_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`);

--
-- Limitadores para a tabela `player_location`
--
ALTER TABLE `player_location`
  ADD CONSTRAINT `player_location_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
