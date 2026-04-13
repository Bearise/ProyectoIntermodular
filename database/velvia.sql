-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 13-04-2026 a las 23:56:30
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `velvia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_usuario`, `id_producto`, `cantidad`, `fecha_creacion`) VALUES
(11, 1, 15, 1, '2026-04-12 17:09:19'),
(12, 1, 16, 1, '2026-04-12 17:09:28'),
(13, 1, 18, 1, '2026-04-13 17:02:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Velas', 'Velas artesanales con cera de soja y aceites naturales'),
(2, 'Bálsamos', 'Bálsamos labiales y corporales de ingredientes orgánicos'),
(3, 'Jabones', 'Jabones artesanales elaborados con técnicas tradicionales'),
(4, 'Brumas', 'Brumas místicas para el hogar y textiles'),
(5, 'Aceites esenciales', 'Extractos puros de plantas para aromaterapia'),
(6, 'Packs', 'Conjuntos de productos para regalo o rituales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `calle` varchar(150) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id_direccion`, `id_usuario`, `calle`, `numero`, `ciudad`, `provincia`, `codigo_postal`, `pais`) VALUES
(1, 1, 'Venezuela', '33', 'Morón de la frontera', 'Sevilla', '41530', 'España');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `metodo` enum('tarjeta','paypal','transferencia') NOT NULL,
  `estado` enum('pendiente','completado','fallido') DEFAULT 'pendiente',
  `fecha_pago` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `estado_pedido` enum('pendiente','enviado','entregado','cancelado') DEFAULT 'pendiente',
  `total` decimal(10,2) DEFAULT NULL,
  `id_direccion` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `fecha_pedido`, `estado_pedido`, `total`, `id_direccion`, `id_usuario`) VALUES
(1, '2026-04-12 13:34:49', 'pendiente', 39.80, 1, 1),
(2, '2026-04-12 19:00:10', 'pendiente', 39.30, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto`
--

CREATE TABLE `pedido_producto` (
  `id_pedido_producto` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedido_producto`
--

INSERT INTO `pedido_producto` (`id_pedido_producto`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 2, 1, 18.00),
(2, 1, 9, 1, 6.90),
(3, 1, 11, 1, 14.90),
(4, 2, 6, 2, 7.95),
(5, 2, 5, 1, 8.50),
(6, 2, 11, 1, 14.90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `seguro_hogar` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `precio`, `imagen`, `id_categoria`, `seguro_hogar`) VALUES
(1, 'Vela Canela y Naranja', 'Aroma cálido y especiado.', 18.00, 'assets/images/products/velas/canelaynaranja.png', 1, 1),
(2, 'Vela Frutos Rojos', 'Dulce y vibrante aroma a bayas.', 18.00, 'assets/images/products/velas/frutosrojos.png', 1, 1),
(3, 'Vela de Rosas', 'Elegante fragancia floral clásica.', 18.00, 'assets/images/products/velas/rosas.png', 1, 1),
(4, 'Vela de Vainilla', 'Clásico aroma relajante y dulce.', 18.00, 'assets/images/products/velas/vainilla.png', 1, 1),
(5, 'Bálsamo Avena y Miel', 'Hidratación profunda natural.', 8.50, 'assets/images/products/balsamos/balsamoavenamiel.png', 2, 1),
(6, 'Bálsamo Cacao y Almendra', 'Protección y suavidad.', 7.95, 'assets/images/products/balsamos/balsamocacaoalmendra.png', 2, 1),
(7, 'Bálsamo Menta y Lima', 'Reparador refrescante.', 7.95, 'assets/images/products/balsamos/balsamomentalima.png', 2, 1),
(8, 'Jabón Avena y Miel', 'Limpieza suave para pieles sensibles.', 6.50, 'assets/images/products/jabones/avenamiel.png', 3, 1),
(9, 'Jabón Lavanda y Karité', 'Extra de hidratación y relax.', 6.90, 'assets/images/products/jabones/lavandakarite.png', 3, 1),
(10, 'Jabón Naranjo en Flor', 'Aroma cítrico y revitalizante.', 6.50, 'assets/images/products/jabones/naranjoenflor.png', 3, 1),
(11, 'Bruma de Almohada', 'Relajante para el sueño.', 14.90, 'assets/images/products/brumas/almohada.jpg', 4, 1),
(12, 'Bruma Corporal', 'Fragancia ligera natural.', 12.50, 'assets/images/products/brumas/corporal.png', 4, 1),
(13, 'Bruma Energética', 'Revitaliza tu ambiente.', 13.50, 'assets/images/products/brumas/energetica.png', 4, 1),
(14, 'Aceite Árbol de Té', 'Antiséptico natural potente.', 10.00, 'assets/images/products/aceites/aceitearboldete.png', 5, 0),
(15, 'Aceite de Eucalipto', 'Ideal para despejar las vías respiratorias.', 9.50, 'assets/images/products/aceites/aceiteeucalipto.png', 5, 0),
(16, 'Aceite de Lavanda', 'El aceite esencial más versátil y relajante.', 11.00, 'assets/images/products/aceites/aceitelavanda.png', 5, 1),
(17, 'Pack Relax', 'Un ritual completo para desconectar del día. Incluye:\n- Vela Canela y Naranja\n- Aceite Esencial de Lavanda\n- Jabón Lavanda y Karité', 29.90, 'assets/images/products/packs/pack-relax.png', 6, 1),
(18, 'Pack Cuidado Natural', 'Transforma tu rutina diaria en un momento de autocuidado. Incluye:\n- Jabón Avena y Miel\n- Bálsamo Cacao y Almendras\n- Bruma corporal', 22.99, 'assets/images/products/packs/pack-cuidado-natural.png', 6, 1),
(19, 'Pack Ritual Nocturno', 'Diseñado para acompañarte en tu rutina nocturna. Incluye:\n- Vela Vainilla\n- Bruma de almohada\n- Bálsamo labial Avena y Miel', 35.90, 'assets/images/products/packs/pack-ritual-nocturno.png', 6, 1),
(21, 'Bálsamo labial lavanda', 'Bálsamo labial hidratante y calmante con aceite esencial de lavanda', 5.99, 'assets/images/products/balsamos/balsamo-lavanda.png', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') DEFAULT 'cliente',
  `fecha_registro` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellidos`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Beatriz', 'Ríos Serrano', 'bearise@velvia.com', '$2y$10$8lwmT2xO59WBqRL2GTqkuO8MnVXXFa.YlnBic1DYrFcsXn6mjVGwq', 'admin', '2026-04-09 22:06:57');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD UNIQUE KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_direccion` (`id_direccion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD PRIMARY KEY (`id_pedido_producto`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  MODIFY `id_pedido_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_direccion`) REFERENCES `direccion` (`id_direccion`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD CONSTRAINT `pedido_producto_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `pedido_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
