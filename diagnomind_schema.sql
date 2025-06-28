-- Crear base de datos
CREATE DATABASE IF NOT EXISTS diagnomind CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE diagnomind;

-- Tabla de usuarios
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  clave VARCHAR(255) NOT NULL,
  rol ENUM('medico', 'paciente') NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1, -- 0: inactivo, 1: activo, 2: eliminado
);

-- Tabla de médicos
CREATE TABLE medicos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  nombres VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  numero_colegiatura VARCHAR(20) NOT NULL UNIQUE,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de pacientes (fecha y hora SIN valor por defecto)
CREATE TABLE pacientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_medico INT NOT NULL,
  nombres VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  dni CHAR(8) NOT NULL UNIQUE,
  fecha_registro DATE NOT NULL,
  hora_registro TIME NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (id_medico) REFERENCES medicos(id) ON DELETE RESTRICT
);

-- Tabla de síntomas
CREATE TABLE sintomas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  descripcion VARCHAR(200) NOT NULL,
  estado ENUM('activo', 'inactivo') DEFAULT 'activo'
);

INSERT INTO sintomas (descripcion) VALUES
('Falta de concentración'),
('Impulsividad'),
('Hiperactividad o inquietud física'),
('Preocupación excesiva difícil de controlar'),
('Tristeza profunda o prolongada'),
('Ciclos de energía alta y baja'),
('Problemas crónicos para dormir'),
('Dificultad para organizar tareas cotidianas'),
('Procrastinación frecuente'),
('Fatiga constante sin causa física'),
('Dificultad para mantenerse sentado por mucho tiempo'),
('Pérdida de interés o placer en casi todas las actividades'),
('Irritabilidad persistente'),
('Sensación de fracaso o culpa excesiva'),
('Miedo a situaciones sociales o ser juzgado por otros'),
('Pensamientos acelerados en ciclos'),
('Necesidad de dormir muy poco con mucha energía'),
('Dificultad para relajarse incluso en momentos tranquilos');

-- Tabla de atenciones (fecha y hora también sin valores por defecto)
CREATE TABLE atenciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_paciente INT NOT NULL,
  fecha DATE NOT NULL,
  hora TIME NOT NULL,
  resultado TEXT,
  FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE
);

-- Relación entre atenciones y síntomas
CREATE TABLE atencion_sintomas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_atencion INT NOT NULL,
  id_sintoma INT NOT NULL,
  respuesta ENUM('S', 'N') NOT NULL,
  FOREIGN KEY (id_atencion) REFERENCES atenciones(id) ON DELETE CASCADE,
  FOREIGN KEY (id_sintoma) REFERENCES sintomas(id) ON DELETE CASCADE
);
