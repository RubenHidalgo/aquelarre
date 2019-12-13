-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2019 at 12:22 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aquelarre`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id_game` int(11) NOT NULL,
  `nameg` varchar(100) NOT NULL,
  `about` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id_game`, `nameg`, `about`) VALUES
(59, 'Aventura en las Hurdes', 'Salva a los habitantes de la comarca'),
(60, 'Sombras de Toledo', 'Descubre que se oculta en la noche toledana'),
(61, 'En las montañas de la locura', 'Viaja hasta una isla donde nada es lo que parece');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `about` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nick`, `pass`, `about`) VALUES
(5, 'Pedro', 'reyes', 'No me gustan los juegos de rol, frikis.'),
(6, 'Marc', 'gasol', 'Me gusta el vino y las mujeres.'),
(7, 'Pepito', 'grillo', 'Soy de Valencia y me gusta el bacalao.'),
(8, 'Carlos', 'sainz', 'Trato de arrancarlo.'),
(9, 'berta', 'escobar', 'No tengo nada que decir');

-- --------------------------------------------------------

--
-- Table structure for table `user_game`
--

CREATE TABLE `user_game` (
  `id_user_game` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `director` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_game`
--

INSERT INTO `user_game` (`id_user_game`, `id_user`, `id_game`, `director`) VALUES
(4, 6, 59, 1),
(5, 6, 60, 1),
(6, 5, 61, 1),
(31, 8, 59, 0),
(32, 8, 61, 0),
(33, 5, 60, 0),
(34, 5, 59, 0),
(35, 7, 59, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id_game`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_game`
--
ALTER TABLE `user_game`
  ADD PRIMARY KEY (`id_user_game`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_game` (`id_game`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_game`
--
ALTER TABLE `user_game`
  MODIFY `id_user_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_game`
--
ALTER TABLE `user_game`
  ADD CONSTRAINT `user_game_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `user_game_ibfk_2` FOREIGN KEY (`id_game`) REFERENCES `game` (`id_game`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
