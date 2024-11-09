-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2024 a las 23:05:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_apijuegos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compania`
--

CREATE TABLE `compania` (
  `id_compania` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fecha_fundacion` date NOT NULL,
  `oficinas_centrales` varchar(300) NOT NULL,
  `sitio_web` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compania`
--

INSERT INTO `compania` (`id_compania`, `nombre`, `fecha_fundacion`, `oficinas_centrales`, `sitio_web`) VALUES
(1, 'Riot Games', '2006-09-06', 'Los Angeles, Los Ángeles, California, Estados Unidos', 'riotgames.com'),
(2, 'Ubisoft Entertainment', '1984-03-28', 'Montreuil, Francia', 'ubisoft.com'),
(3, 'Blizzard Entertainment\r\n', '1981-09-08', 'Irvine, California, Estados Unidos', 'blizzard.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id_juegos` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fecha_lanzamiento` date NOT NULL,
  `modalidad` varchar(150) NOT NULL,
  `plataformas` varchar(255) NOT NULL,
  `id_compania` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id_juegos`, `nombre`, `fecha_lanzamiento`, `modalidad`, `plataformas`, `id_compania`, `precio`) VALUES
(5, 'Assassin\'s Creed IV: Black Flag', '2013-10-19', 'Videojuego multijugador', 'PlayStation 4, Nintendo Switch, PlayStation 3', 2, 0.00),
(6, 'Far Cry 4', '2014-11-17', 'Videojuego multijugador, Videojuego de un jugador', 'PlayStation 4, PlayStation 3, Xbox 360, Microsoft Windows, Xbox One', 2, 0.00),
(7, 'League of Legends', '2009-10-27', 'MOBA', ' Microsoft Windows, macOS', 1, 0.00),
(8, 'Valorant', '2020-06-02', 'Videojuego multijugador', 'PlayStation 5, Microsoft Windows, Xbox Series X|S, Android', 1, 0.00),
(9, 'Teamfight Tactics', '2019-09-26', 'Videojuego multijugador', 'iOS, Android, macOS, Microsoft Windows, Mac OS', 1, 0.00),
(10, 'Overwatch 2', '2022-10-04', 'Videojuego multijugador', 'PlayStation 5, PlayStation 4, Nintendo Switch, Microsoft Windows, Xbox One, Xbox Series X|S, GeForce Now', 3, 0.00),
(11, 'Far Cry 6', '2021-10-07', 'Videojuego multijugador', 'PlayStation 5, PlayStation 4, Xbox Series X|S', 2, 0.00),
(25, 'pokemon go', '2023-01-07', 'realidad aumentada', 'iOS, android,', 3, 0.00),
(27, 'pokemon go 2', '2023-01-07', 'realidad aumentada', 'iOS, android, nuevo', 3, 150.66),
(28, 'world of warcraft', '2022-04-12', 'multi jugador', 'windows,linux', 1, 120.36);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id_reseña` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`id_reseña`, `id_juego`, `id_usuario`, `titulo`, `comentario`) VALUES
(1, 11, 1, 'muy bueno\r\n', 'Historia y misiones 10/10 me encantan las misiones principales y secundarias.\r\n'),
(2, 7, 1, 'decepcion', 'La verdad esq yo era feliz antes de jugar Legue Of Legends');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `password` char(60) NOT NULL,
  `rol` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `rol`) VALUES
(1, 'webadmin', '$2y$10$75g0enZ9Wc57xvmKdIGO/epmtKkenxtEduz1ELKPZ6ZvnFzbA8kmq', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compania`
--
ALTER TABLE `compania`
  ADD PRIMARY KEY (`id_compania`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id_juegos`),
  ADD KEY `id_compania` (`id_compania`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id_reseña`),
  ADD KEY `id_juego` (`id_juego`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compania`
--
ALTER TABLE `compania`
  MODIFY `id_compania` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id_juegos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id_reseña` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `juegos_ibfk_1` FOREIGN KEY (`id_compania`) REFERENCES `compania` (`id_compania`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id_juegos`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reseñas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
