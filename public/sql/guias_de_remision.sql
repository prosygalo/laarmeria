-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 31-08-2021 a las 06:39:45
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `guias_de_remision`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autorizaciones_sar`
--

DROP TABLE IF EXISTS `autorizaciones_sar`;
CREATE TABLE IF NOT EXISTS `autorizaciones_sar` (
  `Cod_Autorizacion` int(18) NOT NULL AUTO_INCREMENT,
  `Cai` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Inicial_Establ` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Inicial_Punto` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Inicial_Tipo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Inicial_Correlativo` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Final_Establ` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Final_Punto` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Final_Tipo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Final_Correlativo` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Actual_Establ` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Consecutivo_Actual_Punto` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Consecutivo_Actual_Tipo` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Consecutivo_Actual_Correlativo` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Sucursal` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Limite` date NOT NULL,
  `Fecha_Ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod_Autorizacion`),
  UNIQUE KEY `Cai` (`Cai`),
  KEY `Fk_Sucursal_Sar` (`Sucursal`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `autorizaciones_sar`
--

INSERT INTO `autorizaciones_sar` (`Cod_Autorizacion`, `Cai`, `Consecutivo_Inicial_Establ`, `Consecutivo_Inicial_Punto`, `Consecutivo_Inicial_Tipo`, `Consecutivo_Inicial_Correlativo`, `Consecutivo_Final_Establ`, `Consecutivo_Final_Punto`, `Consecutivo_Final_Tipo`, `Consecutivo_Final_Correlativo`, `Consecutivo_Actual_Establ`, `Consecutivo_Actual_Punto`, `Consecutivo_Actual_Tipo`, `Consecutivo_Actual_Correlativo`, `Sucursal`, `Fecha_Limite`, `Fecha_Ingreso`) VALUES
(1, 'KJLJ78-JLOJ67-KPJK78-IU98O8-OIUIOK-IU', '001', '001', '01', '00000001', '001', '001', '01', '00000100', '001', '001', '01', '00000001', 'M98', '2021-08-31', '2021-08-30 02:00:24'),
(2, 'KJLJ78-JLJ67-KJK78-IUO8-OIUIO-9i89iu8', '001', '001', '01', '00000101', '001', '001', '01', '00000200', NULL, NULL, NULL, NULL, 'M95', '2021-08-31', '2021-08-31 03:00:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletas_guia_remision`
--

