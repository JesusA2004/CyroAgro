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
create table productos (
    folio int unsigned not null auto_increment,
    sku varchar(50) not null unique,
    name varchar(150) not null,
    description text null,
    price decimal(10,2) not null default 0.00,
    cantidadinventario int unsigned not null default 0,
    created_at datetime not null default current_timestamp,
    updated_at datetime not null default current_timestamp on update current_timestamp,
    primary key (folio)
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