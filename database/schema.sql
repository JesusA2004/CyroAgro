-- Tabla de usuarios
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(101) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('empleado','cliente','administrador') NOT NULL DEFAULT 'cliente',
    remember_token VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX role_index (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla para tokens de restablecimiento de contraseña
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de sesiones
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de productos
CREATE TABLE productos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    segmento VARCHAR(255) DEFAULT NULL,
    categoria VARCHAR(255) DEFAULT NULL,
    registro VARCHAR(255) DEFAULT NULL,
    contenido TEXT DEFAULT NULL,
    usoRecomendado TEXT DEFAULT NULL,
    dosisSugerida TEXT DEFAULT NULL,
    intervaloAplicacion VARCHAR(255) DEFAULT NULL,
    controla TEXT DEFAULT NULL,
    fichaTecnica VARCHAR(255) DEFAULT NULL,
    hojaSeguridad VARCHAR(255) DEFAULT NULL,
    fotoProducto VARCHAR(255) DEFAULT NULL,
    presentacion VARCHAR(255) DEFAULT NULL,
    creadoPor VARCHAR(255) DEFAULT NULL,
    modificadoPor VARCHAR(255) DEFAULT NULL,
    fechaCreacion DATE DEFAULT NULL,
    fechaActualizacion DATE DEFAULT NULL,
    FotoCatalogo VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
