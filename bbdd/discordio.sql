-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2020 a las 19:27:07
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `discordio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friend`
--

CREATE TABLE `friend` (
  `userA` int(11) NOT NULL,
  `userB` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `friend`
--

INSERT INTO `friend` (`userA`, `userB`, `status`, `code`) VALUES
(30, 32, 1, '30-32'),
(30, 36, 1, '30-36'),
(32, 30, 1, '30-32'),
(36, 30, 1, '30-36'),
(36, 38, 1, '36-38'),
(38, 36, 1, '36-38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message`
--

CREATE TABLE `message` (
  `cod_message` int(11) NOT NULL,
  `cod_user` int(11) NOT NULL,
  `text_message` varchar(250) NOT NULL,
  `date_message` datetime NOT NULL DEFAULT current_timestamp(),
  `cod_room` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `message`
--

INSERT INTO `message` (`cod_message`, `cod_user`, `text_message`, `date_message`, `cod_room`) VALUES
(253, 30, 'Welcome to this group', '2020-11-27 16:40:31', 'DeathStarParty'),
(255, 35, 'Hello there', '2020-11-27 16:44:24', '35-38'),
(256, 38, 'General Kenobi', '2020-11-27 16:46:12', '35-38'),
(257, 38, 'You are a bold one', '2020-11-27 16:46:23', '35-38'),
(258, 36, 'The time has come, execute order 66', '2020-11-27 16:54:10', '32-36'),
(259, 36, 'The time has come, execute order 66', '2020-11-27 16:54:10', '36-39'),
(260, 36, 'The time has come, execute order 66', '2020-11-27 16:54:10', '36-40'),
(261, 36, 'The time has come, execute order 66', '2020-11-27 16:54:10', '36-41'),
(262, 30, 'Did you ever hear the tragedy of Darth Plagueis The Wise?', '2020-12-01 19:13:15', '30-32'),
(263, 32, ' No?', '2020-12-01 19:14:14', '30-32'),
(267, 30, 'I thought not. It\'s not a story the Jedi would tell you.', '2020-12-01 19:16:38', '30-32'),
(268, 30, 'It\'s a Sith legend.', '2020-12-01 19:17:49', '30-32'),
(269, 30, 'Darth Plagueis was a Dark Lord of the Sith, so powerful and so wise he could use the Force to influence the midichlorians to create life…', '2020-12-01 19:18:22', '30-32'),
(270, 30, 'He had such a knowledge of the dark side, he could even keep the ones he cared about from dying.', '2020-12-01 19:18:36', '30-32'),
(271, 32, 'He could actually save people from death?', '2020-12-01 19:19:30', '30-32'),
(272, 30, 'The dark side of the Force is a pathway to many abilities some consider to be unnatural.', '2020-12-01 19:19:53', '30-32'),
(273, 32, 'What happened to him?', '2020-12-01 19:20:07', '30-32'),
(274, 30, ' He became so powerful…', '2020-12-01 19:20:25', '30-32'),
(275, 30, ' The only thing he was afraid of was losing his power, which eventually, of course, he did.', '2020-12-01 19:20:40', '30-32'),
(276, 30, 'Unfortunately, he taught his apprentice everything he knew, then his apprentice killed him in his sleep.', '2020-12-01 19:21:04', '30-32'),
(277, 30, 'Ironic.', '2020-12-01 19:21:21', '30-32'),
(278, 30, 'He could save others from death, but not himself.', '2020-12-01 19:21:33', '30-32'),
(279, 32, 'Is it possible to learn this power?', '2020-12-01 19:21:47', '30-32'),
(280, 30, 'Not from a Jedi.', '2020-12-01 19:22:03', '30-32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `room`
--

CREATE TABLE `room` (
  `cod_room` varchar(50) NOT NULL,
  `img_room` varchar(50) NOT NULL,
  `typeOfRoom` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `room`
--

INSERT INTO `room` (`cod_room`, `img_room`, `typeOfRoom`) VALUES
('30-32', '', 'chat'),
('32-36', '', 'chat'),
('35-38', '', 'chat'),
('36-39', '', 'chat'),
('36-40', '', 'chat'),
('36-41', '', 'chat'),
('DeathStarParty', 'default_group.jpg', 'group');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `cod_user` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `photo` varchar(300) NOT NULL,
  `password_hash` varchar(80) NOT NULL,
  `description` varchar(250) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `rol` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`cod_user`, `name`, `surname`, `nick`, `mail`, `photo`, `password_hash`, `description`, `gender`, `rol`) VALUES
(26, 'admin', 'admin', 'admin', 'admin', 'admin.jpg', '$2y$10$cjssqc7hqBta2QLa0A4BV.yASKplIl2YPTRDKW/L.aMkuqFwFN9jO', 'I´m the admin', 'male', 1),
(30, 'Sheev Frank', 'Palpatine', 'TheSenate', 'IamTheSenate@GR.com', 'The senate.jpg', '$2y$10$omXS6KpOSpSp50r1fbGj9eMLqsgK3glZMX0lZlG3Ay/SRLjY6DOKm', 'I love democracy', 'male', 0),
(31, 'Leia', 'Organa', 'PrincessLeia', 'alderaanPrincess@sw.com', 'default.png', '$2y$10$UoZmgPmo3ha9nMFI7t8JfO3V9gcbJu1YQZlSggSGSqtxJEs9wFVEm', '', 'female', 0),
(32, 'Anakin', 'Skywalker', 'DarthVader', 'sithLord@galacticEmpire.sw', 'Darth Vader.jpg', '$2y$10$5tA0F5EXMbnv471me0IHAO82KbsVclDVtfswGU1Nvu0JiOHSOqhdq', 'I don´t like sand', 'male', 0),
(33, 'Luke', 'Skywalker', 'Red4', 'lastJedi@tatooin.sw', 'default.png', '$2y$10$QTPKpXfHxxn2Tkq2oEtQOuxPABk2tZsgnTV8i6X4gqGIFCGVCIqki', '', 'male', 0),
(34, 'Yoda', 'Yodanson', 'MasterYoda', 'jedimaster@jediTemple.sw', 'MasterYoda.jpg', '$2y$10$kH/EwuTctVqx/jExBTCglei7vSv9GidwF8PPjHJwtq1z4I3/2satu', 'EEEAAAAAARGGH', 'male', 0),
(35, 'Obi', 'Wan-Kenobi', 'GeneralKenobi', 'thehighgroun@jediTemple.sw', 'GeneralKenobi.jpg', '$2y$10$fZZBEZF806ypppXw2qdEFeIbJ4m7/5eKuiZ.7HqSfjiDlZ7gaxMXG', 'I have the high ground', 'male', 0),
(36, 'Sheev Frank', 'Palpatine', 'DarthSidious', 'theRealDarthSidious@galacticEmpire.sw', 'DarthSidious.jpg', '$2y$10$48y9BadV0PqwQ1i408C7Zen/7ipJNVAsqgBGEL5S0iZka1vQmlaVK', '', 'male', 0),
(37, 'Gary', 'Stormtrooperman', 'Stormtrooper', 'Stormtrooper#42069@galacticEmpire.sw', 'Stormtrooper.jpg', '$2y$10$UJrzmpHnee.Uu5nO2XFxG.Wgpl9clFz.DD0ufgyjTSZG0MJIrSU1W', '', 'male', 0),
(38, 'Grievous', 'The robot', 'GeneralGrievous', 'saberCollector@CIS.sw', 'GeneralGrievous.jpg', '$2y$10$Wp096mkqHVnVGJywADDnqeyDxqNmCS.Je5AQ4eT.27b4ktypMZOgy', '', 'other', 0),
(39, 'Commander', 'Codi', 'CommanderCodi', 'commanderCodi@gar212.sw', 'CommanderCodi.jpg', '$2y$10$IApIq5vZ7cdY2rI2xJLw8.IbRXanQYEUridmguGZTe/8mFn2ZqTCe', '', 'male', 0),
(40, 'Commander', 'Bakara', 'CommanderBakara', 'commanderBakara@gar.sw', 'default.png', '$2y$10$7Rhzsi54vo3zOSEQsk3OiebLu4HcrQ/CUZw.FxEAoSc3/4xU4/Im.', '', 'male', 0),
(41, 'Captain', 'Rex', 'CaptainRex', 'captainRex@gar501.sw', 'default.png', '$2y$10$9DOjEloxSQm2AwJ7JqOrGecC/RMVPLjrekXMgvwYzzQdRsYB3M4Hi', '', 'male', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_room`
--

CREATE TABLE `user_room` (
  `cod_user` int(11) NOT NULL,
  `cod_room` varchar(50) NOT NULL,
  `view` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_room`
--

INSERT INTO `user_room` (`cod_user`, `cod_room`, `view`) VALUES
(30, '30-32', 1),
(30, 'DeathStarParty', 1),
(32, '30-32', 1),
(32, '32-36', 1),
(32, 'DeathStarParty', 1),
(35, '35-38', 0),
(36, '32-36', 1),
(36, '36-39', 1),
(36, '36-40', 1),
(36, '36-41', 1),
(37, 'DeathStarParty', 0),
(38, '35-38', 1),
(39, '36-39', 1),
(40, '36-40', 0),
(41, '36-41', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`userA`,`userB`),
  ADD KEY `userA` (`userA`),
  ADD KEY `userB` (`userB`);

--
-- Indices de la tabla `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`cod_message`),
  ADD KEY `cod_room` (`cod_room`);

--
-- Indices de la tabla `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`cod_room`),
  ADD KEY `cod_room` (`cod_room`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`cod_user`),
  ADD UNIQUE KEY `nick` (`nick`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `cod_user` (`cod_user`);

--
-- Indices de la tabla `user_room`
--
ALTER TABLE `user_room`
  ADD PRIMARY KEY (`cod_user`,`cod_room`),
  ADD KEY `cod_user` (`cod_user`),
  ADD KEY `cor_room` (`cod_room`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `message`
--
ALTER TABLE `message`
  MODIFY `cod_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `cod_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`userA`) REFERENCES `user` (`cod_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`userB`) REFERENCES `user` (`cod_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`cod_room`) REFERENCES `room` (`cod_room`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_room`
--
ALTER TABLE `user_room`
  ADD CONSTRAINT `user_room_ibfk_1` FOREIGN KEY (`cod_user`) REFERENCES `user` (`cod_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_room_ibfk_2` FOREIGN KEY (`cod_room`) REFERENCES `room` (`cod_room`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
