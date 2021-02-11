-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 28-11-2017 a las 20:21:27
-- Versión del servidor: 10.0.32-MariaDB-0+deb8u1
-- Versión de PHP: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `grupo53`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `id_configuracion` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT '1',
  `mensaje` varchar(255) NOT NULL DEFAULT '"El sitio se encuentra mantenimiento"',
  `cantidad_pagina` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `descripcion_hospital` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_configuracion`, `habilitado`, `mensaje`, `cantidad_pagina`, `titulo`, `mail`, `descripcion_hospital`) VALUES
(1, 1, 'El sitio se encuentra en mantenimiento', 3, 'Pagina Oficial - Hospital Gutierrez - La Plata', 'hospitalg@laplata.com', '<section id="content">\r\n		<h2>El Hospital</h2>\r\n		<article>Este centro de salud tiene un programa de residencias de primer nivel en el paÃ­s. \r\n                    Se ofrecen oportunidades de prÃ¡ctiva intensiva y\r\n                    supervisada en Ã¡mbitos profesionales y por la misma -por supuesto- se recibe un salario mensual, \r\n                    acorde a lo que la regulaciÃ³n mÃ©dica profesional lo indica en cada momento.</article>\r\n        <br>\r\n        <button type="button" onclick="" class="btn">MÃ¡s info</button>\r\n\r\n	</section>\r\n	\r\n	<section id="middle">\r\n		<h2>Guardia</h2>\r\n		<article>Hospital Dr. Ricardo Gutierrez de La Plata dispone de un sofisticado \r\n                    servicio de guardias mÃ©dicas las 24 horas para la atenciÃ³n de distintas urgencias. \r\n                    La administraciÃ³n de la instituciÃ³n hace viable una eficiente separaciÃ³n de los pacientes segÃºn el nivel de seriedad y tipo de patologÃ­a.</article>\r\n        <br>\r\n        <button type="button" onclick="" class="btn">MÃ¡s info</button>\r\n		\r\n	</section>\r\n	<section>\r\n		<h2>Especialidades</h2>\r\n		<article>Acorde a una respetable trayectoria en materia de medicina y salud, en Hospital Dr. Ricardo Gutierrez de La Plata \r\n                    podemos encontrar profesionales de las principales especialidades de salud. Del mismo modo, se brinda atenciÃ³n programada de urgencias, \r\n                    se realizan estudios mÃ©dicos y se brinda soporte en muchas de las ramas comunes de la medicina moderna.</article>\r\n        <br>\r\n\r\n        <button type="button" onclick="" class="btn">MÃ¡s info</button>\r\n	</section>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demografico`
--