DROP TABLE IF EXISTS `boletas_guia_remision`;
CREATE TABLE IF NOT EXISTS `boletas_guia_remision` (
  `Cod_Boleta` int(18) NOT NULL AUTO_INCREMENT,
  `Fecha_Emision` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Actual_Establ` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Actual_Punto` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Actual_Tipo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Consecutivo_Actual_Correlativo` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `Motivo_Traslado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Num_Transferencia` int(10) NOT NULL,
  `Punto_Partida` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Punto_Destino` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Inicio_Traslado` date NOT NULL,
  `Fecha_Final_Traslado` date NOT NULL,
  `Autorizacion_Sar` int(18) NOT NULL,
  `Sucursal` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Unidad_Transporte` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Conductor` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Usuario` int(18) NOT NULL,
  PRIMARY KEY (`Cod_Boleta`),
  KEY `fk_Autorizacion_Sar` (`Autorizacion_Sar`),
  KEY `fk_Sucursal_Boletas` (`Sucursal`),
  KEY `fk_Unidad_Transporte` (`Unidad_Transporte`),
  KEY `fk_Conductor` (`Conductor`),
  KEY `fk_usuario` (`Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `boletas_guia_remision`
--

INSERT INTO `boletas_guia_remision` (`Cod_Boleta`, `Fecha_Emision`, `Consecutivo_Actual_Establ`, `Consecutivo_Actual_Punto`, `Consecutivo_Actual_Tipo`, `Consecutivo_Actual_Correlativo`, `Motivo_Traslado`, `Num_Transferencia`, `Punto_Partida`, `Punto_Destino`, `Fecha_Inicio_Traslado`, `Fecha_Final_Traslado`, `Autorizacion_Sar`, `Sucursal`, `Unidad_Transporte`, `Conductor`, `Fecha_Ingreso`, `Usuario`) VALUES
(1, '2021-08-31', '001', '001', '01', '00000001', 'kjhjkhk', 899, 'Boulevar del Nte. San Pedro Sula, Departamento de CortÃ©s, 21102 Honduras', 'DanlÃ­,El ParaÃ­so Barrio El  Centro.', '2021-08-26', '2021-08-27', 1, 'M98', 'Ckjkjkkjkk', 'Con123', '2021-08-31 04:53:08', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conductores`
--

DROP TABLE IF EXISTS `conductores`;
CREATE TABLE IF NOT EXISTS `conductores` (
  `Cod_Conductor` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Dni` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Nombres_Conductor` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Apellidos_Conductor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_Actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod_Conductor`),
  UNIQUE KEY `Rtn` (`Dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `conductores`
--

INSERT INTO `conductores` (`Cod_Conductor`, `Dni`, `Nombres_Conductor`, `Apellidos_Conductor`, `Estado`, `Fecha_Ingreso`, `Fecha_Actualizacion`) VALUES
('Con123', '0703198702285', 'Fabio sebastian', 'Coello', 'Disponible', '2021-08-30 03:43:59', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE IF NOT EXISTS `departamentos` (
  `Cod_Departamento` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Depto` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Sucursal` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_Actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod_Departamento`),
  KEY `fk_Sucursal` (`Sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`Cod_Departamento`, `Nombre_Depto`, `Sucursal`, `Fecha_Ingreso`, `Fecha_Actualizacion`) VALUES
('D23', 'Mercadeo', 'M98', '2021-08-29 23:29:46', '2021-08-29 23:32:54'),
('D89', 'Contabilidad', 'M98', '2021-08-29 23:31:09', '2021-08-29 23:35:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

DROP TABLE IF EXISTS `detalle`;
CREATE TABLE IF NOT EXISTS `detalle` (
  `Cod_Detalle` int(18) NOT NULL AUTO_INCREMENT,
  `Cod_Producto` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Cod_Boleta` int(18) NOT NULL,
  `Cantidad` int(18) NOT NULL,
  PRIMARY KEY (`Cod_Detalle`),
  KEY `fk_detalle_Boleta` (`Cod_Boleta`),
  KEY `fk_producto` (`Cod_Producto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`Cod_Detalle`, `Cod_Producto`, `Cod_Boleta`, `Cantidad`) VALUES
(1, '574778797897978', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `Cod_Producto` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Producto` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_Actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod_Producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Cod_Producto`, `Nombre_Producto`, `Descripcion`, `Fecha_Ingreso`, `Fecha_Actualizacion`) VALUES
('574778797897978', 'producto1', 'caracteristicas', '2021-08-31 02:57:18', '2021-08-31 02:57:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE IF NOT EXISTS `sucursales` (
  `Cod_Sucursal` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre_Sucursal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `RTN` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `Correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_Actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod_Sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`Cod_Sucursal`, `Nombre_Sucursal`, `RTN`, `Direccion`, `Telefono`, `Correo`, `Fecha_Ingreso`, `Fecha_Actualizacion`) VALUES
('M95', 'Danli', '78675645345234', 'DanlÃ­,El ParaÃ­so Barrio El  Centro.', '2789-3459', 'danli@laarmeria.com', '2021-08-29 21:40:33', '2021-08-29 21:56:45'),
('M98', 'San Pedro Sula', '23456789123456', 'Boulevar del Nte. San Pedro Sula, Departamento de CortÃ©s, 21102 Honduras', '2563-9888', 'sanpedro@laarmeria.com', '2021-08-29 21:06:31', '2021-08-31 05:25:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_de_transporte`
--

DROP TABLE IF EXISTS `unidades_de_transporte`;
CREATE TABLE IF NOT EXISTS `unidades_de_transporte` (
  `Cod_Unidad` varchar(18) COLLATE utf8_spanish_ci NOT NULL,
  `Marca_Vehiculo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Placa_Vehiculo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Modelo_Vehiculo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_Actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod_Unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidades_de_transporte`
--

INSERT INTO `unidades_de_transporte` (`Cod_Unidad`, `Marca_Vehiculo`, `Placa_Vehiculo`, `Modelo_Vehiculo`, `Estado`, `Fecha_Ingreso`, `Fecha_Actualizacion`) VALUES
('Ckjkjkkjkk', 'Toyota', '234UYHU', 'Tacoma', 'Disponible', '2021-08-29 23:54:51', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `Cod_Usuario` int(18) NOT NULL AUTO_INCREMENT,
  `Cod_Empleado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Clave` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha_Ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Fecha_Actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cod_Usuario`),
  UNIQUE KEY `Correo_electronico` (`Correo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Cod_Usuario`, `Cod_Empleado`, `Usuario`, `Correo`, `Clave`, `Rol`, `Estado`, `Fecha_Ingreso`, `Fecha_Actualizacion`) VALUES
(1, 'ADMIN1', 'Admin', 'admin@example.com', '$2y$10$ET2/OmbjjsTIAy5vuUEfe.qyufeae6Xqvwh4NIBBkY9IwzpdNqnnG', 'Admin', 'Activo', '2021-08-21 00:20:54', NULL),
(2, 'C200', 'Grosely', 'grosyalma@gmail.com', '$2y$10$3IhSzWw3Mwu7hWPQt53qmesDuHU8LeEl53iLAp4xmvLFL8gCs5L26', 'Miembro', 'Activo', '2021-08-29 21:59:51', '2021-08-29 22:02:18');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autorizaciones_sar`
--
ALTER TABLE `autorizaciones_sar`
  ADD CONSTRAINT `Fk_Sucursal_Sar` FOREIGN KEY (`Sucursal`) REFERENCES `sucursales` (`Cod_Sucursal`);

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `fk_Sucursal` FOREIGN KEY (`Sucursal`) REFERENCES `sucursales` (`Cod_Sucursal`);

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detalle_ibfk_1` FOREIGN KEY (`Cod_Boleta`) REFERENCES `boletas_guia_remision` (`Cod_Boleta`),
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`Cod_Producto`) REFERENCES `productos` (`Cod_Producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
