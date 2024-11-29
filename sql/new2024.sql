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
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) DEFAULT NULL,
  `body` TEXT NOT NULL,
  `url` VARCHAR(150) NOT NULL,
  `class` VARCHAR(45) NOT NULL DEFAULT 'event-important',
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `inicio_normal` VARCHAR(50) NOT NULL,
  `final_normal` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Volcado de datos para la tabla `Agenda`
--

INSERT INTO `Agenda` (`id`, `title`, `body`, `url`, `class`, `start`, `end`, `inicio_normal`, `final_normal`) VALUES
(1, 'Prueba_1', 'Esta es la descripción', 'http://freskypan.test/linea/backend/Calendario/descripcion_evento.php?id=89', 'event-success', '2024-08-01 10:00:00', '2024-08-01 10:00:00', '10/03/2020 12:52:00', '05/03/2020 12:52:00'),
(2, 'sds', 'dsadsa', 'http://localhost/linea/backend/Calendario/descripcion_evento.php?id=90', 'event-info', '2024-08-01 10:00:00', '2024-08-01 10:00:00', '15/03/2020 12:53:00', '16/03/2020 12:53:00'),
(3, 'Esto es un titulo especial', 'el evento es especial.', 'http://localhost/linea/backend/Calendario/descripcion_evento.php?id=92', 'event-special', '2024-08-01 10:00:00', '2024-08-01 10:00:00', '19/03/2020 00:00:00', '23/03/2020 00:00:00');
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
  `ID_BODEGA` INT(2) NOT NULL,
  `descripcion` VARCHAR(50) NOT NULL,
  `estado` TINYINT(1) NOT NULL,
  PRIMARY KEY (`ID_BODEGA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoInsumo`
--

CREATE TABLE `TipoInsumo` (
  `ID_TIPOINSUMO` int(2) NOT NULL,
  `nombre` varchar(11) NOT NULL,
  PRIMARY KEY (`ID_TIPOINSUMO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `TipoInsumo` (`ID_TIPOINSUMO`, `nombre`) VALUES
(1,'Maquinaria'),(2,'Otros prod.');

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
  `FK_ID_TIPOINSUMO` int(2) NOT NULL,
  PRIMARY KEY (`ID_INSUMO`),
  KEY `FK_ID_TIPOINSUMO_INSUMO` (`FK_ID_TIPOINSUMO`),
  CONSTRAINT `FK_ID_TIPOINSUMO_INSUMO` FOREIGN KEY (`FK_ID_TIPOINSUMO`) REFERENCES `TipoInsumo` (`ID_TIPOINSUMO`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BODEGA_INSUMO`
--

CREATE TABLE `BODEGA_INSUMO` (
  `FK_ID_BODEGA` INT(2) NOT NULL,
  `FK_ID_INSUMO` INT(3) NOT NULL,
  `unidades` INT(3) NOT NULL,
  PRIMARY KEY (`FK_ID_BODEGA`, `FK_ID_INSUMO`),
  KEY `FK_ID_INSUMO_BODEGA_INSUMO` (`FK_ID_INSUMO`),
  KEY `FK_ID_BODEGA_BODEGA_INSUMO` (`FK_ID_BODEGA`),
  CONSTRAINT `FK_BODEGA_INSUMO_BODEGA` FOREIGN KEY (`FK_ID_BODEGA`) REFERENCES `Bodega` (`ID_BODEGA`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_BODEGA_INSUMO_INSUMO` FOREIGN KEY (`FK_ID_INSUMO`) REFERENCES `Insumo` (`ID_INSUMO`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `MedidaCantidad`
--

CREATE TABLE `MedidaCantidad` (
  `ID_MEDIDACANTIDAD` int(2) NOT NULL,
  `nombre` varchar(5) NOT NULL,
  PRIMARY KEY (`ID_MEDIDACANTIDAD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Volcado de datos para la tabla `MedidaCantidad`
--

INSERT INTO `MedidaCantidad` (`ID_MEDIDACANTIDAD`, `nombre`) VALUES
(1,'kg'),(2,'lb'),(3,'ton'),(4,'g'),(5,'mg'),(6,'L'),(7,'mL'),(8,'oz'),(9,'galón'),(10,'cc'),(11,'Uni');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoMateriaPrima`
--

CREATE TABLE `TipoMateriaPrima` (
  `ID_TIPOMATERIAPRIMA` int(2) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  PRIMARY KEY (`ID_TIPOMATERIAPRIMA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `FK_ID_TIPOMATERIAPRIMA` int(2) NOT NULL,
  PRIMARY KEY (`ID_MATERIAPRIMA`),
  KEY `FK_ID_TIPOMATERIAPRIMA_MateriaPrima` (`FK_ID_TIPOMATERIAPRIMA`),
  KEY `FK_ID_MEDIDACANTIDAD_MateriaPrima` (`FK_ID_MEDIDACANTIDAD`),
  CONSTRAINT `FK_ID_MEDIDACANTIDAD_MateriaPrima` FOREIGN KEY (`FK_ID_MEDIDACANTIDAD`) REFERENCES `MedidaCantidad` (`ID_MEDIDACANTIDAD`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_TIPOMATERIAPRIMA_MateriaPrima` FOREIGN KEY (`FK_ID_TIPOMATERIAPRIMA`) REFERENCES `TipoMateriaPrima` (`ID_TIPOMATERIAPRIMA`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `BODEGA_MATERIAPRIMA`
--
CREATE TABLE `BODEGA_MATERIAPRIMA` (
  `FK_ID_BODEGA` INT(2) NOT NULL,
  `FK_ID_MATERIAPRIMA` INT(3) NOT NULL,
  `FK_ID_AGENDA` INT(10) UNSIGNED NOT NULL,
  `fechaVencimiento` DATE NOT NULL,
  `unidades` INT(3) NOT NULL,
  PRIMARY KEY (`FK_ID_BODEGA`, `FK_ID_MATERIAPRIMA`, `FK_ID_AGENDA`),
  KEY `FK_ID_MATERIAPRIMA_BODEGA_MATERIAPRIMA` (`FK_ID_MATERIAPRIMA`),
  KEY `FK_ID_AGENDA_BODEGA_MATERIAPRIMA` (`FK_ID_AGENDA`),
  KEY `FK_ID_BODEGA_BODEGA_MATERIAPRIMA` (`FK_ID_BODEGA`),
  CONSTRAINT `FK_ID_BODEGA_BODEGA_MATERIAPRIMA` FOREIGN KEY (`FK_ID_BODEGA`) REFERENCES `Bodega` (`ID_BODEGA`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_AGENDA_BODEGA_MATERIAPRIMA` FOREIGN KEY (`FK_ID_AGENDA`) REFERENCES `Agenda` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_MATERIAPRIMA_BODEGA_MATERIAPRIMA` FOREIGN KEY (`FK_ID_MATERIAPRIMA`) REFERENCES `MateriaPrima` (`ID_MATERIAPRIMA`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoProducto`
--

CREATE TABLE `TipoProducto` (
  `ID_TIPOPRODUCTO` int(2) NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ID_TIPOPRODUCTO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* -- Volcado de datos para la tabla TipoProducto
INSERT INTO `TipoProducto` (`ID_TIPOPRODUCTO`, `nombre`) VALUES
(1, 'Panadería'),
(2, 'Cafetería'),
(3, 'Pastelería'),
(4, 'Chocolate y Bombones'),
(5, 'Dulces y Caramelos'); */

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `SubtipoProducto`
CREATE TABLE `SubtipoProducto` (
  `ID_SUBTIPOPRODUCTO` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `FK_ID_TIPOPRODUCTO` int(2) NOT NULL,
  PRIMARY KEY (`ID_SUBTIPOPRODUCTO`),
  KEY `FK_ID_TIPOPRODUCTO_SUBTIPOPRODUCTO` (`FK_ID_TIPOPRODUCTO`),
  CONSTRAINT `FK_ID_TIPOPRODUCTO_SUBTIPOPRODUCTO` FOREIGN KEY (`FK_ID_TIPOPRODUCTO`) REFERENCES `TipoProducto` (`ID_TIPOPRODUCTO`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `CatProducto`
--
CREATE TABLE `CatProducto` (
  `ID_CATPRODUCTO` int(2) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio` DECIMAL(10, 2) NOT NULL,
  `stock` int(3) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `duracion` int(2) NOT NULL,
  `sabor` varchar(12) NOT NULL,
  `iva` int(2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `FK_ID_SUBTIPOPRODUCTO` int(11) NOT NULL,
  PRIMARY KEY (`ID_CATPRODUCTO`),
  KEY `FK_ID_SUBTIPOPRODUCTO_CATPRODUCTO` (`FK_ID_SUBTIPOPRODUCTO`),
  CONSTRAINT `FK_ID_SUBTIPOPRODUCTO_CATPRODUCTO` FOREIGN KEY (`FK_ID_SUBTIPOPRODUCTO`) REFERENCES `SubtipoProducto` (`ID_SUBTIPOPRODUCTO`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `Id_ped` int(3) NOT NULL AUTO_INCREMENT,
  `cod_ped` VARCHAR(20) COLLATE utf8_spanish_ci NULL, -- Código de pedido
  `Fec_ped` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `hora_ped` TIME NULL, -- Hora en que se realizó el pedido
  `can_ped` int(11) NOT NULL,
  `dir_ped` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `des_ped` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cod_pro` int NOT NULL,
  `dni_cl` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `est_ped` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_act` DATE NULL, -- Fecha de última actualización del estado
  `hora_act` TIME NULL, -- Hora de última actualización del estado
  PRIMARY KEY (`Id_ped`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Devolucion`
--

CREATE TABLE `Devolucion` (
  `ID_DEVOLUCION` int(4) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `FK_ID_PEDIDO` int(6) NOT NULL,
  PRIMARY KEY (`ID_DEVOLUCION`),
  KEY `FK_ID_PEDIDO_DEVOLUCION` (`FK_ID_PEDIDO`),
  CONSTRAINT `FK_ID_PEDIDO_DEVOLUCION` FOREIGN KEY (`FK_ID_PEDIDO`) REFERENCES `Pedidos` (`ID_PED`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Factura`
--

CREATE TABLE `Factura` (
  `ID_FACTURA` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `FK_ID_PEDIDO` int(6) NOT NULL,
  PRIMARY KEY (`ID_FACTURA`),
  KEY `FK_ID_PEDIDO_FACTURA` (`FK_ID_PEDIDO`),
  CONSTRAINT `FK_ID_PEDIDO_FACTURA` FOREIGN KEY (`FK_ID_PEDIDO`) REFERENCES `Pedidos` (`ID_PED`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `ID_USUARIO` int(11) NOT NULL,
  `prNombre` varchar(50) NOT NULL,
  `prApellido` varchar(50) NOT NULL,
  `contrasena` varchar(15) NOT NULL,
  `rol` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_USUARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `TipoProducto`
--

INSERT INTO `Usuario` (`ID_USUARIO`, `prNombre`, `prApellido`, `contrasena`, `rol`) VALUES
(1, 'John', 'Doe', 'password123', 'Administrador');


--
-- Estructura de tabla para la tabla `Log`
--

CREATE TABLE `Log` (
  `ID_LOG` int(7) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` varchar(5) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `FK_ID_USUARIO` int(11) NOT NULL,
  PRIMARY KEY (`ID_LOG`),
  KEY `FK_ID_USUARIO_LOG` (`FK_ID_USUARIO`),
  CONSTRAINT `FK_ID_USUARIO_LOG` FOREIGN KEY (`FK_ID_USUARIO`) REFERENCES `Usuario` (`ID_USUARIO`) ON DELETE RESTRICT ON UPDATE CASCADE
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
CREATE TABLE `clientes` (
  `dni` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_1` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_2` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=UTF8_SPANISH_CI;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `telcl`
--

CREATE TABLE `telcl` (
  `dni` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tel_cl` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Proveedor`
--

CREATE TABLE `Proveedor` (
  `ID_PROVEEDOR` int(3) NOT NULL,
  `prNombre` varchar(10) NOT NULL,
  `segNombre` varchar(10) NOT NULL,
  `prApellido` varchar(10) NOT NULL,
  `segApellido` varchar(10) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY(`ID_PROVEEDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `PEDIDO_INSUMO`
--

CREATE TABLE `PEDIDO_INSUMO` (
  `ID_PEDIDO_INSUMO` int(3) NOT NULL AUTO_INCREMENT,
  `FK_ID_PEDIDO` int(6) NOT NULL,
  `FK_ID_INSUMO` int(3) NOT NULL,
  `precio` int(9) NOT NULL,
  `unidades` int(3) NOT NULL,
  `cancelado` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_PEDIDO_INSUMO`, `FK_ID_PEDIDO`, `FK_ID_INSUMO`),
  KEY `FK_ID_INSUMO_PEDIDO_INSUMO` (`FK_ID_INSUMO`),
  KEY `FK_ID_PEDIDO_PEDIDO_INSUMO` (`FK_ID_PEDIDO`),
  CONSTRAINT `FK_ID_INSUMO_PEDIDO_INSUMO` FOREIGN KEY (`FK_ID_INSUMO`) REFERENCES `Insumo` (`ID_INSUMO`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_PEDIDO_PEDIDO_INSUMO` FOREIGN KEY (`FK_ID_PEDIDO`) REFERENCES `pedidos` (`Id_ped`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PEDIDO_MATERIAPRIMA`
--

CREATE TABLE `PEDIDO_MATERIAPRIMA` (
  `FK_ID_PEDIDO` int(6) NOT NULL,
  `FK_ID_MATERIAPRIMA` int(3) NOT NULL,
  `precio` int(6) NOT NULL,
  `unidades` int(3) NOT NULL,
  `cancelado` tinyint(1) NOT NULL,
  PRIMARY KEY (`FK_ID_PEDIDO`, `FK_ID_MATERIAPRIMA`),
  KEY `FK_ID_MATERIAPRIMA_PEDIDO_MATERIAPRIMA` (`FK_ID_MATERIAPRIMA`),
  KEY `FK_ID_PEDIDO_PEDIDO_MATERIAPRIMA` (`FK_ID_PEDIDO`),
  CONSTRAINT `FK_ID_MATERIAPRIMA_PEDIDO_MATERIAPRIMA` FOREIGN KEY (`FK_ID_MATERIAPRIMA`) REFERENCES `MateriaPrima` (`ID_MATERIAPRIMA`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_PEDIDO_PEDIDO_MATERIAPRIMA` FOREIGN KEY (`FK_ID_PEDIDO`) REFERENCES `pedidos` (`Id_ped`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PEDIDO_PROVEEDOR`
--

CREATE TABLE `PEDIDO_PROVEEDOR` (
  `FK_ID_PEDIDO` int(6) NOT NULL,
  `FK_ID_PROVEEDOR` int(3) NOT NULL,
  PRIMARY KEY (`FK_ID_PEDIDO`, `FK_ID_PROVEEDOR`),
  KEY `FK_ID_PROVEEDOR_PEDIDO_PROVEEDOR` (`FK_ID_PROVEEDOR`),
  KEY `FK_ID_PEDIDO_PEDIDO_PROVEEDOR` (`FK_ID_PEDIDO`),
  CONSTRAINT `FK_ID_PEDIDO_PEDIDO_PROVEEDOR` FOREIGN KEY (`FK_ID_PEDIDO`) REFERENCES `pedidos` (`Id_ped`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_PROVEEDOR_PEDIDO_PROVEEDOR` FOREIGN KEY (`FK_ID_PROVEEDOR`) REFERENCES `Proveedor` (`ID_PROVEEDOR`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Produccion`
--

CREATE TABLE `Produccion` (
  `ID_PRODUCCION` int(7) NOT NULL,
  `FK_ID_AGENDA` int(10) UNSIGNED NOT NULL,
  `fechaProduccion` date NOT NULL,
  `unidades` int(3) NOT NULL,
  `cantidadInicial` int(2) NOT NULL,
  `FK_ID_CATPRODUCTO` int(2) NOT NULL,
  PRIMARY KEY (`ID_PRODUCCION`, `FK_ID_AGENDA`),
  KEY `FK_ID_AGENDA_PRODUCCION` (`FK_ID_AGENDA`),
  KEY `FK_ID_CATPRODUCTO_PRODUCCION` (`FK_ID_CATPRODUCTO`),
  CONSTRAINT `FK_ID_AGENDA_PRODUCCION` FOREIGN KEY (`FK_ID_AGENDA`) REFERENCES `Agenda` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_CATPRODUCTO_PRODUCCION` FOREIGN KEY (`FK_ID_CATPRODUCTO`) REFERENCES `CatProducto` (`ID_CATPRODUCTO`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------
--
-- Disparadores `produccion`
--
DELIMITER $$
CREATE TRIGGER `prtg` BEFORE INSERT ON `Produccion` FOR EACH ROW SET NEW.`ID_PRODUCCION` = (
       SELECT IFNULL(MAX(ID_PRODUCCION), 0) + 1
       FROM produccion
       
         
    )
$$
DELIMITER ;

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `PROVEEDOR_INSUMO`
--

CREATE TABLE `PROVEEDOR_INSUMO` (
  `FK_ID_PROVEEDOR` int(3) NOT NULL,
  `FK_ID_INSUMO` int(3) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`FK_ID_PROVEEDOR`, `FK_ID_INSUMO`),
  KEY `FK_ID_INSUMO_PROVEEDOR_INSUMO` (`FK_ID_INSUMO`),
  KEY `FK_ID_PROVEEDOR_PROVEEDOR_INSUMO` (`FK_ID_PROVEEDOR`),
  CONSTRAINT `FK_ID_INSUMO_PROVEEDOR_INSUMO` FOREIGN KEY (`FK_ID_INSUMO`) REFERENCES `Insumo` (`ID_INSUMO`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_PROVEEDOR_PROVEEDOR_INSUMO` FOREIGN KEY (`FK_ID_PROVEEDOR`) REFERENCES `Proveedor` (`ID_PROVEEDOR`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PROVEEDOR_MATERIAPRIMA`
--

CREATE TABLE `PROVEEDOR_MATERIAPRIMA` (
  `FK_ID_MATERIAPRIMA` int(3) NOT NULL,
  `FK_ID_PROVEEDOR` int(3) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`FK_ID_MATERIAPRIMA`, `FK_ID_PROVEEDOR`),
  KEY `FK_ID_PROVEEDOR_PROVEEDOR_MATERIAPRIMA` (`FK_ID_PROVEEDOR`),
  KEY `FK_ID_MATERIAPRIMA_PROVEEDOR_MATERIAPRIMA` (`FK_ID_MATERIAPRIMA`),
  CONSTRAINT `FK_ID_MATERIAPRIMA_PROVEEDOR_MATERIAPRIMA` FOREIGN KEY (`FK_ID_MATERIAPRIMA`) REFERENCES `MateriaPrima` (`ID_MATERIAPRIMA`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_PROVEEDOR_PROVEEDOR_MATERIAPRIMA` FOREIGN KEY (`FK_ID_PROVEEDOR`) REFERENCES `Proveedor` (`ID_PROVEEDOR`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Telefono`
--
CREATE TABLE `Telefono` (
  `FK_ID_PROVEEDOR` int(11) NOT NULL,
  `ID_TELEFONO` varchar(10) NOT NULL,
  PRIMARY KEY (`FK_ID_PROVEEDOR`, `ID_TELEFONO`),
  KEY `FK_ID_PROVEEDOR_TELEFONO` (`FK_ID_PROVEEDOR`),
  CONSTRAINT `FK_ID_PROVEEDOR_TELEFONO` FOREIGN KEY (`FK_ID_PROVEEDOR`) REFERENCES `Proveedor` (`ID_PROVEEDOR`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Venta`
--

CREATE TABLE `Venta` (
  `ID_VENTA` int(7) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`ID_VENTA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VENTA_PRODUCCION`
--

CREATE TABLE `VENTA_PRODUCCION` (
  `FK_ID_PRODUCCION` int(7) NOT NULL,
  `FK_ID_VENTA` int(7) NOT NULL,
  `cantidad` int(2) NOT NULL,
  PRIMARY KEY (`FK_ID_PRODUCCION`, `FK_ID_VENTA`),
  KEY `FK_ID_VENTA_VENTA` (`FK_ID_VENTA`),
  KEY `FK_ID_PRODUCCION_VENTA` (`FK_ID_PRODUCCION`),
  CONSTRAINT `FK_ID_PRODUCCION_VENTA_PRODUCCION` FOREIGN KEY (`FK_ID_PRODUCCION`) REFERENCES `Produccion` (`ID_PRODUCCION`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_VENTA_VENTA` FOREIGN KEY (`FK_ID_VENTA`) REFERENCES `Venta` (`ID_VENTA`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Estructura de tabla para la tabla `DEVOLUCION_MATERIAPRIMA`
--
CREATE TABLE `DEVOLUCION_MATERIAPRIMA` (
  `FK_ID_DEVOLUCION` int(4) NOT NULL,
  `FK_ID_MATERIAPRIMA` int(3) NOT NULL,
  `cancelado` tinyint(1) NOT NULL,
  PRIMARY KEY (`FK_ID_MATERIAPRIMA`, `FK_ID_DEVOLUCION`),
  KEY `FK_ID_MATERIAPRIMA_DEVOLUCION_MATERIAPRIMA` (`FK_ID_MATERIAPRIMA`),
  KEY `FK_ID_DEVOLUCION_DEVOLUCION_MATERIAPRIMA` (`FK_ID_DEVOLUCION`),
  CONSTRAINT `FK_ID_MATERIAPRIMA_DEVOLUCION_MATERIAPRIMA` FOREIGN KEY (`FK_ID_MATERIAPRIMA`) REFERENCES `MateriaPrima` (`ID_MATERIAPRIMA`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_DEVOLUCION_DEVOLUCION_MATERIAPRIMA` FOREIGN KEY (`FK_ID_DEVOLUCION`) REFERENCES `Devolucion` (`ID_DEVOLUCION`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `DEVOLUCION_INSUMO`
--
CREATE TABLE `DEVOLUCION_INSUMO` (
  `FK_ID_DEVOLUCION` int(4) NOT NULL,
  `FK_ID_INSUMO` int(3) NOT NULL,
  `cancelado` tinyint(1) NOT NULL,
  PRIMARY KEY (`FK_ID_INSUMO`, `FK_ID_DEVOLUCION`),
  KEY `FK_ID_INSUMO_DEVOLUCION_INSUMO` (`FK_ID_INSUMO`),
  KEY `FK_ID_DEVOLUCION_DEVOLUCION_INSUMO` (`FK_ID_DEVOLUCION`),
  CONSTRAINT `FK_ID_INSUMO_DEVOLUCION_INSUMO` FOREIGN KEY (`FK_ID_INSUMO`) REFERENCES `Insumo` (`ID_INSUMO`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `FK_ID_DEVOLUCION_DEVOLUCION_INSUMO` FOREIGN KEY (`FK_ID_DEVOLUCION`) REFERENCES `Devolucion` (`ID_DEVOLUCION`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `Mensajes`
--
CREATE TABLE mensaje (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nombre VARCHAR(300) NULL,
    telefono VARCHAR(20) NULL,
    direccion VARCHAR(300) NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE redes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    red_social VARCHAR(255) NOT NULL,
    url VARCHAR(255) DEFAULT NULL,
    estado TINYINT(1) DEFAULT 1
);

INSERT INTO redes (red_social, url, estado) VALUES
('Facebook', NULL, 1),
('WhatsApp', NULL, 1);


INSERT INTO tipoproducto (ID_TIPOPRODUCTO, nombre) VALUES
(1, 'Panadería'),
(2, 'Cafetería'),
(3, 'Pastelería'),
(4, 'Chocolate y tipoproductoBombones'),
(5, 'Dulces y Caramelos'),
(6, 'Bollería salada'),
(7, 'Bollería dulce');


INSERT INTO subtipoproducto (ID_SUBTIPOPRODUCTO, nombre, FK_ID_TIPOPRODUCTO) VALUES
(1, 'Pan crujiente', 1),
(2, 'Panes Regionales', 1),
(3, 'PANES BLANCOS', 1),
(4, 'PANES INTEGRALES', 1),
(5, 'PANES ESPECIALES', 1),
(6, 'PANES PLANOS', 1),
(7, 'PANES ENRIQUECIDOS', 1),
(8, 'PANES DULCES', 1),
(9, 'PAN DE AJO', 1);


ALTER TABLE `pedidos`
ADD COLUMN `cod_ped` VARCHAR(20) COLLATE utf8_spanish_ci NULL,
ADD COLUMN `hora_ped` TIME NULL,
ADD COLUMN `fecha_act` DATE NULL,
ADD COLUMN `hora_act` TIME NULL;



-- Nuevos campos para la tabla pedidos 21-11-2024
ALTER TABLE pedidos
ADD COLUMN referencia_opc TEXT NULL AFTER distrito,
ADD COLUMN tipo_envio BOOLEAN NULL AFTER referencia_opc,
ADD COLUMN precio_unit DECIMAL(10,2) AFTER can_ped,
ADD COLUMN total DECIMAL(10,2) AFTER precio_unit;

ALTER TABLE pedidos
ADD COLUMN fecha_recojo DATE,
ADD COLUMN hora_recojo TIME;
