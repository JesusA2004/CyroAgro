drop database if exists cyrobd;
create database cyrobd;
use cyrobd;

CREATE TABLE productos (
  id INT PRIMARY KEY,
  nombre VARCHAR(255),
  segmento VARCHAR(255) NULL,
  categoria VARCHAR(255) NULL,
  registro VARCHAR(255) NULL,
  contenido TEXT NULL,
  usoRecomendado TEXT NULL,
  dosisSugerida TEXT NULL,
  intervaloAplicacion VARCHAR(255) NULL,
  controla TEXT NULL,
  fichaTecnica VARCHAR(255) NULL,
  hojaSeguridad VARCHAR(255) NULL,
  fotoProducto VARCHAR(255) NULL,
  presentacion VARCHAR(255) NULL,
  creadoPor VARCHAR(255) NULL,
  modificadoPor VARCHAR(255) NULL,
  fechaCreacion DATE NULL,
  fechaActualizacion DATE NULL,
  FotoCatalogo VARCHAR(255) NULL
);

