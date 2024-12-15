CREATE DATABASE agenda;

USE agenda; 

CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,          
    telefono VARCHAR(15) NOT NULL UNIQUE,       
    password VARCHAR(255) NOT NULL,             
    avatar VARCHAR(255)                         
);

CREATE TABLE Contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,         
    nombre VARCHAR(50) NOT NULL,               
    apellidos VARCHAR(50),                      
    telefono VARCHAR(15) NOT NULL,              
    foto VARCHAR(255),                          
    id_usuario INT NOT NULL,                   
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id)
    ON DELETE CASCADE                           
);

CREATE TABLE Mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,          
    texto TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP, 
    id_contacto INT NOT NULL,                   
    FOREIGN KEY (id_contacto) REFERENCES Contactos(id)
    ON DELETE CASCADE                           
);

INSERT INTO Usuarios (telefono,password,avatar)
VALUES ('611223344', '$2b$12$mSHjST/aiPl0ncI1rv2KsO026nx9BkrSuo2otnBS5TeQJpMGEp1Wi', '../public/images/avatar-elo.png');

INSERT INTO Contactos (nombre, apellidos, telefono, foto, id_usuario)
VALUES
    ('Jose', 'Martín Martínez', '622113344', '../public/images/jose.png', 1 ),
    ('Carmen', 'López García', '654123987', '../public/images/carmen.png', 1),
    ('Laura', 'Martínez Ortega', '689321654', '../public/images/laura.png', 1);

INSERT INTO Mensajes (id, texto, fecha_envio, id_contacto)
VALUES
    (1, 'Hola Jose, ¿Cómo estás?', '2024-12-10 11:00:00', 1),
    (2, '¿Te apetece ir al cine esta noche?', '2024-12-12 11:30:00', 1),
    (3, 'Hola Carmen, ¿Cómo estás?', '2024-12-08 11:00:00', 2),
    (4, '¿Quedamos para cenar?', '2024-12-12 12:00:00', 2),
    (5, 'Hola Laura, ¿Cómo estás?', '2024-12-09 14:00:00', 3),
    (6, '¿Nos vemos mañana por la tarde?', '2024-12-10 18:00:00', 3);







