-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2024 a las 05:38:48
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
-- Base de datos: `cine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asiento`
--

CREATE TABLE `asiento` (
  `id` int(11) NOT NULL,
  `fila` varchar(2) NOT NULL,
  `columna` int(11) NOT NULL,
  `id_sala` int(11) DEFAULT NULL,
  `estado` enum('libre','reservado','ocupado') DEFAULT 'libre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleto`
--

CREATE TABLE `boleto` (
  `id` int(11) NOT NULL,
  `id_asiento` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipo_boleto` enum('normal','vip','descuento') DEFAULT 'normal',
  `id_usuario_registrado` int(11) DEFAULT NULL,
  `id_pelicula` int(11) DEFAULT NULL,
  `precio_total` decimal(10,2) NOT NULL,
  `estado` enum('reservado','vendido','cancelado') DEFAULT 'reservado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `id_p` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `director` varchar(100) DEFAULT NULL,
  `reparto` text DEFAULT NULL,
  `galeria` text NOT NULL,
  `duracion` int(11) DEFAULT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `clasificacion` varchar(5) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `video` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`id_p`, `nombre`, `director`, `reparto`, `galeria`, `duracion`, `fecha_estreno`, `clasificacion`, `descripcion`, `genero`, `video`) VALUES
(1, 'Inception', 'Christopher Nolan', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page', '', 148, '2010-07-16', 'PG-13', 'Un ladrón con la habilidad de entrar en los sueños de otros acepta un último trabajo que podría redimirlo.', 'Ciencia Ficción', ''),
(3, 'The Godfather', 'Francis Ford Coppola', 'Marlon Brando, Al Pacino, James Caan', '', 175, '1972-03-24', 'R', 'El patriarca de una dinastía criminal transfiere el control de su imperio clandestino a su hijo renuente.', 'Crimen, Drama', ''),
(4, 'Titanic', 'James Cameron', 'Leonardo DiCaprio, Kate Winslet', '', 195, '1997-12-19', 'PG-13', 'Una historia épica de amor y tragedia en el trasatlántico más famoso del mundo.', 'Drama, Romance', ''),
(5, 'The Avengers', 'Joss Whedon', 'Robert Downey Jr., Chris Evans, Scarlett Johansson', '', 143, '2012-05-04', 'PG-13', 'Superhéroes de Marvel se unen para detener una amenaza global liderada por Loki.', 'Acción, Ciencia Ficción', ''),
(6, 'The Dark Knight', 'Christopher Nolan', 'Christian Bale, Heath Ledger, Aaron Eckhart', 'vista/images/peliculas/the_dark_knight/img1.jpg', 152, '2008-07-18', 'PG-13', 'Batman enfrenta a un nuevo enemigo, el Joker, que amenaza con sumir a Gotham en el caos.', 'Acción, Crimen, Drama', 'https://www.youtube.com/watch?v=EXeTwQWrcwY'),
(7, 'ADSAD', 'Aadsad', 'asdasdasd,asdasd', 'vista/images/peliculas/the_dark_knight/img1.jpg', 125, '2024-10-31', 'PG-13', 'adasdasdasdasdasd', 'accion', 'https://www.youtube.com/watch?v=2KuWjZD6PBA'),
(8, 'test1', 'asda', 'asdasdasd,asdasd', 'vista/images/peliculas/the_dark_knight/img1.jpg', 111, '2024-10-28', 'R', 'asddddddddddddddddddd aaaa', 'accion', 'https://www.youtube.com/watch?v=2KuWjZD6PBA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala_de_cine`
--

CREATE TABLE `sala_de_cine` (
  `id` int(11) NOT NULL,
  `nro_asientos` int(11) NOT NULL,
  `tipo_de_sala` enum('2D','3D','IMAX') NOT NULL,
  `estado` enum('activa','mantenimiento','inactiva') DEFAULT 'activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `DNI` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_admin`
--

CREATE TABLE `usuario_admin` (
  `id` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `perfil` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_admin`
--

INSERT INTO `usuario_admin` (`id`, `foto`, `perfil`, `nombre`, `usuario`, `password`, `estado`) VALUES
(1, '', 'Administrador', 'Cristian', 'Cris02', 'esis', 1),
(41, '', '', 'Cristian', 'cristian1', '$2a$07$asxx54ahjppf45sd87a5auJ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_registrado`
--

CREATE TABLE `usuario_registrado` (
  `id` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nro_asistencias` int(11) DEFAULT 0,
  `tipo_usuario` enum('regular','vip') DEFAULT 'regular',
  `DNI` varchar(15) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_registrado`
--

INSERT INTO `usuario_registrado` (`id`, `foto`, `nombre`, `usuario`, `password`, `nro_asistencias`, `tipo_usuario`, `DNI`, `id_usuario`) VALUES
(0, '', 'Pedro', 'peter1', '1234', 2, 'regular', '71548822', NULL),
(0, '', 'Pedro', 'peter1', '1234', 2, 'regular', '71548822', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asiento`
--
ALTER TABLE `asiento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_sala` (`id_sala`,`fila`,`columna`);

--
-- Indices de la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_asiento` (`id_asiento`),
  ADD KEY `id_usuario_registrado` (`id_usuario_registrado`),
  ADD KEY `id_pelicula` (`id_pelicula`),
  ADD KEY `idx_boleto_fecha` (`fecha`);

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id_p`),
  ADD KEY `idx_pelicula_nombre` (`nombre`);

--
-- Indices de la tabla `sala_de_cine`
--
ALTER TABLE `sala_de_cine`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `idx_usuario_dni` (`DNI`);

--
-- Indices de la tabla `usuario_admin`
--
ALTER TABLE `usuario_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario_admin`
--
ALTER TABLE `usuario_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
