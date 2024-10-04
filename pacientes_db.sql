-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2024 a las 23:04:33
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
-- Base de datos: `pacientes_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `cita_id` int(11) NOT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `medico_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `consultorio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`cita_id`, `paciente_id`, `medico_id`, `fecha`, `hora`, `consultorio_id`) VALUES
(1, 1, 1, '2020-02-23', '23:00:00', NULL),
(2, 1, 1, '2020-02-23', '23:00:00', NULL),
(3, 1, 1, '2020-02-23', '10:00:00', 17),
(4, 1, 1, '2020-02-23', '23:00:00', 8),
(5, 2, 3, '6222-02-06', '03:32:00', 15),
(6, 2, 3, '6222-02-06', '03:32:00', 3),
(7, 2, 3, '6222-02-06', '03:32:00', 28),
(8, 2, 3, '6222-02-06', '03:32:00', 29),
(9, 2, 3, '6222-02-06', '03:32:00', 20),
(10, 2, 3, '6222-02-06', '03:32:00', 22),
(11, 2, 3, '6222-02-06', '03:32:00', 12),
(12, 2, 9, '0003-02-03', '23:00:00', 26),
(13, 2, 9, '0003-02-03', '23:00:00', 13),
(14, 2, 9, '0003-02-03', '23:00:00', 18),
(15, 2, 9, '0003-02-03', '23:00:00', 4),
(16, 2, 9, '0003-02-03', '23:00:00', 19),
(17, 2, 9, '0003-02-03', '23:00:00', 28),
(18, 2, 9, '0003-02-03', '23:00:00', 12),
(19, 2, 9, '0003-02-03', '23:00:00', 29),
(20, 2, 9, '0003-02-03', '23:00:00', 25),
(21, 5, 25, '0000-00-00', '04:53:00', 3),
(22, 32, 30, '3645-04-05', '05:35:00', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorios`
--

