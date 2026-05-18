CREATE TABLE IF NOT EXISTS roles (
    id_rol INT PRIMARY KEY AUTO_INCREMENT,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(150),
    estado BOOLEAN DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    id_rol INT NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    hash_password VARCHAR(255) NOT NULL, 
    intentos_fallidos INT DEFAULT 0, 
    cuenta_bloqueada BOOLEAN DEFAULT 0,  
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso DATETIME,
    CONSTRAINT fk_usuario_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS auditoria_login (
    id_registro INT PRIMARY KEY AUTO_INCREMENT,
    correo_intento VARCHAR(100) NOT NULL, 
    ip_origen VARCHAR(45) NOT NULL,       
    exitoso BOOLEAN NOT NULL,                  
    fecha_intento DATETIME DEFAULT CURRENT_TIMESTAMP,
    detalles_navegador VARCHAR(255)        
) ENGINE=InnoDB;