CREATE TABLE IF NOT EXISTS `demografico` (
`id` int(11) NOT NULL,
  `heladera` tinyint(1) NOT NULL,
  `electricidad` tinyint(1) NOT NULL,
  `mascota` tinyint(1) NOT NULL,
  `tipo_vivienda` text NOT NULL,
  `tipo_calefaccion` text NOT NULL,
  `tipo_agua` text NOT NULL,
  `id_paciente` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `demografico`
--

INSERT INTO `demografico` (`id`, `heladera`, `electricidad`, `mascota`, `tipo_vivienda`, `tipo_calefaccion`, `tipo_agua`, `id_paciente`) VALUES
(2, 1, 0, 1, 'Material', 'LeÃ±a', 'De Pozo', 1),
(5, 1, 1, 1, 'Madera', 'Gas', 'Corriente', 4),
(11, 1, 1, 1, 'Chapa', 'Gas', 'Corriente', 8),
(28, 1, 1, 1, 'Chapa', 'Gas', 'Corriente', 16),
(29, 1, 1, 1, 'Material', 'Gas', 'Corriente', 17),
(30, 1, 1, 1, 'Material', 'Gas', 'Corriente', 18),
(31, 1, 1, 1, 'Material', 'Gas', 'Corriente', 19),
(32, 1, 1, 0, 'Material', 'Gas', 'Corriente', 20),
(33, 1, 0, 0, 'Material', 'Gas', 'Corriente', 21),
(34, 1, 0, 0, 'Material', 'Gas', 'Corriente', 22),
(35, 1, 0, 0, 'Material', 'Gas', 'Corriente', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia`
--

CREATE TABLE IF NOT EXISTS `historia` (
`id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `peso` int(11) NOT NULL,
  `vacunas` tinyint(1) NOT NULL,
  `vacunas_obs` varchar(255) NOT NULL,
  `maduracion` tinyint(1) NOT NULL,
  `maduracion_obs` varchar(255) NOT NULL,
  `examen_f` tinyint(1) NOT NULL,
  `examen_f_obs` varchar(255) NOT NULL,
  `pc` int(11) NOT NULL,
  `ppc` int(11) NOT NULL,
  `talla` int(11) NOT NULL,
  `alimentacion` varchar(255) NOT NULL,
  `obs_grales` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historia`
--

INSERT INTO `historia` (`id`, `fecha`, `peso`, `vacunas`, `vacunas_obs`, `maduracion`, `maduracion_obs`, `examen_f`, `examen_f_obs`, `pc`, `ppc`, `talla`, `alimentacion`, `obs_grales`, `id_usuario`, `id_paciente`) VALUES
(1, '2017-10-01', 120, 1, 'vacunas correctas', 0, 'maduracion correcta', 0, 'examen correcto', 11, 14, 0, 'buena', 'buena salud', 20, 1),
(2, '2017-11-03', 128, 0, 'sais', 0, 'saisjia', 1, 'sisdjias', 4, 5, 1, 'sksni', 'snausnai', 13, 1),
(3, '2017-11-02', 140, 1, 'snainsi', 1, 'disdi', 1, 'disndi', 5, 6, 2, 'smdiks', 'sidmsid', 13, 1),
(5, '2017-11-11', 0, 1, 'idmsid', 1, 'dmdimiodm', 0, 'siwsiw', 0, 0, 0, '', '', 20, 8),
(6, '2017-11-12', 1, 0, 'jdiojio', 1, 'sds', 0, 's,dos', 0, 0, 1, 'dkodko', 'qoqoqoq', 20, 8),
(7, '2017-11-12', 0, 1, 'aosko', 1, 'oasa', 1, 'opopop', 1, 2, 0, '', '', 20, 23),
(8, '2017-11-12', 0, 0, 'osso', 0, 'skosko', 0, 'okko', 0, 1, 1, 'dkodk', '', 20, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE IF NOT EXISTS `paciente` (
`id` int(11) NOT NULL,
  `apellido` text NOT NULL,
  `nombre` text NOT NULL,
  `fecha_nac` date NOT NULL,
  `genero` enum('masculino','femenino') NOT NULL,
  `tipo_doc` varchar(11) NOT NULL,
  `numero_doc` int(11) NOT NULL,
  `domicilio` text NOT NULL,
  `telcel` text NOT NULL,
  `obra_social` varchar(11) NOT NULL,
  `id_demografico` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id`, `apellido`, `nombre`, `fecha_nac`, `genero`, `tipo_doc`, `numero_doc`, `domicilio`, `telcel`, `obra_social`, `id_demografico`) VALUES
(1, 'aguero', 'sergio', '2017-08-31', 'masculino', 'LC', 34539291, 'avellaneda 7777', '0119232286', 'OSDE', 2),
(4, 'gago', 'fernando', '2017-11-16', 'masculino', 'DNI', 34539291, 'la boca 567', '0115434677', 'IOMA', 5),
(8, 'algo', 'algo', '2017-11-04', 'masculino', 'DNI', 32243876, 'calle 2 999', '02215439977', 'IOMA', 11),
(16, 'fernadez', 'nahuel', '2017-11-26', 'masculino', 'DNI', 33987789, 'av rivadavia 123', '0114565667', 'IOMA', 28),
(17, 'gomez', 'juan', '2017-11-21', 'masculino', 'DNI', 34546345, 'av palermo 567', '0119877866', 'IOMA', 29),
(18, 'andujar', 'mariano', '2017-11-02', 'masculino', 'DNI', 30789678, 'av libertador 908', '2214569898', 'IOMA', 30),
(19, 'diarte', 'lucas', '2017-11-05', 'masculino', 'DNI', 36765765, 'calle 7 123', '2215655678', 'IOMA', 31),
(20, 'desabato', 'leandro', '1979-09-09', 'masculino', 'DNI', 29890789, 'calle 9 454', '2215066567', 'IOMA', 32),
(21, 'paciente1', 'paciente1', '2017-11-03', 'masculino', 'DNI', 23232324, 'kdoakdod', '221323437', 'IOMA', 33),
(22, 'aa', 'aaa', '2017-11-03', 'masculino', 'DNI', 33647474, '33 cksmc', '727262626', 'IOMA', 34),
(23, 'sosa', 'jose', '2017-11-12', 'masculino', 'DNI', 45345345, 'calle 8 y 54', '2219878767', 'IOMA', 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id`, `nombre`) VALUES
(1, 'paciente_index'),
(2, 'paciente_new'),
(3, 'paciente_destroy'),
(4, 'paciente_update'),
(5, 'paciente_show'),
(6, 'usuario_index'),
(7, 'usuario_new'),
(8, 'usuario_destroy'),
(9, 'usuario_update'),
(10, 'usuario_show'),
(11, 'demografico_new'),
(12, 'demografico_destroy'),
(13, 'demografico_update'),
(14, 'demografico_show'),
(15, 'historia_new'),
(16, 'historia_show'),
(17, 'historia_update'),
(18, 'historia_destroy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
`id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'administrador'),
(2, 'pediatra'),
(3, 'recepcionista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE IF NOT EXISTS `turno` (
`id` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `hora` int(11) NOT NULL,
  `minutos` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`id`, `dia`, `mes`, `anio`, `hora`, `minutos`) VALUES
(1, 13, 11, 2017, 8, 0),
(2, 13, 11, 2017, 8, 30),
(3, 13, 11, 2017, 9, 0),
(4, 13, 11, 2017, 9, 30),
(5, 13, 11, 2017, 10, 0),
(6, 13, 11, 2017, 10, 30),
(7, 13, 11, 2017, 11, 0),
(8, 13, 11, 2017, 11, 30),
(9, 13, 11, 2017, 12, 0),
(10, 13, 11, 2017, 12, 30),
(11, 13, 11, 2017, 13, 0),
(12, 13, 11, 2017, 13, 30),
(13, 13, 11, 2017, 14, 0),
(14, 13, 11, 2017, 14, 30),
(15, 13, 11, 2017, 15, 0),
(16, 13, 11, 2017, 15, 30),
(17, 13, 11, 2017, 16, 0),
(18, 13, 11, 2017, 16, 30),
(19, 13, 11, 2017, 17, 0),
(20, 13, 11, 2017, 17, 30),
(21, 13, 11, 2017, 18, 0),
(22, 13, 11, 2017, 18, 30),
(23, 13, 11, 2017, 19, 0),
(24, 13, 11, 2017, 19, 30),
(25, 14, 11, 2017, 8, 0),
(26, 14, 11, 2017, 8, 30),
(27, 14, 11, 2017, 9, 0),
(28, 14, 11, 2017, 9, 30),
(29, 14, 11, 2017, 10, 0),
(30, 14, 11, 2017, 10, 30),
(31, 14, 11, 2017, 11, 0),
(32, 14, 11, 2017, 11, 30),
(33, 14, 11, 2017, 12, 0),
(34, 14, 11, 2017, 12, 30),
(35, 14, 11, 2017, 13, 0),
(36, 14, 11, 2017, 13, 30),
(37, 14, 11, 2017, 14, 0),
(38, 14, 11, 2017, 14, 30),
(39, 14, 11, 2017, 15, 0),
(40, 14, 11, 2017, 15, 30),
(41, 14, 11, 2017, 16, 0),
(42, 14, 11, 2017, 16, 30),
(43, 14, 11, 2017, 17, 0),
(44, 14, 11, 2017, 17, 30),
(45, 14, 11, 2017, 18, 0),
(46, 14, 11, 2017, 18, 30),
(47, 14, 11, 2017, 19, 0),
(48, 14, 11, 2017, 19, 30),
(49, 15, 11, 2017, 8, 0),
(50, 15, 11, 2017, 8, 30),
(51, 15, 11, 2017, 9, 0),
(52, 15, 11, 2017, 9, 30),
(53, 15, 11, 2017, 10, 0),
(54, 15, 11, 2017, 10, 30),
(55, 15, 11, 2017, 11, 0),
(56, 15, 11, 2017, 11, 30),
(57, 15, 11, 2017, 12, 0),
(58, 15, 11, 2017, 12, 30),
(59, 15, 11, 2017, 13, 0),
(60, 15, 11, 2017, 13, 30),
(61, 15, 11, 2017, 14, 0),
(62, 15, 11, 2017, 14, 30),
(63, 15, 11, 2017, 15, 0),
(64, 15, 11, 2017, 15, 30),
(65, 15, 11, 2017, 16, 0),
(66, 15, 11, 2017, 16, 30),
(67, 15, 11, 2017, 17, 0),
(68, 15, 11, 2017, 17, 30),
(69, 15, 11, 2017, 18, 0),
(70, 15, 11, 2017, 18, 30),
(71, 15, 11, 2017, 19, 0),
(72, 15, 11, 2017, 19, 30),
(73, 16, 11, 2017, 8, 0),
(74, 16, 11, 2017, 8, 30),
(75, 16, 11, 2017, 9, 0),
(76, 16, 11, 2017, 9, 30),
(77, 16, 11, 2017, 10, 0),
(78, 16, 11, 2017, 10, 30),
(79, 16, 11, 2017, 11, 0),
(80, 16, 11, 2017, 11, 30),
(81, 16, 11, 2017, 12, 0),
(82, 16, 11, 2017, 12, 30),
(83, 16, 11, 2017, 13, 0),
(84, 16, 11, 2017, 13, 30),
(85, 16, 11, 2017, 14, 0),
(86, 16, 11, 2017, 14, 30),
(87, 16, 11, 2017, 15, 0),
(88, 16, 11, 2017, 15, 30),
(89, 16, 11, 2017, 16, 0),
(90, 16, 11, 2017, 16, 30),
(91, 16, 11, 2017, 17, 0),
(92, 16, 11, 2017, 17, 30),
(93, 16, 11, 2017, 18, 0),
(94, 16, 11, 2017, 18, 30),
(95, 16, 11, 2017, 19, 0),
(96, 16, 11, 2017, 19, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno_paciente`
--

CREATE TABLE IF NOT EXISTS `turno_paciente` (
  `id_turno` int(11) NOT NULL,
  `documento_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updatedAt` datetime NOT NULL,
  `createdAt` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `firstname`, `lastname`, `active`, `email`, `username`, `password`, `updatedAt`, `createdAt`) VALUES
(1, 'Juan', 'Perez', 1, 'jp@mail.com', 'juanperez', '1234', '2017-11-28 00:00:00', '2017-06-30 15:25:00'),
(2, 'Pepe', 'Pepe', 0, 'pp@mail.com', 'ppuser', '5678', '2017-11-28 00:00:00', '2017-06-30 15:25:00'),
(3, 'David', 'Huertas', 1, 'dh@mail.com', 'dhuser', 'qwerty', '2017-11-05 00:00:00', '2017-06-30 15:25:00'),
(4, 'Gonzalo', 'Higuain', 1, 'gh@mail.com', 'ghuser', '9123', '2017-10-14 00:00:00', '2017-06-30 15:25:00'),
(8, 'agustin', 'torres', 1, 'agust@mail.com', 'agustorres', '172839', '2017-11-05 00:00:00', '2017-10-10 00:00:00'),
(11, 'juan', 'kal', 1, 'jk@mail.com', 'juank', 'lalala', '2017-11-28 00:00:00', '2017-10-13 00:00:00'),
(12, 'javier', 'perez', 0, 'javpe@mail.com', 'javiper', 'javi123', '2017-10-14 00:00:00', '2017-10-13 00:00:00'),
(13, 'fernando', 'cavenagui', 1, 'fercave@mail.com', 'cavegol', 'golgol', '2017-10-14 00:00:00', '2017-10-13 00:00:00'),
(15, 'javier', 'mascherano', 0, 'masche@mail.com', 'eljefecito', 'asdf', '2017-10-14 00:00:00', '2017-10-13 00:00:00'),
(18, 'admin', 'admin', 1, 'admin@admin.com', 'admin', 'admin', '2017-11-05 00:00:00', '2017-11-05 00:00:00'),
(20, 'pedi', 'atra', 1, 'pediatra@mail.com', 'pediatra', 'pediatra', '2017-11-09 00:00:00', '2017-11-09 00:00:00'),
(21, 'qqq', 'qqq', 1, 'qqq@gmail.com', 'qqq', 'qqq', '2017-11-28 00:00:00', '2017-11-28 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tiene_permiso`
--

CREATE TABLE IF NOT EXISTS `usuario_tiene_permiso` (
  `usuario_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_tiene_permiso`
--

INSERT INTO `usuario_tiene_permiso` (`usuario_id`, `permiso_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 5),
(1, 11),
(1, 13),
(1, 14),
(2, 1),
(2, 2),
(2, 4),
(2, 5),
(2, 11),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(3, 3),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 12),
(3, 18),
(4, 1),
(4, 2),
(4, 4),
(4, 5),
(4, 11),
(4, 13),
(4, 14),
(8, 1),
(8, 2),
(8, 4),
(8, 5),
(8, 11),
(8, 13),
(8, 14),
(8, 18),
(11, 1),
(11, 2),
(11, 4),
(11, 5),
(11, 11),
(11, 13),
(11, 14),
(12, 1),
(12, 2),
(12, 4),
(12, 5),
(12, 11),
(12, 13),
(12, 14),
(13, 1),
(13, 2),
(13, 4),
(13, 5),
(13, 11),
(13, 13),
(13, 14),
(13, 15),
(13, 16),
(13, 17),
(15, 1),
(15, 2),
(15, 4),
(15, 5),
(15, 11),
(15, 13),
(15, 14),
(18, 3),
(18, 6),
(18, 7),
(18, 8),
(18, 9),
(18, 10),
(18, 12),
(18, 18),
(20, 1),
(20, 2),
(20, 4),
(20, 5),
(20, 11),
(20, 13),
(20, 14),
(20, 15),
(20, 16),
(20, 17),
(21, 1),
(21, 2),
(21, 4),
(21, 5),
(21, 11),
(21, 13),
(21, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tiene_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_tiene_rol` (
  `usuario_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_tiene_rol`
--

INSERT INTO `usuario_tiene_rol` (`usuario_id`, `rol_id`) VALUES
(1, 3),
(2, 2),
(3, 1),
(4, 3),
(8, 2),
(11, 3),
(12, 2),
(13, 2),
(15, 3),
(18, 1),
(20, 2),
(21, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
 ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `demografico`
--
ALTER TABLE `demografico`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historia`
--
ALTER TABLE `historia`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turno_paciente`
--
ALTER TABLE `turno_paciente`
 ADD PRIMARY KEY (`id_turno`,`documento_paciente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_tiene_permiso`
--
ALTER TABLE `usuario_tiene_permiso`
 ADD PRIMARY KEY (`usuario_id`,`permiso_id`);

--
-- Indices de la tabla `usuario_tiene_rol`
--
ALTER TABLE `usuario_tiene_rol`
 ADD PRIMARY KEY (`usuario_id`,`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `demografico`
--
ALTER TABLE `demografico`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `historia`
--
ALTER TABLE `historia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
