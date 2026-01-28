create database información;
use información;

CREATE TABLE persona (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    n_celular VARCHAR(15),
    tipo ENUM('usuario', 'admin') NOT NULL
);

INSERT INTO persona (nombre, apellido, correo, contraseña, n_celular, tipo)
VALUES ('admin', 'oficial', 'admin@oficial.com', 'oficial123', '242412', 'admin');


-- Tabla Mesa
CREATE TABLE mesa (
    id_mesa INT PRIMARY KEY AUTO_INCREMENT,
    capacidad INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado ENUM('disponible', 'reservada') NOT NULL  
);

INSERT INTO mesa (capacidad, fecha, hora, estado)
VALUES (4, '2025-06-15', '20:00:00', 'disponible');

-- Tabla Reserva
CREATE TABLE reserva (
    id_reserva INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_mesa INT,
    fecha DATE,
    hora TIME,
    estado_reserva ENUM('confirmada', 'cancelada') NOT NULL, 
    FOREIGN KEY (id_usuario) REFERENCES persona(id_usuario),
    FOREIGN KEY (id_mesa) REFERENCES mesa(id_mesa)
);

-- Tabla Comida
CREATE TABLE comida (
    id_comida INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    precio int(10) NOT NULL,
    img LONGBLOB NOT NULL
);


-- Tabla Pedido
CREATE TABLE pedido (
    id_pedido INT NOT NULL,                  
    id_pedido_item INT PRIMARY KEY AUTO_INCREMENT,  
    id_comida INT NOT NULL,
    id_reserva INT NOT NULL,
    cantidad INT NOT NULL,
    monto FLOAT NOT NULL,
    FOREIGN KEY (id_comida) REFERENCES comida(id_comida),
    FOREIGN KEY (id_reserva) REFERENCES reserva(id_reserva)
);


create database restaurante;

