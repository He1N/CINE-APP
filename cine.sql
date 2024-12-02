-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2024 a las 22:11:38
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
-- Estructura de tabla para la tabla `funcion`
--

CREATE TABLE `funcion` (
  `id` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `formato` enum('2D Regular Doblada','3D Regular Doblada') NOT NULL,
  `id_sala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `funcion`
--

INSERT INTO `funcion` (`id`, `id_pelicula`, `fecha`, `hora`, `formato`, `id_sala`) VALUES
(1, 1, '2024-12-03', '14:30:00', '2D Regular Doblada', 1),
(2, 1, '2024-12-03', '17:00:00', '3D Regular Doblada', 2),
(3, 1, '2024-12-03', '19:30:00', '2D Regular Doblada', 3),
(4, 1, '2024-12-04', '15:00:00', '2D Regular Doblada', 2),
(5, 1, '2024-12-04', '18:00:00', '3D Regular Doblada', 4),
(6, 1, '2024-12-05', '16:30:00', '2D Regular Doblada', 1),
(7, 1, '2024-12-05', '20:00:00', '3D Regular Doblada', 3),
(8, 2, '2024-12-03', '15:30:00', '2D Regular Doblada', 2),
(9, 2, '2024-12-03', '18:30:00', '3D Regular Doblada', 1),
(10, 2, '2024-12-04', '14:00:00', '2D Regular Doblada', 3),
(11, 2, '2024-12-04', '17:30:00', '3D Regular Doblada', 4),
(12, 2, '2024-12-05', '16:00:00', '2D Regular Doblada', 2),
(13, 2, '2024-12-05', '19:30:00', '3D Regular Doblada', 1),
(14, 3, '2024-12-03', '16:00:00', '2D Regular Doblada', 3),
(15, 3, '2024-12-03', '19:00:00', '3D Regular Doblada', 4),
(16, 3, '2024-12-04', '15:30:00', '2D Regular Doblada', 1),
(17, 3, '2024-12-04', '18:30:00', '3D Regular Doblada', 2),
(18, 3, '2024-12-05', '17:00:00', '2D Regular Doblada', 4),
(19, 3, '2024-12-05', '20:30:00', '3D Regular Doblada', 3),
(20, 4, '2024-12-03', '14:00:00', '2D Regular Doblada', 4),
(21, 4, '2024-12-03', '17:30:00', '3D Regular Doblada', 3),
(22, 4, '2024-12-04', '16:30:00', '2D Regular Doblada', 2),
(23, 4, '2024-12-04', '20:00:00', '3D Regular Doblada', 1),
(24, 4, '2024-12-05', '15:00:00', '2D Regular Doblada', 3),
(25, 4, '2024-12-05', '18:30:00', '3D Regular Doblada', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `director` varchar(100) NOT NULL,
  `reparto` text DEFAULT NULL,
  `img_reparto` text DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `clasificacion` varchar(5) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `img_banner` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `lenguaje` varchar(255) DEFAULT NULL,
  `puntuación` decimal(3,1) NOT NULL DEFAULT 0.0,
  `estreno` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`id`, `nombre`, `director`, `reparto`, `img_reparto`, `duracion`, `fecha_estreno`, `clasificacion`, `descripcion`, `genero`, `imagen`, `img_banner`, `trailer_url`, `lenguaje`, `puntuación`, `estreno`) VALUES
(1, 'Alien', 'Ridley Scott', 'Cailee Spaeny,Isabela Merced,Spike Fearn,Daniel Betts', './img/reparto1img1.png,./img/reparto1img2.png,./img/reparto1img3.png,./img/reparto1img4.png', 117, '2023-08-20', 'R', 'La tripulación de una nave espacial comercial se encuentra con una forma de vida mortal después de investigar una transmisión misteriosa.', 'Ciencia Ficción, Terror', './img/imgc1.jpg', './img/imgbanner2.jpg', 'https://www.youtube.com/watch?v=GTNMt84KT0k&ab_channel=20thCenturyStudios', 'Español', 8.0, 1),
(2, 'Duna: Parte Dos', 'Christopher Nolan', 'Timothée Chalamet, Zendaya Coleman, David Michael, Florence Pugh', './img/reparto2img1.png,./img/reparto2img2.png,./img/reparto2img3.png,./img/reparto2img4.png', 180, '2023-08-15', 'R', 'La historia del científico J. Robert Oppenheimer y su papel en el desarrollo de la bomba atómica.', 'Drama, Biografía', './img/imgc2.jpg', './img/imgbanner1.jpeg', 'https://www.youtube.com/watch?v=esezQhsrix0&ab_channel=WarnerBros.PicturesLatinoam%C3%A9rica', NULL, 0.0, 0),
(3, 'Blue Beetle', 'Angel Manuel Soto', 'Bruna Marquezine,Xolo Maridueña,Belissa Escobedo', './img/reparto3img1.png,./img/reparto3img2.png,./img/reparto3img3.png', 127, '2023-09-07', 'PG-13', 'Un adolescente mexicano encuentra un escarabajo alienígena que le proporciona una armadura biotecnológica superpoderosa.', 'Acción, Aventura', './img/imgc3.jpg', NULL, 'https://www.youtube.com/watch?v=0S_C3UGazkc', 'Español,Inglés', 9.8, 1),
(4, 'Señor de los anillos', 'Michael Chaves', 'Robert Aramayo,Charles Edwards,Trystan Gravelle', './img/reparto4img1.png,./img/reparto4img2.png,./img/reparto4img3.png', 110, '2023-09-24', 'R', 'La Hermana Irene se enfrenta una vez más a la fuerza demoníaca Valak, la monja demonio.', 'Terror, Misterio', './img/imgc4.jpg', NULL, 'https://www.youtube.com/watch?v=ofDUFQolv9Y&ab_channel=WarnerBros.PicturesLatinoam%C3%A9rica', NULL, 0.0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `pelicula_id` int(11) NOT NULL,
  `pelicula_nombre` varchar(255) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `hora_reserva` time NOT NULL,
  `sala` varchar(50) NOT NULL,
  `formato` varchar(50) NOT NULL,
  `asientos` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `cliente_nombres` varchar(255) NOT NULL,
  `cliente_apellidos` varchar(255) NOT NULL,
  `cliente_dni` varchar(8) NOT NULL,
  `fecha_hora_transaccion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id`, `pelicula_id`, `pelicula_nombre`, `fecha_reserva`, `hora_reserva`, `sala`, `formato`, `asientos`, `total`, `cliente_nombres`, `cliente_apellidos`, `cliente_dni`, `fecha_hora_transaccion`) VALUES
(26, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'C6', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:06:17'),
(27, 1, 'Alien', '2024-12-17', '16:30:00', 'A', '2D Regular Doblada', 'G6', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:21:21'),
(28, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'A8', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:29:45'),
(29, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'H9, J10', 20.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:32:16'),
(30, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'C10, I10, H10, G10, F10, E10, D10, B10', 80.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:35:55'),
(31, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'A10, B10, C10, D10, E10, F10', 60.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:39:07'),
(32, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'A10, B10, C10', 30.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:45:44'),
(33, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'F5, G6', 20.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:52:24'),
(34, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'E6', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 00:57:05'),
(35, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'I8', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 01:03:49'),
(36, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'A10, B10, D10', 30.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 01:09:06'),
(37, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'D6', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 01:12:33'),
(38, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'C6, B10, E10, F10, C10', 50.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 01:16:13'),
(39, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'I10, F10, E10', 30.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 01:19:30'),
(40, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'D8', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 01:25:13'),
(41, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'E6', 10.00, 'Axel', 'B', '32910111', '2024-12-02 04:12:28'),
(42, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'B8', 10.00, 'Jose', 'Pérez García', '12345678', '2024-12-02 04:13:54'),
(43, 1, 'Alien', '2024-12-17', '19:30:00', 'A', '3D Regular Doblada', 'I9', 10.00, 'Lucas', 'Sanchez', '12345678', '2024-12-02 04:18:55'),
(44, 1, 'Alien', '2024-12-17', '19:30:00', 'A', '3D Regular Doblada', 'G8', 10.00, 'Juan', 'Pérez García', '12345678', '2024-12-02 04:23:29'),
(45, 1, 'Alien', '2024-12-17', '18:00:00', 'B', '2D Regular Doblada', 'F5', 10.00, 'Pepe', 'Perez', '12345678', '2024-12-02 12:50:33'),
(46, 1, 'Alien', '2024-12-17', '15:30:00', 'A', '2D Regular Doblada', 'J10, I10, H10, F10, E10, C10, B10, F5, G7, D6, J9, I9, H9, G9, F9, E9, D9, B9, A9, J8, I8, H8, G8, E8, F8, D8, C8, B8', 280.00, 'Jose', 'Perez', '12345678', '2024-12-02 13:46:03'),
(47, 1, 'Alien', '2024-12-17', '15:30:00', 'A', '2D Regular Doblada', 'A1,A2', 20.00, 'Marcos', 'Sanchez', '12345678', '2024-12-02 17:56:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `id` int(11) NOT NULL,
  `nombre_sala` enum('A','B','C','D') NOT NULL,
  `capacidad` int(11) NOT NULL,
  `asientos_disponibles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`id`, `nombre_sala`, `capacidad`, `asientos_disponibles`) VALUES
