CREATE DATABASE IF NOT EXISTS proyecto_alejandro;

USE proyecto_alejandro;

CREATE TABLE IF NOT EXISTS t_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    UNIQUE KEY  unique_usuario (email)
);

CREATE TABLE IF NOT EXISTS t_token (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    token VARCHAR(255) NOT NULL,
    fecha_expiracion DATE
);

CREATE TABLE IF NOT EXISTS t_proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    estado VARCHAR(255) NOT NULL,
    tipo VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS t_eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_evento VARCHAR(255) NOT NULL,
    descripcion TEXT,
    aforo_max INT,
    fecha DATE
);

CREATE TABLE IF NOT EXISTS t_cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_curso VARCHAR(255) NOT NULL,
    descripcion TEXT,
    estado VARCHAR(255) NOT NULL,
    aforo_max INT,
    fecha_inicio DATE,
    fecha_final DATE,
    horario VARCHAR(255) NOT NULL,
    precio INT
);

CREATE TABLE IF NOT EXISTS t_talleres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_taller VARCHAR(255) NOT NULL,
    descripcion TEXT,
    aforo_max INT,
    fecha DATE,
    duracion VARCHAR(255) NOT NULL,
    precio INT
);

INSERT INTO t_usuarios (nombre, clave, email) VALUES
('alejandro', '0000', 'emaildeprueba@prueba.com');

INSERT INTO t_eventos (nombre_evento, descripcion, aforo_max, fecha) VALUES
('Lectura de EL QUIJOTE', 'lectura por uno de nuestros compañeros de EL QUIJOTE durante hora y media', 25, '2024-05-26'),
('Promoción del libro', 'promoción del libro recientemente publicado por uno de nuestros compañeros', 100, '2024-05-05'),
('Feria del libro', 'Feria a realizar en santa catalina', 200, '2024-05-15');

INSERT INTO t_talleres (nombre_taller, descripcion, aforo_max, fecha, duracion, precio) VALUES
('Maquetar una portada', 'te enseñaremos como maquetar una portada', 30, '2024-05-26', 'Dos horas', 9);

INSERT INTO t_proyectos (titulo, descripcion, estado, tipo) VALUES
('Creación de textos', 'El cliente necesita la creación de textos acerca de un articulo de prensa', 'pendiente', 'Edición y corrección de textos');

ALTER TABLE t_token
ADD CONSTRAINT fk_usuario_token FOREIGN KEY (id_usuario) REFERENCES t_usuarios(id) ON DELETE CASCADE;