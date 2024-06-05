-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-11-2016 a las 08:07:53
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `id` INT(11) NOT NULL,
  `estado_stock` VARCHAR(250) NOT NULL,
  `codigo_art` VARCHAR(250) NOT NULL,
  `nombre_art` VARCHAR(250) NOT NULL,
  `proveedor` VARCHAR(250) NOT NULL,
  `descrip` VARCHAR(250) NOT NULL,
  `valor_art` VARCHAR(250) NOT NULL,
  `cantidad` INT(250) NOT NULL,
  `valor_total` VARCHAR(250) NOT NULL,
  `cantidad_stock_minimo` VARCHAR(100) NOT NULL,
  `dias_pedido` DATE(100) NOT NULL,
  `cantidad_nvo_ped` VARCHAR(100) NOT NULL,
  `articulo_descontinuado` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `estado_stock`, `codigo_art`, `nombre_art`, `proveedor`, `descrip`, `valor_art`, `cantidad`, `valor_total`, `cantidad_stock_minimo`, `dias_pedido`, `cantidad_nvo_ped`, `articulo_descontinuado`) VALUES
(1, '', '900271266', 'papeles', 'dispapeles', 'papeles doble hoja', '20000' ,'12', '', '5', '', '10', ''),
(2, '', '587499680', 'libros', 'dispapeles', 'libros grandes', '30000' ,'10', '', '4', '', '10', '');


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
