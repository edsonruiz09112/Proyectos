-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2025 a las 09:20:13
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
-- Base de datos: `proyecto1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'comprador',
  `eliminado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `correo`, `password`, `rol`, `eliminado`) VALUES
(1, 'Admin', 'General', 'admin@alumnos.udg.mx', '202cb962ac59075b964b07152d234b70', 'admin', 0),
(2, 'Vendedor', 'Prueba', 'vendedor@alumnos.udg.mx', '202cb962ac59075b964b07152d234b70', 'vendedor', 0),
(3, 'Alumno', 'Comprador', 'alumno@alumnos.udg.mx', '202cb962ac59075b964b07152d234b70', 'comprador', 0),
(4, 'poncho', 'chino', 'poncho@alumnos.udg.mx', 'c4ca4238a0b923820dcc509a6f75849b', 'comprador', 0),
(5, 'migue', 'forever', 'costco@alumnos.udg.mx', 'c81e728d9d4c2f636f067f89cc14862c', 'vendedor', 0),
(7, 'Emiliano', 'Espinoza', 'emiliano.espinoza5028@alumnos.udg.mx', '$2y$10$7G/.Mla8svGtuws7xUz4oeOEaecKnQ121ANkOCeVcIjZkjHoXyfO6', 'vendedor', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `metodo_pago` varchar(50) DEFAULT 'Efectivo',
  `lugar_entrega` varchar(255) DEFAULT 'CUCEI - Entrada Principal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `fecha`, `status`, `metodo_pago`, `lugar_entrega`) VALUES
(1, 2, '2025-11-29 18:47:13', 1, 'Efectivo', 'Ciber Jardín - Nota: nos vemos al rato papi 8:00'),
(2, 4, '2025-11-29 18:48:31', 1, 'Efectivo', 'Ciber Jardín - Nota: telaomes'),
(3, 4, '2025-11-29 18:54:16', 2, 'PayPal', 'Entrada Principal (Blvd. Marcelino García) - Nota: af'),
(4, 4, '2025-11-29 19:05:15', 2, 'PayPal', 'Entrada Principal (Olimpica) - Nota: fwf'),
(5, 4, '2025-11-29 19:40:32', 1, 'Efectivo', 'Entrada Principal (Olimpica) - Nota: 123124'),
(6, 7, '2025-12-02 08:29:22', 2, 'PayPal', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(7, 7, '2025-12-02 08:35:42', 2, 'PayPal', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(8, 7, '2025-12-02 08:39:07', 1, 'Efectivo', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(9, 7, '2025-12-02 08:39:18', 2, 'PayPal', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(10, 7, '2025-12-02 08:39:34', 1, 'Efectivo', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(11, 7, '2025-12-02 08:39:44', 1, 'Efectivo', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(12, 7, '2025-12-02 08:40:00', 1, 'Efectivo', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(13, 7, '2025-12-02 08:40:10', 1, 'Efectivo', 'Entrada Principal (Blvd. Marcelino) - Nota: '),
(14, 7, '2025-12-02 08:40:20', 1, 'Efectivo', 'Entrada Principal (Blvd. Marcelino) - Nota: ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_productos`
--

CREATE TABLE `pedidos_productos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos_productos`
--

INSERT INTO `pedidos_productos` (`id`, `pedido_id`, `vendedor_id`, `producto_id`, `cantidad`, `precio`) VALUES
(1, 1, 2, 2, 1, 320.00),
(2, 2, 2, 2, 1, 320.00),
(3, 3, 2, 2, 8, 320.00),
(4, 3, 2, 1, 3, 250.00),
(5, 4, 2, 1, 1, 250.00),
(6, 5, 5, 5, 1, 111.00),
(7, 6, 5, 3, 1, 111.00),
(8, 7, 5, 4, 1, 111.00),
(9, 8, 5, 5, 1, 111.00),
(10, 9, 5, 6, 1, 111.00),
(11, 10, 5, 6, 2, 111.00),
(12, 11, 5, 5, 1, 111.00),
(13, 12, 5, 3, 2, 111.00),
(14, 13, 5, 4, 2, 111.00),
(15, 14, 2, 1, 6, 250.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `producto_id`, `usuario_id`, `pregunta`, `respuesta`, `fecha`) VALUES
(1, 3, 4, 'de cual año es?\r\n', NULL, '2025-11-29 12:31:11'),
(2, 5, 7, 'Que hace el producto?', NULL, '2025-12-02 01:28:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `vendedor_id` int(11) NOT NULL DEFAULT 1,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `codigo` varchar(50) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `eliminado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `vendedor_id`, `nombre`, `descripcion`, `codigo`, `archivo`, `precio`, `costo`, `stock`, `eliminado`) VALUES
(1, 2, 'Calculadora Científica', 'Calculadora ideal para cálculo y física.', 'CALC-001', NULL, 250.00, 150.00, 0, 0),
(2, 2, 'Bata de Laboratorio', 'Talla M, algodón 100%.', 'BATA-M', NULL, 320.00, 200.00, 0, 0),
(3, 5, '1', '', '123', 'prod_1764440983.jpg', 111.00, 100.00, 0, 0),
(4, 5, '2', '', '123', 'prod_1764441223.png', 111.00, 100.00, 0, 0),
(5, 5, '2', '', '123', 'prod_1764441378.png', 111.00, 100.00, 0, 0),
(6, 5, '3', '', '123', 'prod_1764441568.jpg', 111.00, 100.00, 0, 0),
(7, 7, 'Disco de Vinilo - The Complete Village Vanguard Recordings 1961 - Bill Evans', 'Disco de Vinilo de Bill Evans', 'DISC-BILLEVANS', 'prod_1764661745_692e99f1cba2d.jpg', 700.00, 550.00, 1, 1),
(8, 7, 'Disco de Vinilo - The Complete Village Vanguard Recordings 1961 - Bill Evans', 'Disco de Vinilo de Bill Evans', 'DISC-BILLEVANS', 'prod_1764661752_692e99f8d1df5.jpg', 700.00, 550.00, 1, 1),
(9, 7, 'Disco de Vinilo - The Complete Village Vanguard Recordings 1961 - Bill Evans', 'Disco de Vinilo de Bill Evans', 'DISC-BILLEVANS', 'prod_1764661761_692e9a01e7d43.jpg', 700.00, 550.00, 1, 1),
(10, 7, 'Disco de Vinilo - The Complete Village Vanguard Recordings 1961 - Bill Evans', 'Disco de Vinilo de Bill Evans', 'DISC-BILLEVANS', 'prod_1764661869_692e9a6dab59e.jpg', 700.00, 550.00, 1, 1),
(11, 7, 'Disco de Vinilo - The Complete Village Vanguard Recordings 1961 - Bill Evans', 'Disco de vinilo del emblemático trio de Jazz de Bill Evans, en este disco se encuentran todas sus grabaciones del icónico bar neoyorkino famosamente conocido como el \"Village Vanguard\".', 'DISC-BILLEVANS', 'prod_1764662045_692e9b1d39b3f.jpg', 700.00, 550.00, 1, 0),
(12, 7, 'Disco de Vinilo - Ram - Linda Mccartney, Paul Mccartney', 'Disco de vinilo Ram del beatle Paul Mccartney, su segundo album solista con un sonido nuevo y deslumbrante', 'DISC-MACCARTNEY', 'prod_1764662486_692e9cd676afe.jpg', 900.00, 750.00, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) DEFAULT NULL,
  `archivo` varchar(128) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `eliminado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `nombre`, `archivo`, `status`, `eliminado`) VALUES
(1, 'Bienvenida', 'banner_dummy.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

CREATE TABLE `resenas` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resenas`
--

INSERT INTO `resenas` (`id`, `producto_id`, `usuario_id`, `calificacion`, `comentario`, `fecha`) VALUES
(1, 2, 4, 3, 'es telatragas', '2025-11-29 11:48:15'),
(2, 3, 4, 5, 'depelos', '2025-11-29 12:31:00'),
(3, 5, 4, 5, '123', '2025-11-29 12:39:55'),
(4, 5, 7, 5, 'cagada de vendedor', '2025-12-02 01:30:18'),
(5, 5, 7, 5, 'wawaw', '2025-12-02 01:32:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pedidos_productos`
--
ALTER TABLE `pedidos_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
