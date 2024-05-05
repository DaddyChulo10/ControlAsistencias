-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2024 a las 19:17:54
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `codigo` text NOT NULL,
  `grado_grupo_id` int(11) NOT NULL,
  `nombre_apellido` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `codigo`, `grado_grupo_id`, `nombre_apellido`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'PEAE010603HPLRLDA1', 5, 'Edgar Pérez}', '2024-05-05 11:44:37', '2024-05-05 11:44:37', NULL),
(9, 'PEAE010603HPLRL1010', 5, 'Ejemplo', '2024-05-05 11:44:52', '2024-05-05 11:44:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclo_escolar`
--

CREATE TABLE `ciclo_escolar` (
  `id` int(11) NOT NULL,
  `ciclo` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ciclo_escolar`
--

INSERT INTO `ciclo_escolar` (`id`, `ciclo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, '2024', '2024-05-05 11:43:01', '2024-05-05 11:43:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faltas_retardos`
--

CREATE TABLE `faltas_retardos` (
  `id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL,
  `asistencia` tinyint(1) DEFAULT NULL,
  `retardo` tinyint(1) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `faltas_retardos`
--

INSERT INTO `faltas_retardos` (`id`, `alumno_id`, `asistencia`, `retardo`, `fecha`, `hora`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 8, 1, 0, '2024-05-05', '10:46:26', '2024-05-05 11:46:26', '2024-05-05 11:46:26', NULL),
(11, 9, 0, 1, '2024-05-05', '10:46:42', '2024-05-05 11:46:42', '2024-05-05 11:46:42', NULL),
(12, 8, 1, 0, '2024-05-05', '10:50:55', '2024-05-05 11:50:55', '2024-05-05 11:50:55', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados_grupos`
--

CREATE TABLE `grados_grupos` (
  `id` int(11) NOT NULL,
  `grado_grupo` text NOT NULL,
  `ciclo_escolar_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grados_grupos`
--

INSERT INTO `grados_grupos` (`id`, `grado_grupo`, `ciclo_escolar_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, '1°A', 7, '2024-05-05 11:43:19', '2024-05-05 11:43:19', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciclo_escolar`
--
ALTER TABLE `ciclo_escolar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `faltas_retardos`
--
ALTER TABLE `faltas_retardos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grados_grupos`
--
ALTER TABLE `grados_grupos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ciclo_escolar`
--
ALTER TABLE `ciclo_escolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `faltas_retardos`
--
ALTER TABLE `faltas_retardos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `grados_grupos`
--
ALTER TABLE `grados_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
