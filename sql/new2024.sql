-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2020 a las 16:28:15
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `panaderiaerp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Agenda`
--
CREATE TABLE `Agenda` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `body` text NOT NULL,
  `url` varchar(150) NOT NULL,
  `class` varchar(45) NOT NULL DEFAULT 'event-important',
  `start` varchar(15) NOT NULL,
  `end` varchar(15) NOT NULL,
  `inicio_normal` varchar(50) NOT NULL,
  `final_normal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `Agenda`
--

INSERT INTO `Agenda` (`id`, `title`, `body`, `url`, `class`, `start`, `end`, `inicio_normal`, `final_normal`) VALUES
(1, 'Prueba_1', 'Esta es la descripción', 'http://freskypan.test/linea/backend/Calendario/descripcion_evento.php?id=89', 'event-success', '1583862720000', '1583430720000', '10/03/2020 12:52:00', '05/03/2020 12:52:00'),
(2, 'sds', 'dsadsa', 'http://localhost/linea/backend/Calendario/descripcion_evento.php?id=90', 'event-info', '1584294780000', '1584381180000', '15/03/2020 12:53:00', '16/03/2020 12:53:00'),
(3, 'Esto es un titulo especial', 'el evento es especial.', 'http://localhost/linea/backend/Calendario/descripcion_evento.php?id=92', 'event-special', '1584594000000', '1584939600000', '19/03/2020 00:00:00', '23/03/2020 00:00:00');

-- --------------------------------------------------------
--
-- Disparadores `agenda`
--
DELIMITER $$
CREATE TRIGGER `AGENDA` BEFORE INSERT ON `Agenda` FOR EACH ROW BEGIN
    SET NEW.`id` = (
       SELECT IFNULL(MAX(id), 0) + 1
       FROM Agenda 
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `Bodega`
--

CREATE TABLE `Bodega` (
  `ID_BODEGA` int(2) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BODEGA_INSUMO`
--

CREATE TABLE `BODEGA_INSUMO` (
  `FK_ID_BODEGA` int(2) NOT NULL,
  `FK_ID_INSUMO` int(3) NOT NULL,
  `unidades` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BODEGA_MATERIAPRIMA`
--

CREATE TABLE `BODEGA_MATERIAPRIMA` (
  `FK_ID_BODEGA` int(2) NOT NULL,
  `FK_ID_MATERIAPRIMA` int(3) NOT NULL,
  `FK_ID_AGENDA` int(10) UNSIGNED NOT NULL,
  `fechaVencimiento` date NOT NULL,
  `unidades` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatProducto`
--

CREATE TABLE `CatProducto` (
  `ID_CATPRODUCTO` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` int(6) NOT NULL,
  `stock` int(3) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `duracion` int(2) NOT NULL,
  `sabor` varchar(12) NOT NULL,
  `iva` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `FK_ID_SUBTIPOPRODUCTO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Bodega`
--
ALTER TABLE `Bodega`
  ADD PRIMARY KEY (`ID_BODEGA`);

--
-- Indices de la tabla `Bodega`
--
ALTER TABLE `Agenda`
  ADD PRIMARY KEY (`id`);
