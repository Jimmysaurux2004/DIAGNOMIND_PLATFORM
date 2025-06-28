-- Adminer 5.3.0 MySQL 8.0.42 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `atencion_sintomas`;
CREATE TABLE `atencion_sintomas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_atencion` int NOT NULL,
  `id_sintoma` int NOT NULL,
  `respuesta` enum('S','N') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_atencion` (`id_atencion`),
  KEY `id_sintoma` (`id_sintoma`),
  CONSTRAINT `atencion_sintomas_ibfk_1` FOREIGN KEY (`id_atencion`) REFERENCES `atenciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `atencion_sintomas_ibfk_2` FOREIGN KEY (`id_sintoma`) REFERENCES `sintomas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `atencion_sintomas` (`id`, `id_atencion`, `id_sintoma`, `respuesta`) VALUES
(1,	1,	1,	'S'),
(2,	1,	2,	'S'),
(3,	1,	3,	'S'),
(4,	1,	4,	'N'),
(5,	1,	5,	'N'),
(6,	1,	6,	'N'),
(7,	1,	7,	'N'),
(8,	1,	8,	'S'),
(9,	1,	9,	'S'),
(10,	1,	10,	'N'),
(11,	1,	11,	'S'),
(12,	1,	12,	'N'),
(13,	1,	13,	'N'),
(14,	1,	14,	'N'),
(15,	1,	15,	'N'),
(16,	1,	16,	'N'),
(17,	1,	17,	'N'),
(18,	1,	18,	'S'),
(19,	2,	1,	'S'),
(20,	2,	2,	'N'),
(21,	2,	3,	'N'),
(22,	2,	4,	'N'),
(23,	2,	5,	'S'),
(24,	2,	6,	'N'),
(25,	2,	7,	'S'),
(26,	2,	8,	'N'),
(27,	2,	9,	'S'),
(28,	2,	10,	'S'),
(29,	2,	11,	'N'),
(30,	2,	12,	'S'),
(31,	2,	13,	'N'),
(32,	2,	14,	'S'),
(33,	2,	15,	'N'),
(34,	2,	16,	'N'),
(35,	2,	17,	'N'),
(36,	2,	18,	'N'),
(37,	3,	1,	'S'),
(38,	3,	2,	'S'),
(39,	3,	3,	'N'),
(40,	3,	4,	'N'),
(41,	3,	5,	'S'),
(42,	3,	6,	'S'),
(43,	3,	7,	'N'),
(44,	3,	8,	'N'),
(45,	3,	9,	'N'),
(46,	3,	10,	'S'),
(47,	3,	11,	'N'),
(48,	3,	12,	'N'),
(49,	3,	13,	'S'),
(50,	3,	14,	'N'),
(51,	3,	15,	'N'),
(52,	3,	16,	'S'),
(53,	3,	17,	'S'),
(54,	3,	18,	'N'),
(55,	4,	1,	'S'),
(56,	4,	2,	'N'),
(57,	4,	3,	'N'),
(58,	4,	4,	'N'),
(59,	4,	5,	'S'),
(60,	4,	6,	'N'),
(61,	4,	7,	'S'),
(62,	4,	8,	'N'),
(63,	4,	9,	'S'),
(64,	4,	10,	'S'),
(65,	4,	11,	'N'),
(66,	4,	12,	'S'),
(67,	4,	13,	'N'),
(68,	4,	14,	'S'),
(69,	4,	15,	'N'),
(70,	4,	16,	'N'),
(71,	4,	17,	'N'),
(72,	4,	18,	'N'),
(73,	5,	1,	'S'),
(74,	5,	2,	'N'),
(75,	5,	3,	'N'),
(76,	5,	4,	'N'),
(77,	5,	5,	'S'),
(78,	5,	6,	'N'),
(79,	5,	7,	'S'),
(80,	5,	8,	'N'),
(81,	5,	9,	'N'),
(82,	5,	10,	'S'),
(83,	5,	11,	'N'),
(84,	5,	12,	'N'),
(85,	5,	13,	'N'),
(86,	5,	14,	'S'),
(87,	5,	15,	'N'),
(88,	5,	16,	'N'),
(89,	5,	17,	'N'),
(90,	5,	18,	'N'),
(91,	6,	1,	'S'),
(92,	6,	2,	'N'),
(93,	6,	3,	'N'),
(94,	6,	4,	'N'),
(95,	6,	5,	'S'),
(96,	6,	6,	'N'),
(97,	6,	7,	'S'),
(98,	6,	8,	'N'),
(99,	6,	9,	'S'),
(100,	6,	10,	'S'),
(101,	6,	11,	'N'),
(102,	6,	12,	'S'),
(103,	6,	13,	'N'),
(104,	6,	14,	'S'),
(105,	6,	15,	'N'),
(106,	6,	16,	'N'),
(107,	6,	17,	'N'),
(108,	6,	18,	'N');

DROP TABLE IF EXISTS `atenciones`;
CREATE TABLE `atenciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `resultado` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `atenciones_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `atenciones` (`id`, `id_paciente`, `fecha`, `hora`, `resultado`) VALUES
(1,	1,	'2025-06-27',	'13:30:10',	'TDAH en adultos'),
(2,	1,	'2025-06-27',	'16:20:07',	'Depresion mayor'),
(3,	1,	'2025-06-27',	'18:21:49',	'Trastorno bipolar II'),
(4,	1,	'2025-06-27',	'18:24:34',	'Depresion mayor'),
(5,	1,	'2025-06-27',	'18:26:54',	'Depresion mayor'),
(6,	1,	'2025-06-27',	'18:38:09',	'Depresion mayor');

DROP TABLE IF EXISTS `medicos`;
CREATE TABLE `medicos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_colegiatura` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_colegiatura` (`numero_colegiatura`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `medicos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `medicos` (`id`, `id_usuario`, `nombres`, `apellidos`, `numero_colegiatura`) VALUES
(1,	1,	'Jimmy Alexander',	'Huerta Vasquez',	'CMP743826');

DROP TABLE IF EXISTS `pacientes`;
CREATE TABLE `pacientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_medico` int NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `dni` char(8) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `hora_registro` time NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_medico` (`id_medico`),
  CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pacientes_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pacientes` (`id`, `id_usuario`, `id_medico`, `nombres`, `apellidos`, `dni`, `fecha_registro`, `hora_registro`) VALUES
(1,	2,	1,	'Matias Aaron',	'Huerta Vasquez',	'72340360',	'2025-06-26',	'19:00:00');

DROP TABLE IF EXISTS `sintomas`;
CREATE TABLE `sintomas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pregunta` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_general_ci DEFAULT 'activo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sintomas` (`id`, `descripcion`, `pregunta`, `estado`) VALUES
(1,	'Falta de concentración',	'¿Te cuesta mantener la concentración en tareas o conversaciones?',	'activo'),
(2,	'Impulsividad',	'¿Tiendes a actuar de forma impulsiva, sin pensar en las consecuencias?',	'activo'),
(3,	'Hiperactividad o inquietud física',	'¿Sientes una necesidad constante de moverte o te cuesta estar quieto?',	'activo'),
(4,	'Preocupación excesiva difícil de controlar',	'¿Te sientes frecuentemente preocupado sin poder controlar esa preocupación?',	'activo'),
(5,	'Tristeza profunda o prolongada',	'¿Has experimentado tristeza profunda o prolongada recientemente?',	'activo'),
(6,	'Ciclos de energía alta y baja',	'¿Notas cambios drásticos en tus niveles de energía sin razón aparente?',	'activo'),
(7,	'Problemas crónicos para dormir',	'¿Tienes dificultades frecuentes para dormir bien?',	'activo'),
(8,	'Dificultad para organizar tareas cotidianas',	'¿Te resulta complicado organizar tus tareas o responsabilidades diarias?',	'activo'),
(9,	'Procrastinación frecuente',	'¿Sueles postergar actividades importantes constantemente?',	'activo'),
(10,	'Fatiga constante sin causa física',	'¿Te sientes cansado la mayor parte del tiempo sin una causa física clara?',	'activo'),
(11,	'Dificultad para mantenerse sentado por mucho tiempo',	'¿Te resulta difícil permanecer sentado durante periodos prolongados?',	'activo'),
(12,	'Pérdida de interés o placer en casi todas las actividades',	'¿Has perdido el interés o disfrute en actividades que antes te agradaban?',	'activo'),
(13,	'Irritabilidad persistente',	'¿Te sientes irritable con frecuencia, incluso sin motivo evidente?',	'activo'),
(14,	'Sensación de fracaso o culpa excesiva',	'¿Tienes pensamientos persistentes de culpa o sensación de fracaso?',	'activo'),
(15,	'Miedo a situaciones sociales o ser juzgado por otros',	'¿Evitas situaciones sociales por temor a ser juzgado o evaluado?',	'activo'),
(16,	'Pensamientos acelerados en ciclos',	'¿Tu mente suele llenarse de pensamientos acelerados o repetitivos?',	'activo'),
(17,	'Necesidad de dormir muy poco con mucha energía',	'¿Duermes muy poco, pero aun así sientes una energía elevada?',	'activo'),
(18,	'Dificultad para relajarse incluso en momentos tranquilos',	'¿Te cuesta relajarte incluso cuando todo está tranquilo a tu alrededor?',	'activo');

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` enum('medico','paciente') COLLATE utf8mb4_general_ci NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `rol`, `estado`) VALUES
(1,	'jimmy_saurux',	'$2y$10$lqXt2DKQ4Q50iNOsu9dO0eqoSX2/3i/s8xcUqm6oBrcarlZWZnplW',	'medico',	1),
(2,	'matiax2008',	'$2y$10$lqXt2DKQ4Q50iNOsu9dO0eqoSX2/3i/s8xcUqm6oBrcarlZWZnplW',	'paciente',	1);

-- 2025-06-27 23:58:27 UTC
