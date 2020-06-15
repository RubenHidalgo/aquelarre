-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2020 a las 23:43:52
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aquelarre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game`
--

CREATE TABLE `game` (
  `id_game` int(11) NOT NULL,
  `nameg` varchar(100) NOT NULL,
  `about` varchar(1000) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `game`
--

INSERT INTO `game` (`id_game`, `nameg`, `about`, `created`) VALUES
(86, 'El Asalto a las Hurdes', 'Una horda de zombis ha sido vista en las inmediaciones de la comarca', '2020-06-15 14:44:30'),
(87, 'Infiltrado en el convento', 'Unos monjes benedictinos han pedido la ayuda del grupo. Creen que uno de los novicios puede estar invocando al demonio', '2020-06-15 18:01:34');

--
-- Disparadores `game`
--
DELIMITER $$
CREATE TRIGGER `gamecreated` BEFORE INSERT ON `game` FOR EACH ROW BEGIN
    SET new.created = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `nick` varchar(20) NOT NULL,
  `acceso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`nick`, `acceso`) VALUES
('admin', '2020-06-11 17:31:55'),
('kepa70', '2020-06-11 17:46:22'),
('fed_k10', '2020-06-11 17:47:30'),
('klmero', '2020-06-11 17:48:07'),
('rijanacalas', '2020-06-11 17:49:14'),
('admin', '2020-06-11 17:49:45'),
('klmero', '2020-06-11 17:50:10'),
('rijanacalas', '2020-06-11 17:50:17'),
('admin', '2020-06-11 17:50:26'),
('admin', '2020-06-12 13:27:13'),
('admin', '2020-06-12 17:27:28'),
('kepa70', '2020-06-12 18:34:20'),
('admin', '2020-06-12 18:35:15'),
('kepa70', '2020-06-12 18:38:52'),
('admin', '2020-06-12 18:39:08'),
('kepa70', '2020-06-12 19:14:27'),
('admin', '2020-06-12 19:26:14'),
('kepa70', '2020-06-12 19:27:27'),
('admin', '2020-06-12 19:33:51'),
('kepa70', '2020-06-12 20:24:50'),
('admin', '2020-06-12 20:25:23'),
('admin', '2020-06-12 20:26:16'),
('rijanacalas', '2020-06-12 20:43:35'),
('aaa', '2020-06-13 01:46:22'),
('aaa', '2020-06-13 01:46:41'),
('aaaa', '2020-06-13 01:49:51'),
('admin', '2020-06-13 01:57:08'),
('rijanacalas', '2020-06-13 02:03:43'),
('admin', '2020-06-13 15:00:37'),
('admin', '2020-06-13 18:56:23'),
('aaaa', '2020-06-13 19:00:43'),
('admin', '2020-06-13 19:00:55'),
('aaa', '2020-06-13 19:01:28'),
('aaa', '2020-06-13 19:08:53'),
('admin', '2020-06-13 19:12:28'),
('zzz', '2020-06-13 19:20:45'),
('bbb', '2020-06-13 19:20:57'),
('admin', '2020-06-13 19:21:02'),
('aaaa', '2020-06-13 19:30:15'),
('aaaa', '2020-06-13 19:38:01'),
('admin', '2020-06-13 19:38:11'),
('admin', '2020-06-13 19:57:05'),
('admin', '2020-06-13 20:03:24'),
('admin', '2020-06-13 20:17:02'),
('aaaa', '2020-06-13 20:40:19'),
('admin', '2020-06-13 20:40:54'),
('aaaa', '2020-06-13 20:41:37'),
('admin', '2020-06-13 20:43:07'),
('aaa', '2020-06-13 20:44:44'),
('admin', '2020-06-13 20:49:21'),
('aaa', '2020-06-13 22:04:50'),
('admin', '2020-06-13 22:07:57'),
('', '2020-06-13 22:33:45'),
('admin', '2020-06-13 22:35:09'),
('admin', '2020-06-13 23:18:05'),
('admin', '2020-06-14 11:28:15'),
('admin', '2020-06-14 12:51:55'),
('aaa', '2020-06-14 12:54:57'),
('admin', '2020-06-14 12:55:23'),
('admin', '2020-06-14 13:32:21'),
('admin', '2020-06-14 13:34:42'),
('aaa', '2020-06-14 13:34:52'),
('aaaa', '2020-06-14 17:57:26'),
('admin', '2020-06-14 17:58:16'),
('aaaa', '2020-06-14 17:58:44'),
('aaaa', '2020-06-14 18:00:22'),
('aaaa', '2020-06-14 18:02:46'),
('aaaa', '2020-06-14 18:06:09'),
('aaa', '2020-06-14 18:08:12'),
('admin', '2020-06-14 18:08:25'),
('aaaa', '2020-06-14 18:11:32'),
('aaa', '2020-06-14 18:13:15'),
('aaa', '2020-06-14 18:13:21'),
('zzz', '2020-06-14 18:14:25'),
('admin', '2020-06-14 18:32:34'),
('zzz', '2020-06-14 18:47:10'),
('asd', '2020-06-14 18:47:55'),
('zzz', '2020-06-15 10:56:12'),
('zzz', '2020-06-15 12:04:31'),
('admin', '2020-06-15 12:13:58'),
('asd', '2020-06-15 12:14:10'),
('zzz', '2020-06-15 13:36:06'),
('zzz', '2020-06-15 14:28:56'),
('admin', '2020-06-15 14:29:42'),
('canela83', '2020-06-15 14:31:12'),
('relima', '2020-06-15 14:32:56'),
('admin', '2020-06-15 14:45:13'),
('canela83', '2020-06-15 14:48:03'),
('canela83', '2020-06-15 16:04:51'),
('admin', '2020-06-15 16:16:35'),
('canela83', '2020-06-15 16:17:11'),
('admin', '2020-06-15 16:17:31'),
('canela83', '2020-06-15 16:18:36'),
('canela83', '2020-06-15 16:25:00'),
('peterking', '2020-06-15 17:54:29'),
('peterking', '2020-06-15 18:01:55'),
('canela83', '2020-06-15 18:08:24'),
('peterking', '2020-06-15 18:08:52'),
('peterking', '2020-06-15 18:10:50'),
('peterking', '2020-06-15 18:12:46'),
('canela83', '2020-06-15 18:14:42'),
('admin', '2020-06-15 18:15:00'),
('canela83', '2020-06-15 18:20:43'),
('admin', '2020-06-15 18:24:54'),
('canela83', '2020-06-15 18:29:48'),
('admin', '2020-06-15 18:32:53'),
('canela83', '2020-06-15 18:35:54'),
('canela83', '2020-06-15 18:41:17'),
('relima', '2020-06-15 18:41:34'),
('rokemesa', '2020-06-15 20:52:56'),
('canela83', '2020-06-15 20:56:25'),
('peterking', '2020-06-15 20:57:15'),
('peterking', '2020-06-15 20:59:56'),
('admin', '2020-06-15 21:01:16'),
('relima', '2020-06-15 21:04:49'),
('peterking', '2020-06-15 21:10:10'),
('admin', '2020-06-15 21:11:36'),
('rokemesa', '2020-06-15 21:12:02'),
('canela83', '2020-06-15 23:08:13'),
('admin', '2020-06-15 23:15:36');

