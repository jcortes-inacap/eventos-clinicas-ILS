BEGIN;

CREATE TYPE visibilidad_enum AS ENUM('publico','privado','interno');
CREATE TYPE modalidad_enum AS ENUM('presencial','online','hibrida');
CREATE TYPE estado_bloque_enum AS ENUM('activo','inactivo');
CREATE TYPE estado_inscripcion_enum AS ENUM('pendiente','confirmada','cancelada');

-- =========================================================
-- tablas base
-- =========================================================
CREATE TABLE roles(
    id_roles INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    descripcion VARCHAR(150) NOT NULL,
    estado INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE carreras(
    id_carrera INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    descripcion VARCHAR(150) NOT NULL,
    estado INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE usuarios(
    id_usuarios INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    usuario VARCHAR(80) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    estado INTEGER NOT NULL DEFAULT 1,
    id_roles INTEGER NOT NULL REFERENCES roles(id_roles) ON UPDATE CASCADE,
    id_carrera INTEGER REFERENCES carreras(id_carrera) ON UPDATE CASCADE
);

CREATE TABLE lugar(
    id_lugar INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    direccion VARCHAR(200) NOT NULL,
    tipo VARCHAR(60) NOT NULL
);

-- =========================================================
-- eventos y correos
-- =========================================================
CREATE TABLE evento(
    id_evento INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    afiche_grafico VARCHAR(255),
    visibilidad visibilidad_enum NOT NULL,
    modalidad modalidad_enum NOT NULL,
    qr_url VARCHAR(255),
    requiere_estacionamiento BOOLEAN NOT NULL DEFAULT FALSE,
    duracion INTEGER,
    estado INTEGER NOT NULL DEFAULT 1,
    id_lugar INTEGER REFERENCES lugar(id_lugar) ON UPDATE CASCADE,
    id_usuarios INTEGER REFERENCES usuarios(id_usuarios) ON UPDATE CASCADE
);

CREATE TABLE correo_envio(
    id_envio INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_evento INTEGER NOT NULL REFERENCES evento(id_evento) ON DELETE CASCADE ON UPDATE CASCADE,
    asunto VARCHAR(200) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP NOT NULL DEFAULT NOW()
);

-- =========================================================
-- fechas, bloques y bloque-horario
-- =========================================================
CREATE TABLE fecha_evento(
    id_fecha INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_evento INTEGER NOT NULL REFERENCES evento(id_evento) ON DELETE CASCADE ON UPDATE CASCADE,
    fecha DATE NOT NULL
);

CREATE TABLE bloque(
    id_bloque INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    tiempo_duracion INTEGER NOT NULL,
    estado estado_bloque_enum NOT NULL,
    rango VARCHAR(60),
    id_fecha INTEGER NOT NULL REFERENCES fecha_evento(id_fecha) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE bloque_horario(
    id_bloquehorario INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_bloque INTEGER NOT NULL REFERENCES bloque(id_bloque) ON DELETE CASCADE ON UPDATE CASCADE,
    id_evento INTEGER NOT NULL REFERENCES evento(id_evento) ON DELETE CASCADE ON UPDATE CASCADE,
    descripcion TEXT
);

-- =========================================================
-- cupos
-- =========================================================
CREATE TABLE cupos(
    id_cupos INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_bloquehorario INTEGER NOT NULL REFERENCES bloque_horario(id_bloquehorario) ON DELETE CASCADE ON UPDATE CASCADE,
    cupo_maximo INTEGER NOT NULL,
    cupos_ocupados INTEGER NOT NULL DEFAULT 0,
    cupos_disponibles INTEGER NOT NULL,
    CHECK (cupo_maximo >= 0 AND cupos_ocupados <= cupo_maximo)
);

-- =========================================================
-- participantes, inscripción y estacionamiento
-- =========================================================
CREATE TABLE participante(
    id_participante INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    rut INTEGER UNIQUE,
    nombres VARCHAR(120) NOT NULL,
    apellidos VARCHAR(120) NOT NULL,
    email VARCHAR(150) UNIQUE,
    telefono INTEGER
);

CREATE TABLE inscripcion(
    id_inscripcion INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_bloquehorario INTEGER NOT NULL REFERENCES bloque_horario(id_bloquehorario) ON UPDATE CASCADE,
    id_participante INTEGER NOT NULL REFERENCES participante(id_participante) ON UPDATE CASCADE,
    fecha_registro TIMESTAMP NOT NULL DEFAULT NOW(),
    estado estado_inscripcion_enum NOT NULL
);

CREATE TABLE estacionamiento(
    id_inscripcion INTEGER PRIMARY KEY REFERENCES inscripcion(id_inscripcion) ON DELETE CASCADE ON UPDATE CASCADE,
    tipo_vehiculo VARCHAR(60),
    patente VARCHAR(20),
    nombre_conductor VARCHAR(120)
);

-- =========================================================
-- índices para fks
-- =========================================================
CREATE INDEX idx_usuarios_id_roles ON usuarios(id_roles);
CREATE INDEX idx_usuarios_id_carrera ON usuarios(id_carrera);
CREATE INDEX idx_evento_id_lugar ON evento(id_lugar);
CREATE INDEX idx_evento_id_usuarios ON evento(id_usuarios);
CREATE INDEX idx_correo_id_evento ON correo_envio(id_evento);
CREATE INDEX idx_fecha_evento_id_evento ON fecha_evento(id_evento);
CREATE INDEX idx_bloque_id_fecha ON bloque(id_fecha);
CREATE INDEX idx_bhorario_id_bloque ON bloque_horario(id_bloque);
CREATE INDEX idx_bhorario_id_evento ON bloque_horario(id_evento);
CREATE INDEX idx_cupos_id_bhorario ON cupos(id_bloquehorario);
CREATE INDEX idx_insc_id_bhorario ON inscripcion(id_bloquehorario);
CREATE INDEX idx_insc_id_participante ON inscripcion(id_participante);

COMMIT;

-- Insertar roles básicos del sistema
INSERT INTO roles (descripcion, estado) VALUES
('Administrador', 1),
('Director de Carrera', 1),
('Coordinador', 1),
('Docente', 1),
('Asistente', 1),
('Estudiante', 1),
('Mandinga', 0);

-- Insertar carreras de INACAP sede La Serena
INSERT INTO carreras (descripcion, estado) VALUES
('Ingenieria Informatica', 1),
('Ingenieria Civil Industrial', 0),
('Ingenieria en Maquinaria y Vehiculos Pesados', 1),
('Ingenieria en Conectividad y Redes', 1),
('Analista Programador', 1),
('Administracion de Empresas', 1),
('Contabilidad General', 1),
('Construccion Civil', 1),
('Ingenieria Civil Informatica', 0);

-- Asignar usuarios como director de carrera
INSERT INTO usuarios (nombre, apellidos, usuario, clave, id_roles, id_carrera)
VALUES ('Penka', 'Mandinga', 'penka.mandinga@inacapmail.cl', '$clavehasheada123',  
        (SELECT id_roles FROM roles WHERE descripcion = 'Director de Carrera'),
        (SELECT id_carrera FROM carreras WHERE descripcion = 'Ingenieria Informatica'));

INSERT INTO usuarios (nombre, apellidos, usuario, clave, id_roles, id_carrera)
VALUES ('Raul', 'Astorga', 'raul.mandinga@inacapmail.cl', '$clavehasheada12356',  
        (SELECT id_roles FROM roles WHERE descripcion = 'Director de Carrera'),
        (SELECT id_carrera FROM carreras WHERE descripcion = 'Ingenieria Informatica'));
        
INSERT INTO usuarios (nombre, apellidos, usuario, clave, id_roles, id_carrera)
VALUES ('Alex', 'Diaz', 'alex.mandinga@inacapmail.cl', '$clavehasheada12356',  
        (SELECT id_roles FROM roles WHERE descripcion = 'Director de Carrera'),
        (SELECT id_carrera FROM carreras WHERE descripcion = 'Ingenieria Informatica'));
		
INSERT INTO usuarios (nombre, apellidos, usuario, clave, id_roles, id_carrera)
VALUES ('Jorge', 'Cortez', 'jorge.mandinga@inacapmail.cl', '$clavehasheada12356',  
        (SELECT id_roles FROM roles WHERE descripcion = 'Director de Carrera'),
        (SELECT id_carrera FROM carreras WHERE descripcion = 'Ingenieria Informatica'));
		
INSERT INTO usuarios (nombre, apellidos, usuario, clave, id_roles, id_carrera)
VALUES ('Dani', 'Ruiz', 'dani.mandinga@inacapmail.cl', '$clavehasheada12356',  
        (SELECT id_roles FROM roles WHERE descripcion = 'Director de Carrera'),
        (SELECT id_carrera FROM carreras WHERE descripcion = 'Ingenieria Informatica'));
		
INSERT INTO usuarios (nombre, apellidos, usuario, clave, id_roles, id_carrera)
VALUES ('F', 'Caiceo', 'francisco.mandinga@inacapmail.cl', '$clavehasheada12356',  
        (SELECT id_roles FROM roles WHERE descripcion = 'Director de Carrera'),
        (SELECT id_carrera FROM carreras WHERE descripcion = 'Ingenieria Informatica'));
		
INSERT INTO usuarios (nombre, apellidos, usuario, clave, id_roles, id_carrera)
VALUES ('Ejemplo1', 'ejemplo1', 'ejemplo.mandinga@inacapmail.cl', '$clavehasheada12356',  
        (SELECT id_roles FROM roles WHERE descripcion = 'Director de Carrera'),
        (SELECT id_carrera FROM carreras WHERE descripcion = 'Ingenieria Informatica'));
		

SELECT * FROM roles;

SELECT * FROM usuarios WHERE nombre = 'Penka';
SELECT * FROM usuarios ORDER BY id_usuarios ASC;