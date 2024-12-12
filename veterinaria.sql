-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2024 a las 17:59:25
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
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aplicacion_vacunas`
--

CREATE TABLE `aplicacion_vacunas` (
  `id_aplicacion_vacuna` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `id_vacuna` int(11) NOT NULL,
  `fecha_tratamiento` datetime DEFAULT current_timestamp(),
  `proximo_tratamiento` date DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categorias` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categorias`, `categoria`) VALUES
(1, 'Accesorios'),
(2, 'Jugetes'),
(3, 'Hogar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_citas` int(110) NOT NULL,
  `id_cliente` int(110) NOT NULL,
  `nombre_mascota` varchar(100) NOT NULL,
  `tipo_de_servicio` varchar(100) NOT NULL,
  `fecha_cita` date NOT NULL,
  `hora_cita` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `color` varchar(50) NOT NULL,
  `fyh_creacion` datetime NOT NULL,
  `fyh_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_citas`, `id_cliente`, `nombre_mascota`, `tipo_de_servicio`, `fecha_cita`, `hora_cita`, `descripcion`, `title`, `start`, `end`, `color`, `fyh_creacion`, `fyh_actualizacion`) VALUES
(6, 1, 'max', 'consulta', '2024-12-13', '08:00 - 09:00', 'hola', 'consulta', '2024-12-13', '2024-12-13', '#2324ff', '2024-12-12 16:50:38', '0000-00-00 00:00:00'),
(7, 1, 'max', 'consulta', '2024-12-13', '09:00 - 10:00', '', 'consulta', '2024-12-13', '2024-12-13', '#2324ff', '2024-12-12 17:16:14', '0000-00-00 00:00:00'),
(8, 1, 'max', 'consulta', '2024-12-13', '10:00 - 11:00', '', 'consulta', '2024-12-13', '2024-12-13', '#2324ff', '2024-12-12 17:29:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `cedula` varchar(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo_e` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `cedula`, `nombre`, `apellido`, `telefono`, `correo_e`) VALUES
(1, '012345', 'Elena', 'Vargas', '987654321', 'elena@example.com'),
(2, '123456', 'Juan', 'Pérez', '123456789', 'juan@example.com'),
(3, '234567', 'María', 'González', '98654321', 'maria@example.com'),
(4, '345678', 'Pedro', 'López', '456123789', 'pedro@example.com'),
(5, '456789', 'Ana', 'Martínez', '789456123', 'ana@example.com'),
(6, '567890', 'Luis', 'Rodríguez', '321654987', 'luis@example.com'),
(7, '678901', 'Laura', 'Hernández', '654987321', 'laura@example.com'),
(8, '789012', 'Carlos', 'García', '987321654', 'carlos@example.com'),
(9, '890123', 'Sofía', 'Díaz', '654321987', 'sofia@example.com'),
(10, '901234', 'Miguel', 'Torres', '321987654', 'miguel@example.com'),
(11, '1018507198', 'Gelvis', 'Melo', '3017876098', 'melo@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_detalle`, `id_factura`, `id_producto`, `cantidad`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 8, 1),
(4, 2, 7, 1),
(5, 2, 6, 1),
(6, 3, 1, 1),
(7, 4, 2, 1),
(8, 5, 5, 1),
(9, 5, 6, 1),
(10, 6, 8, 1),
(11, 7, 7, 1),
(12, 8, 1, 1),
(13, 8, 2, 1),
(14, 9, 8, 1),
(15, 10, 1, 1),
(16, 11, 3, 1),
(17, 11, 4, 1),
(18, 11, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_compra` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `id_cliente`, `fecha_compra`) VALUES
(1, 1, '2023-07-15 00:00:00'),
(2, 2, '2023-08-15 00:00:00'),
(3, 3, '2023-09-15 00:00:00'),
(4, 4, '2023-10-15 00:00:00'),
(5, 5, '2023-11-15 00:00:00'),
(6, 6, '2023-12-15 00:00:00'),
(7, 7, '2024-01-15 00:00:00'),
(8, 8, '2024-02-15 00:00:00'),
(9, 9, '2024-03-15 00:00:00'),
(10, 10, '2024-04-15 00:00:00'),
(11, 11, '2024-05-15 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `id_mascota` int(11) NOT NULL,
  `codigo` varchar(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `raza` varchar(50) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`id_mascota`, `codigo`, `nombre`, `tipo`, `raza`, `genero`, `cliente`) VALUES
(1, 'ABC001', 'Bobby', 'Perro', 'Labrador', 'Macho', 1),
(2, 'ABC002', 'Mimi', 'Gato', 'Siames', 'Hembra', 2),
(3, 'ABC003', 'Max', 'Perro', 'Golden Retriever', 'Macho', 3),
(4, 'ABC004', 'Luna', 'Gato', 'Persa', 'Hembra', 4),
(5, 'ABC005', 'Rocky', 'Perro', 'Dálmata', 'Macho', 5),
(6, 'ABC006', 'Simba', 'Gato', 'Bengala', 'Macho', 6),
(7, 'ABC007', 'Lola', 'Perro', 'Chihuahua', 'Hembra', 7),
(8, 'ABC008', 'Whiskers', 'Gato', 'Siamés', 'Macho', 8),
(9, 'ABC009', 'Chloe', 'Perro', 'Bulldog Francés', 'Hembra', 9),
(10, 'ABC010', 'Garfield', 'Gato', 'Maine Coon', 'Macho', 10),
(11, 'ABC011', 'Daisy', 'Perro', 'Beagle', 'Hembra', 5),
(12, 'ABC012', 'Mia', 'Gato', 'Persa', 'Hembra', 2),
(13, 'ABC013', 'Rocky', 'Perro', 'Labrador', 'Macho', 1),
(14, 'ABC014', 'Tiger', 'Gato', 'Siamés', 'Macho', 8),
(15, 'ABC015', 'Rex', 'Perro', 'Pastor Alemán', 'Macho', 9),
(16, 'ABC016', 'sonic', 'Perro', 'pincher', 'Macho', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `Tipo` varchar(50) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `descuento` float DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `descripción` varchar(255) DEFAULT NULL,
  `imagen` varchar(50) NOT NULL,
  `categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo`, `nombre`, `Tipo`, `marca`, `precio`, `descuento`, `stock`, `descripción`, `imagen`, `categoria`) VALUES
(1, 'PROD01', '', 'Collar', 'PetSafe', 62361, 0, NULL, '\"\"', '', 1),
(2, 'PROD02', '', 'Correa', 'Flexi', 40950, 0, NULL, '\"\"', '', 1),
(3, 'PROD03', '', 'Comedero', 'SureFeed', 78975, 0, NULL, '\"\"', '', 3),
(4, 'PROD04', '', 'Pelota', 'KONG', 34125, 0, NULL, '\"\"', '', 2),
(5, 'PROD05', '', 'Camita', 'Frisco', 117000, 0, NULL, '\"\"', '', 3),
(6, 'PROD06', '', 'Rascador', 'Catit', 99450, 0, NULL, '\"\"', '', 2),
(7, 'PROD07', '', 'Transportadora', 'AmazonBasics', 159861, 0, NULL, '\"\"', '', 1),
(8, 'PROD08', '', 'Arnés', 'Julius-K9', 72150, 0, NULL, '\"\"', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `clave`) VALUES
(1, 'admin', 'Angel Sifuentes', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunas`
--

CREATE TABLE `vacunas` (
  `id_vacuna` int(11) NOT NULL,
  `codigo` varchar(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `objetivo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vacunas`
--

INSERT INTO `vacunas` (`id_vacuna`, `codigo`, `nombre`, `objetivo`) VALUES
(1, 'KDO1', 'Vacuna contra la rabia', 'Prevenir la rabia'),
(2, 'FJAI2', 'Vacuna contra el moquillo', 'Prevenir el moquillo'),
(3, 'MAQ3', 'Vacuna contra la parvovirosis', 'Prevenir la parvovirosis'),
(4, 'VOK4', 'Vacuna contra la leptospirosis', 'Prevenir la leptospirosis'),
(5, 'POW5', 'Vacuna contra la rinotraqueitis', 'Prevenir la rinotraqueitis'),
(6, 'BSK6', 'Vacuna contra la panleucopenia', 'Prevenir la panleucopenia');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aplicacion_vacunas`
--
ALTER TABLE `aplicacion_vacunas`
  ADD PRIMARY KEY (`id_aplicacion_vacuna`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_vacuna` (`id_vacuna`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categorias`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_citas`),
  ADD KEY `id.cliente` (`id_cliente`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD UNIQUE KEY `correo_e` (`correo_e`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `cliente` (`cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `vacunas`
--
ALTER TABLE `vacunas`
  ADD PRIMARY KEY (`id_vacuna`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aplicacion_vacunas`
--
ALTER TABLE `aplicacion_vacunas`
  MODIFY `id_aplicacion_vacuna` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_citas` int(110) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vacunas`
--
ALTER TABLE `vacunas`
  MODIFY `id_vacuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aplicacion_vacunas`
--
ALTER TABLE `aplicacion_vacunas`
  ADD CONSTRAINT `aplicacion_vacuna_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascotas` (`id_mascota`),
  ADD CONSTRAINT `aplicacion_vacuna_ibfk_2` FOREIGN KEY (`id_vacuna`) REFERENCES `vacunas` (`id_vacuna`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id_factura`),
  ADD CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD CONSTRAINT `mascota_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categorias`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
