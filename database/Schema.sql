-- 1. Crear base de datos
drop database if exists cyrodb;
create database cyrodb;
use cyrodb;

-- 2. Tabla de usuarios
create table users (
    id int unsigned not null auto_increment,
    name varchar(100) not null,
    email varchar(150) not null unique,
    password varchar(255) not null,
    role enum('empleado','cliente','administrador') not null default 'cliente',
    created_at datetime not null default current_timestamp,
    updated_at datetime not null default current_timestamp on update current_timestamp,
    primary key (id)
);

-- 3. Catálogo de productos
CREATE TABLE productos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    segmento VARCHAR(50) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    registro VARCHAR(100) DEFAULT NULL,
    contenido TEXT DEFAULT NULL,
    uso TEXT DEFAULT NULL,
    dosis VARCHAR(255) DEFAULT NULL,
    intervalo_aplicacion VARCHAR(255) DEFAULT NULL,
    controla TEXT DEFAULT NULL,
    ficha_tecnica VARCHAR(255) DEFAULT NULL,
    hoja_seguridad VARCHAR(255) DEFAULT NULL,
    cantidad_inventario INT UNSIGNED DEFAULT 0,
    urlFoto VARCHAR(255) DEFAULT NULL,
    created_by BIGINT UNSIGNED DEFAULT NULL,
    updated_by BIGINT UNSIGNED DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- 4. Encabezado de ticket
create table tickets (
    id bigint unsigned not null auto_increment,
    fecha datetime not null default current_timestamp,
    empleado_id int unsigned not null,
    cliente_id int unsigned null,
    total decimal(12,2) not null,
    created_at datetime not null default current_timestamp,
    primary key (id),
    foreign key (empleado_id) references users(id),
    foreign key (cliente_id) references users(id)
);

-- 5. Detalles de cada ticket
create table detalles (
    id bigint unsigned not null auto_increment,
    ticket_id bigint unsigned not null,
    producto_id int unsigned not null,
    cantidad int not null,
    precio_unit decimal(10,2) not null,
    subtotal decimal(12,2) as (cantidad * precio_unit) stored,
    primary key (id),
    foreign key (ticket_id) references tickets(id),
    foreign key (producto_id) references productos(folio)
);

CREATE TABLE presentaciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    producto_id BIGINT UNSIGNED NOT NULL,
    descripcion VARCHAR(100) NOT NULL,           -- Ej: "250 ml", "1 litro"
    precio_base DECIMAL(10,2) NOT NULL,
    cantidad_inventario INT UNSIGNED DEFAULT 0,   -- Inventario específico por presentación
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

CREATE TABLE cliente_presentacion_precios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cliente_id BIGINT UNSIGNED NOT NULL,
    presentacion_id BIGINT UNSIGNED NOT NULL,
    precio_personalizado DECIMAL(10,2) NOT NULL,
    UNIQUE (cliente_id, presentacion_id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (presentacion_id) REFERENCES presentaciones(id) ON DELETE CASCADE
);