--
-- Disparadores `log`
--
DELIMITER $$
CREATE TRIGGER `accesolog` BEFORE INSERT ON `log` FOR EACH ROW BEGIN
    SET new.acceso = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `body_text` mediumtext NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id_post`, `title`, `picture`, `body_text`, `created`) VALUES
(5, 'Dragonas y mazmorros', 'media/post_images/destacada (1).jpg', 'Antes de seguir, me veo casi obligada a hacer un pequeño inciso. El rol por encima de todo es creatividad artística, pues nos permite crear los mundos y personajes que queramos, y ponerlos en las situaciones que queramos. Puedo decir -sin equivocarme- que el aspecto creativo del rol es totalmente libre. Por ello el ambiente y/o “setting” de la partida es total y completa responsabilidad del máster.\r\n\r\nVolviendo a mi experiencia como mujer rolera, pude experimentar de primera mano, cómo se repetían – en distintas campañas de distintas temáticas- una serie de estereotipos y restricciones determinadas, cuando una jugadora llevaba a un personaje femenino.\r\n\r\nDesde tratar de limitarla a que fuese la curandera del grupo, hasta que por alguna extraña e ilógica razón todos los personajes masculinos se la querían llevar a la cama o “hacerla su esposa”. Y no empecemos con las descripciones del equipo de combate femenino…\r\n\r\nCreo que no me equivoco si digo que en pleno siglo XXI esta clase de situaciones y comportamientos son un sin sentido. Y que tratar de escudarse detrás de “es que el mundo es así” o “es que esto es realista” son las excusas más baratas que puedan existir.\r\n\r\nSoy consciente que en algunas cabezas cavernarias el mensaje que llevan mis palabras no pueda ser comprendido, por ello explicaré un ejemplo práctico y real.\r\n\r\nCon unos amigos y mi novio, llevamos un tiempo con una partida de rol cuyo setting es una mezcla de “The Witcher juego de rol” y “Anima” con algún que otro toque estético de Castlevania. Por lo mencionado podéis ver que el ambiente de la partida no es precisamente de florecitas y gestas heroicas, lo que me va de perlas para dar el ejemplo.\r\n\r\nEl 80% de nuestros personajes o eran magos o habían sufrido experimentos mágicos, lo que nos aportó ya desde el principio de la partida, una dificultad añadida de ser cuidadosos con nuestras acciones y de esconder nuestra naturaleza siempre que nos fuera posible.', '2020-06-14 12:21:12'),
(6, 'D de Dragón', 'media/post_images/imatge_capçalera_960x372.jpg', 'En este compendio de artículos -a los que llamamos “diccionario”- son una serie de ensayos en los que tratamos de desmenuzar, analizar, deconstruir y muy posiblemente romper términos habituales en los juegos de rol. En la letra D propusimos dos opciones, Dungeon y Dragón, en honor al clásico juego de rol, y una idea: que la opción que saliera ganadora se publicara en nuestro blog y la segunda (que no perdedora) saliera aquí, en Nación Rolera.\r\n\r\nTenéis nuestras palabras sobre el Dungeon aquí, y ahora vamos a hablar de dragones.\r\n\r\nEl ser humano siempre ha tenido fascinación por el dragón como elemento mitológico. Es el enemigo definitivo: inteligente, astuto, fuerte, capaz de volar, lanza un aliento mágico, es sagaz, ambicioso, posee un conocimiento en algunos casos milenario y si no fuera una criatura de fantasía nos habría arrebatado el lugar que ocupamos en la cadena alimenticia.\r\n\r\nEl dragón ha sido siempre una figura o entidad que ha definido y ha dado distinción a la fantasía. Podía ser más heroica o más oscura, pero una fantasía debía de tener dragones, ya estuviéramos hablando de la Dragonlance, de Skyrim o de Bright; el dragón es el enemigo final por excelencia, luchar contra este es el hito por el que miles de aventureros han pasado de forma época y recurrente en las campañas que se precien. Su presencia provoca fascinación, pero ¿qué es un dragón?', '2020-06-14 18:38:20'),
(7, 'Desplegando pistas, en aventuras de investigación', 'media/post_images/imagen-destacada-relian-2.jpg', 'Muchos directores de juego neófitos intentan imitar este modelo a la hora de organizar sus partidas, y se encuentran, en un momento dado, con que las cosas se atascan: o bien por pura mala suerte todos los personajes fallan al intentar obtener una pista crucial, o bien los personajes han recopilado todas las pistas a su alcance, pero los jugadores no consiguen encontrarles sentido. En cualquier caso, la partida se para, los jugadores se empiezan a frustrar y el narrador se encuentra con que todo el esfuerzo realizado en preparar la aventura se va a la basura.\r\n\r\nPor tanto, es crucial establecer bien las pistas, y esto incluye pensar por adelantado qué pistas conducen a otras, y cómo fluirá la partida. Cuando los jugadores encuentran una pista, normalmente es un fragmento de información que desvela parte de lo que está ocurriendo, y que además suele dar pie a buscar más pistas en lugares que antes eran desconocidos. Por ejemplo, descubrir unas sospechosas huellas de botas de agua en la entrada de la casa del fallecido puede inducir a los jugadores a interrogar al jardinero, que utiliza de forma habitual ese calzado. Otras pistas pueden acotar y reducir la cantidad de sospechosos, como tener una grabación que demuestra que una persona estaba en otro lugar el día de autos.', '2020-06-15 23:20:02');

--
-- Disparadores `post`
--
DELIMITER $$
CREATE TRIGGER `postcreated` BEFORE INSERT ON `post` FOR EACH ROW BEGIN
    SET new.created = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `about` varchar(500) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `nick`, `pass`, `about`, `fecha`) VALUES
(21, 'admin', 'admin', 'Administrador', '2020-06-11 14:58:10'),
(31, 'canela83', 'canela83', 'Preparado para guerrear y tomar cerveza en las cantinas', '2020-06-15 14:31:12'),
(32, 'relima', 'relima', 'Me gusta la fotografía y preparar pociones secretas en mi laboratorio', '2020-06-15 14:32:56'),
(33, 'peterking', 'peterking', 'Aficionado a escribir relatos cortos bastante malos.', '2020-06-15 17:54:29'),
(34, 'rokemesa', 'rokemesa', 'Nómada y soñador', '2020-06-15 20:52:56');

--
-- Disparadores `user`
--
DELIMITER $$
CREATE TRIGGER `usercreated` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    SET new.fecha = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_game`
--

