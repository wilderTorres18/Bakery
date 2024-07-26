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
-- Estructura de tabla para la tabla `Devolucion`
--

CREATE TABLE `Devolucion` (
  `ID_DEVOLUCION` int(4) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `FK_ID_PEDIDO` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Factura`
--

CREATE TABLE `Factura` (
  `ID_FACTURA` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `FK_ID_PEDIDO` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Insumo`
--

CREATE TABLE `Insumo` (
  `ID_INSUMO` int(3) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `stock` int(3) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` int(9) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `iva` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `FK_ID_TIPOINSUMO` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Log`
--

CREATE TABLE `Log` (
  `ID_LOG` int(7) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` varchar(5) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `FK_ID_USUARIO` int(11) NOT NULL,
  PRIMARY KEY (ID_LOG)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Disparadores `log`
--
DELIMITER $$
CREATE TRIGGER `logtg` BEFORE INSERT ON `Log` FOR EACH ROW SET NEW.`ID_LOG` = (
       SELECT IFNULL(MAX(ID_LOG), 0) + 1
       FROM Log
       
         
    )
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MateriaPrima`
--

CREATE TABLE `MateriaPrima` (
  `ID_MATERIAPRIMA` int(3) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `cantidad` int(2) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` int(6) NOT NULL,
  `iva` int(2) NOT NULL,
  `stock` int(3) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `FK_ID_MEDIDACANTIDAD` int(2) NOT NULL,
  `FK_ID_TIPOMATERIAPRIMA` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MedidaCantidad`
--

CREATE TABLE `MedidaCantidad` (
  `ID_MEDIDACANTIDAD` int(2) NOT NULL,
  `nombre` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `MedidaCantidad`
--

INSERT INTO `MedidaCantidad` (`ID_MEDIDACANTIDAD`, `nombre`) VALUES
(1,'kg'),(2,'lb'),(3,'ton'),(4,'g'),(5,'mg'),(6,'L'),(7,'mL'),(8,'oz'),(9,'galón'),(10,'cc'),(11,'Uni');

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