(1, 'A', 100, 100),
(2, 'B', 100, 100),
(3, 'C', 100, 100),
(4, 'D', 100, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_registrado`
--

CREATE TABLE `usuario_registrado` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_registrado`
--

INSERT INTO `usuario_registrado` (`id`, `nombres`, `apellidos`, `dni`, `correo`, `contrasena`) VALUES
(1, 'Mario', 'Rivera', '12345678', 'mario@gmail.com', '$2y$10$r5POS9gnKL0p07P597tpu.86eSsRkEeK.W4btwn5NiHY9BR84Gds.'),
(2, 'Roman', 'Lopez', '342413413', 'roman@correo.com', '$2y$10$Nz1CsZhz8hV0nkk.0fcZLO2A3W08s.i2NELX1MWxMMPi3WWdkH6xm'),
(3, 'Axel', 'Vasques', '32910111', 'JOSE@correo.com', '$2y$10$bZ3dN5unPBo2O4A.jD9st.t.nCYHTC2e7SnUpY5IZY3kyPqc/aDv6'),
(4, 'Pepe', 'dfdf', '78546493', 'mario@gmail.com', '$2y$10$RWumr9qkM4mx7R6bMYs9n.kgrCVKRYZnlhxFN/Q1HvYcNNPsn6RAm'),
(5, 'Jose', 'Perez', '11111111', 'JOSE123@correo.com', '$2y$10$jYKlZ.PRxu6OpFqXePhKmeNXjWkp0SMzrp.fmB2I3OAIjWDV66Gp2'),
(6, 'Joel', 'Romero', '454545411', 'joel@correo.com', '$2y$10$3L0IRUmp8QUMsILrMPKRfuK0.X7tHLLt99zBEyRaqzPDs9tGJ.e3W'),
(7, 'Luis', 'Torres', '1212121212', 'luis@correo.com', '$2y$10$FK5ZrUl4ZSvLuI6IfGapOePbe7nnvKJobIHEf/F/jU4cQgLAcnLgi'),
(8, 'Lucas', 'Lopez', '12345678', 'lucas@correo.com', '$2y$10$wQFbPIrAY8nsntkRj4EfluiOU2qDIGCDGrKq0x2fuBmvYhkGZ7nXm'),
(9, 'Pepe', 'Perez', '12321211', 'pepe@gmai.com', '$2y$10$NyXnwQRkA9yCkV6Lp38NTuddyp2woTQH/Zy2TjIcltGK7YbY13PYq'),
(10, 'cintia', 'salas', '987654321', 'cintia@correo.com', '$2y$10$dWbWBa0X8OFZIxmED2ZuLOEgVypxbti/dQ/e.AZ..E9yFprLSsrq6'),
(11, 'arc', 'fa', '542434343', 'ar@gmail.com', '$2y$10$lnSsbXqLO0RVN6ealdFM4.iNBfqS56yIjYCaXmY75onpaYko..xbu'),
(12, 'ew', 'qweqwe', '123213213', 'efad@gmail.com', '$2y$10$Kt0KLpZ8GEcJWpi20Jk5P.oyst4VKqmL4BkOamEwmVIKt0os/n5Su'),
(13, 'dfd', 'addd', '8765432132', 'gfsd@gmail.com', '$2y$10$9RbmUaOwk631I3iP22/qLuJZJoPiKn0jkIJUqhE8F3K77.gK0nt0q'),
(14, 'fad', 'gfaf', '45434324324', 'dewel@correo.com', '$2y$10$v2P.NjwRskjkGQ/zII2oA.0WjMPTSlW8mdNVixqaB4E8wdfRVYVNi'),
(15, 'gf', 'erer', '424324343', 'trtrtew@correo.com', '$2y$10$ny1nI3rc1Uj.FFP.cM7y/eVdpJXOv5jJvsKrn9WDhr2jFrr6LumhO'),
(16, 'Franck', 'Cardosa', '49432111', 'franckC@gmail.com', '$2y$10$KR4gthfwD8Gedhfaz5rX3.zEUziLqpZ8gQnvYgP7h/yZw9XHqosLW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `funcion`
--
ALTER TABLE `funcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pelicula_fecha` (`id_pelicula`,`fecha`),
  ADD KEY `idx_formato` (`formato`),
  ADD KEY `id_sala` (`id_sala`);

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fecha_estreno` (`fecha_estreno`),
  ADD KEY `idx_nombre` (`nombre`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelicula_id` (`pelicula_id`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_registrado`
--
ALTER TABLE `usuario_registrado`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `funcion`
--
ALTER TABLE `funcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario_registrado`
--
ALTER TABLE `usuario_registrado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `funcion`
--
ALTER TABLE `funcion`
  ADD CONSTRAINT `funcion_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `pelicula` (`id`),
  ADD CONSTRAINT `funcion_ibfk_2` FOREIGN KEY (`id_sala`) REFERENCES `sala` (`id`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`pelicula_id`) REFERENCES `pelicula` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