CREATE TABLE `user_game` (
  `id_user_game` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `director` tinyint(4) NOT NULL,
  `clase` tinyint(11) DEFAULT NULL,
  `vida` tinyint(11) DEFAULT NULL,
  `nivel` tinyint(4) DEFAULT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_game`
--

INSERT INTO `user_game` (`id_user_game`, `id_user`, `id_game`, `director`, `clase`, `vida`, `nivel`, `nombre`) VALUES
(66, 32, 86, 1, 1, 1, 1, 'Director de juego'),
(67, 31, 86, 0, 3, 15, 6, 'Merli de Castro'),
(68, 33, 86, 0, 2, 20, 2, 'Lázaro'),
(69, 31, 87, 1, 1, 1, 1, 'Director'),
(70, 33, 87, 0, 1, 30, 1, 'Petra'),
(71, 34, 86, 0, 1, 30, 1, 'Melinda'),
(72, 32, 87, 0, 2, 20, 1, 'Víbora'),
(73, 34, 87, 0, 1, 30, 1, 'asdasd');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id_game`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `user_game`
--
ALTER TABLE `user_game`
  ADD PRIMARY KEY (`id_user_game`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_game` (`id_game`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `game`
--
ALTER TABLE `game`
  MODIFY `id_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `user_game`
--
ALTER TABLE `user_game`
  MODIFY `id_user_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `user_game`
--
ALTER TABLE `user_game`
  ADD CONSTRAINT `user_game_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `user_game_ibfk_2` FOREIGN KEY (`id_game`) REFERENCES `game` (`id_game`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
