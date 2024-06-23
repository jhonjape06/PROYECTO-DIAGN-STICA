-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2024 a las 00:24:24
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
-- Base de datos: `bd-diagnostica-ips`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `estado_stock` varchar(50) NOT NULL,
  `codigo_art` varchar(50) NOT NULL,
  `nombre_art` varchar(100) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `descrip` text NOT NULL,
  `valor_art` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valor_total` decimal(10,2) GENERATED ALWAYS AS (`cantidad` * `valor_art`) STORED,
  `cantidad_stock_minimo` int(11) NOT NULL,
  `dias_pedido` date DEFAULT NULL,
  `cantidad_nvo_ped` int(11) DEFAULT NULL,
  `articulo_descontinuado` enum('Sí','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `estado_stock`, `codigo_art`, `nombre_art`, `proveedor`, `descrip`, `valor_art`, `cantidad`, `cantidad_stock_minimo`, `dias_pedido`, `cantidad_nvo_ped`, `articulo_descontinuado`) VALUES
(19, '', '123456789', 'GUANTES LT', 'EMERMEDIC', 'GUANTES DE LATEX', 52000.00, 2, 5, '2024-06-20', 10, 'No'),
(20, '', '123456798', 'BATAS ML', 'DISPAPELES', 'BATAS MANGA LARGA', 2500.00, 10, 4, '2024-06-28', 10, 'No'),
(21, '', '123456987', 'PAPEL R', 'EXITO', 'ROLLO DE PAPEL TRIPLE HOJA', 4500.00, 10, 2, '2024-06-26', 10, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_sedes`
--

CREATE TABLE `inventario_sedes` (
  `id` int(11) NOT NULL,
  `sede` varchar(250) NOT NULL,
  `codigo_art` varchar(250) NOT NULL,
  `nombre_art` varchar(250) NOT NULL,
  `descrip` varchar(250) NOT NULL,
  `cantidad` int(20) NOT NULL,
  `cantidad_stock_minimo` int(20) NOT NULL,
  `dias_pedido` date NOT NULL,
  `cantidad_nvo_ped` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `inventario_sedes`
--

INSERT INTO `inventario_sedes` (`id`, `sede`, `codigo_art`, `nombre_art`, `descrip`, `cantidad`, `cantidad_stock_minimo`, `dias_pedido`, `cantidad_nvo_ped`) VALUES
(1, '', '900271266', 'papeles', 'papeles doble hoja', 12, 5, '2023-01-01', 10),
(2, '', '587499680', 'libros', 'libros grandes', 10, 4, '2023-01-01', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `user`, `password`, `email`, `rol`) VALUES
(1, 'Administrador', '123456', 'admin@gmail.com', 'administrador'),
(7, 'jhon peñaranda', '123456', 'jhonjape06@gmail.com', 'logistica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nit` int(250) NOT NULL,
  `empresa` varchar(250) NOT NULL,
  `contacto` varchar(250) NOT NULL,
  `telefono` int(10) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `ciudad` varchar(250) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nit`, `empresa`, `contacto`, `telefono`, `direccion`, `ciudad`, `correo`) VALUES
(6, 45458545, 'EXITO', 'DIANA CORTES', 25458254, 'AVENIDA SIEMPREVIVA ', 'BOGOTA', 'EXITO@GMAIL.COM'),
(9, 900271266, 'COLSUBSIDIO', 'MARIA MENESES', 2147483647, 'CALLE 3 #35-54', 'CUCUTA', 'COLSUBSIDIO@GMAIL.COM'),
(12, 2147483647, 'EMERMEDIC', 'MARTHA PEREZ', 2147483647, 'AVENIDA SIEMPREVIVA ', 'CUCUTA', 'EMERMEDIC@GMAIL.COM'),
(13, 2147483647, 'DISPAPELES', 'MARTHA CARDENAS', 25458545, 'CALLE 54 #21-54', 'CALI', 'DISPAPELES@GMAIL.COM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` int(11) NOT NULL,
  `nombre_sede` varchar(250) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `barrio` varchar(250) NOT NULL,
  `ciudad` varchar(250) NOT NULL,
  `coordinador` varchar(250) NOT NULL,
  `telefono` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id`, `nombre_sede`, `direccion`, `barrio`, `ciudad`, `coordinador`, `telefono`) VALUES
(1, 'santa clara', 'calle 3 #20-36', 'el dorado', 'bogota', 'carlos perez', '3122544787'),
(2, 'san blas', 'calle 12 #25-62', 'centro', 'bogota', 'sandra muñoz', '3155455854');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario_sedes`
--
ALTER TABLE `inventario_sedes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `inventario_sedes`
--
ALTER TABLE `inventario_sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