CREATE TABLE `consultorios` (
  `consultorio_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultorios`
--

INSERT INTO `consultorios` (`consultorio_id`, `nombre`, `direccion`, `telefono`) VALUES
(2, 'Consultorio B', 'Calle Falsa 456', '555-1002'),
(3, 'Consultorio C', 'Paseo de la Reforma 789', '555-1003'),
(4, 'Consultorio D', 'Blvd. de los Ángeles 101', '555-1004'),
(5, 'Consultorio E', 'Calle de la Salud 202', '555-1005'),
(6, 'Consultorio F', 'Av. del Sol 303', '555-1006'),
(7, 'Consultorio G', 'Calle del Río 404', '555-1007'),
(8, 'Consultorio H', 'Av. de los Abetos 505', '555-1008'),
(9, 'Consultorio I', 'Calle de las Flores 606', '555-1009'),
(10, 'Consultorio J', 'Paseo de la Paz 707', '555-1010'),
(11, 'Consultorio K', 'Calle de los Olivos 808', '555-1011'),
(12, 'Consultorio L', 'Av. del Mar 909', '555-1012'),
(13, 'Consultorio M', 'Calle de la Libertad 123', '555-1013'),
(14, 'Consultorio N', 'Av. del Progreso 456', '555-1014'),
(15, 'Consultorio O', 'Calle de la Esperanza 789', '555-1015'),
(16, 'Consultorio P', 'Blvd. de la Amistad 101', '555-1016'),
(17, 'Consultorio Q', 'Calle de la Alegría 202', '555-1017'),
(18, 'Consultorio R', 'Av. de la Salud 303', '555-1018'),
(19, 'Consultorio S', 'Calle de la Integración 404', '555-1019'),
(20, 'Consultorio T', 'Calle de los Sueños 505', '555-1020'),
(21, 'Consultorio U', 'Av. del Bienestar 606', '555-1021'),
(22, 'Consultorio V', 'Calle de la Unidad 707', '555-1022'),
(23, 'Consultorio W', 'Calle de los Valores 808', '555-1023'),
(24, 'Consultorio X', 'Calle del Respeto 909', '555-1024'),
(25, 'Consultorio Y', 'Calle de la Esperanza 123', '555-1025'),
(26, 'Consultorio Z', 'Av. de la Prosperidad 456', '555-1026'),
(27, 'Consultorio AA', 'Blvd. del Desarrollo 789', '555-1027'),
(28, 'Consultorio AB', 'Calle de la Paz 101', '555-1028'),
(29, 'Consultorio AC', 'Av. de la Amistad 202', '555-1029'),
(30, 'Consultorio AD', 'Calle de la Felicidad 303', '555-1030'),
(34, 'Consultorio A', 'Av. Siempre Viva 123', '555-1001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `medico_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`medico_id`, `nombre`, `apellido`, `especialidad`, `telefono`, `correo`) VALUES
(1, 'Juan', 'Pérez', 'Cardiología', '555-0101', 'juan.perez@example.com'),
(2, 'María', 'González', 'Pediatría', '555-0102', 'maria.gonzalez@example.com'),
(3, 'Carlos', 'López', 'Ginecología', '555-0103', 'carlos.lopez@example.com'),
(4, 'Ana', 'Martínez', 'Oftalmología', '555-0104', 'ana.martinez@example.com'),
(5, 'José', 'Hernández', 'Dermatología', '555-0105', 'jose.hernandez@example.com'),
(6, 'Laura', 'Sánchez', 'Psiquiatría', '555-0106', 'laura.sanchez@example.com'),
(7, 'David', 'Ramírez', 'Traumatología', '555-0107', 'david.ramirez@example.com'),
(8, 'Claudia', 'Torres', 'Endocrinología', '555-0108', 'claudia.torres@example.com'),
(9, 'Javier', 'Flores', 'Neurología', '555-0109', 'javier.flores@example.com'),
(10, 'Patricia', 'Jiménez', 'Otorrinolaringología', '555-0110', 'patricia.jimenez@example.com'),
(11, 'Andrés', 'García', 'Urología', '555-0111', 'andres.garcia@example.com'),
(12, 'Sofía', 'Morales', 'Anestesiología', '555-0112', 'sofia.morales@example.com'),
(13, 'Ricardo', 'Castillo', 'Oncología', '555-0113', 'ricardo.castillo@example.com'),
(14, 'Verónica', 'Ríos', 'Radiología', '555-0114', 'veronica.rios@example.com'),
(15, 'Diego', 'Cortez', 'Geriatría', '555-0115', 'diego.cortez@example.com'),
(16, 'Gabriela', 'Vargas', 'Medicina Interna', '555-0116', 'gabriela.vargas@example.com'),
(17, 'Fernando', 'Salazar', 'Inmunología', '555-0117', 'fernando.salazar@example.com'),
(18, 'Elena', 'Mendoza', 'Pneumología', '555-0118', 'elena.mendoza@example.com'),
(19, 'Oscar', 'Aguilar', 'Reumatología', '555-0119', 'oscar.aguilar@example.com'),
(20, 'Natalia', 'Delgado', 'Hematología', '555-0120', 'natalia.delgado@example.com'),
(21, 'Cristian', 'Núñez', 'Medicina Familiar', '555-0121', 'cristian.nunez@example.com'),
(22, 'Isabel', 'Cabrera', 'Medicina del Deporte', '555-0122', 'isabel.cabrera@example.com'),
(23, 'Roberto', 'Alvarado', 'Pediatría', '555-0123', 'roberto.alvarado@example.com'),
(24, 'Monica', 'Bravo', 'Psicología', '555-0124', 'monica.bravo@example.com'),
(25, 'Felipe', 'Mora', 'Cirugía General', '555-0125', 'felipe.mora@example.com'),
(26, 'Luisa', 'Peña', 'Ginecología', '555-0126', 'luisa.pena@example.com'),
(27, 'Rafael', 'Bermúdez', 'Cardiología', '555-0127', 'rafael.bermudez@example.com'),
(28, 'Carmen', 'Pérez', 'Dermatología', '555-0128', 'carmen.perez@example.com'),
(29, 'Alberto', 'Soto', 'Endocrinología', '555-0129', 'alberto.soto@example.com'),
(30, 'Marta', 'Zamora', 'Medicina Familiar', '555-0130', 'marta.zamora@example.com'),
(31, 'das', 'asd', 'a', '32', 'dasd@gmail.com'),
(32, 'das', 'asd', 'a', '32', 'dasd@gmail.com'),
(33, 'das', 'asd', 'a', '32', 'dasd@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `paciente_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `documento_id` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`paciente_id`, `nombre`, `apellido`, `documento_id`, `fecha_nacimiento`, `telefono`, `direccion`, `correo`, `archivo`, `fecha_creacion`) VALUES
(1, 'Juan', 'Pérez', '12345678', '1990-01-01', '5551234567', 'Calle Falsa 123', 'juan.perez@example.com', NULL, '2024-10-04 19:37:28'),
(2, 'María', 'Gómez', '87654321', '1992-02-02', '5557654321', 'Avenida Siempre Viva 456', 'maria.gomez@example.com', NULL, '2024-10-04 19:37:28'),
(3, '[value-2]', '[value-3]', '[value-4]', '0000-00-00', '[value-6]', '[value-7]', '[value-8]', '[value-9]', '0000-00-00 00:00:00'),
(4, 'Carlos', 'López', '11122333', '1985-03-15', '5551234560', 'Calle 1', 'carlos.lopez@example.com', NULL, '2024-10-04 19:40:05'),
(5, 'Ana', 'Martínez', '22233444', '1990-06-20', '5552345671', 'Calle 2', 'ana.martinez@example.com', NULL, '2024-10-04 19:40:05'),
(6, 'José', 'Hernández', '33344555', '1988-11-11', '5553456782', 'Calle 3', 'jose.hernandez@example.com', NULL, '2024-10-04 19:40:05'),
(7, 'Laura', 'García', '44455666', '1995-01-30', '5554567893', 'Calle 4', 'laura.garcia@example.com', NULL, '2024-10-04 19:40:05'),
(8, 'Diego', 'Ramírez', '55566777', '1992-02-25', '5555678904', 'Calle 5', 'diego.ramirez@example.com', NULL, '2024-10-04 19:40:05'),
(9, 'Clara', 'Jiménez', '66677888', '1993-05-12', '5556789015', 'Calle 6', 'clara.jimenez@example.com', NULL, '2024-10-04 19:40:05'),
(10, 'Sofía', 'Torres', '77788999', '1987-07-19', '5557890126', 'Calle 7', 'sofia.torres@example.com', NULL, '2024-10-04 19:40:05'),
(11, 'Felipe', 'Vázquez', '88899000', '1994-08-30', '5558901237', 'Calle 8', 'felipe.vazquez@example.com', NULL, '2024-10-04 19:40:05'),
(12, 'María', 'Cruz', '99900111', '1986-09-22', '5559012348', 'Calle 9', 'maria.cruz@example.com', NULL, '2024-10-04 19:40:05'),
(13, 'Andrés', 'Gutiérrez', '10111213', '1989-10-05', '5550123459', 'Calle 10', 'andres.gutierrez@example.com', NULL, '2024-10-04 19:40:05'),
(14, 'Marta', 'Paredes', '12131415', '1991-12-14', '5551234568', 'Calle 11', 'marta.paredes@example.com', NULL, '2024-10-04 19:40:05'),
(15, 'Javier', 'Salinas', '13141516', '1984-04-18', '5552345679', 'Calle 12', 'javier.salinas@example.com', NULL, '2024-10-04 19:40:05'),
(16, 'Isabel', 'Mendoza', '14151617', '1985-08-11', '5553456780', 'Calle 13', 'isabel.mendoza@example.com', NULL, '2024-10-04 19:40:05'),
(17, 'Nicolás', 'Sierra', '15161718', '1990-09-09', '5554567891', 'Calle 14', 'nicolas.sierra@example.com', NULL, '2024-10-04 19:40:05'),
(18, 'Gabriela', 'Díaz', '16171819', '1992-03-30', '5555678902', 'Calle 15', 'gabriela.diaz@example.com', NULL, '2024-10-04 19:40:05'),
(19, 'Cristian', 'Valencia', '17181920', '1988-05-20', '5556789013', 'Calle 16', 'cristian.valencia@example.com', NULL, '2024-10-04 19:40:05'),
(20, 'Patricia', 'Figueroa', '18192021', '1983-12-02', '5557890124', 'Calle 17', 'patricia.figueroa@example.com', NULL, '2024-10-04 19:40:05'),
(21, 'Raúl', 'Cortez', '19202122', '1987-06-11', '5558901235', 'Calle 18', 'raul.cortez@example.com', NULL, '2024-10-04 19:40:05'),
(22, 'Estefanía', 'Ríos', '20212223', '1993-01-08', '5559012346', 'Calle 19', 'estefania.rios@example.com', NULL, '2024-10-04 19:40:05'),
(23, 'Luis', 'Alvarez', '21222324', '1994-02-15', '5550123457', 'Calle 20', 'luis.alvarez@example.com', NULL, '2024-10-04 19:40:05'),
(24, 'Sara', 'González', '22232425', '1989-03-22', '5551234569', 'Calle 21', 'sara.gonzalez@example.com', NULL, '2024-10-04 19:40:05'),
(25, 'Fernando', 'Morales', '23242526', '1986-07-29', '5552345670', 'Calle 22', 'fernando.morales@example.com', NULL, '2024-10-04 19:40:05'),
(26, 'Karina', 'Núñez', '24252627', '1995-11-30', '5553456781', 'Calle 23', 'karina.nunez@example.com', NULL, '2024-10-04 19:40:05'),
(27, 'Emilio', 'Santiago', '25262728', '1991-04-12', '5554567892', 'Calle 24', 'emilio.santiago@example.com', NULL, '2024-10-04 19:40:05'),
(28, 'Tatiana', 'Bermúdez', '26272829', '1990-05-24', '5555678903', 'Calle 25', 'tatiana.bermudez@example.com', NULL, '2024-10-04 19:40:05'),
(29, 'Pablo', 'Peña', '27282930', '1987-09-18', '5556789014', 'Calle 26', 'pablo.pena@example.com', NULL, '2024-10-04 19:40:05'),
(30, 'Silvia', 'Cano', '28293031', '1988-10-14', '5557890125', 'Calle 27', 'silvia.cano@example.com', NULL, '2024-10-04 19:40:05'),
(31, 'Victor', 'Rivas', '29303132', '1993-12-29', '5558901236', 'Calle 28', 'victor.rivas@example.com', NULL, '2024-10-04 19:40:05'),
(32, 'Lucía', 'Salcedo', '30313233', '1995-08-19', '5559012347', 'Calle 29', 'lucia.salcedo@example.com', NULL, '2024-10-04 19:40:05'),
(33, 'Julio', 'Mejía', '31323334', '1989-02-23', '5550123458', 'Calle 30', 'julio.mejia@example.com', NULL, '2024-10-04 19:40:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`cita_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`),
  ADD KEY `fk_consultorio` (`consultorio_id`);

--
-- Indices de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  ADD PRIMARY KEY (`consultorio_id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`medico_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`paciente_id`),
  ADD UNIQUE KEY `documento_id` (`documento_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  MODIFY `consultorio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `medico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`paciente_id`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`medico_id`),
  ADD CONSTRAINT `fk_consultorio` FOREIGN KEY (`consultorio_id`) REFERENCES `consultorios` (`consultorio_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
