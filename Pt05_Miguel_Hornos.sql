-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS `pt05_miguel_hornos` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pt05_miguel_hornos`;

-- Creación de la tabla usuaris
CREATE TABLE `usuaris` (
    `ID` int(11) NOT NULL AUTO_INCREMENT, -- Clave primaria
    `nombreUsuario` varchar(50) NOT NULL, -- Nombre de usuario
    `contrasenya` varchar(255) NOT NULL, -- Contraseña
    `correo` varchar(100) NOT NULL, -- Correo
    `ciutat` varchar(100) NOT NULL, -- Nueva columna: Ciudad
    PRIMARY KEY (`ID`), -- Clave primaria en el campo ID
    UNIQUE (`nombreUsuario`), -- El nombre de usuario debe ser único
    UNIQUE (`correo`) -- Aseguramos que no haya correos duplicados
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserción de datos en la tabla usuaris (asegúrate de tener usuarios para evitar errores)
INSERT INTO `usuaris` (`nombreUsuario`, `contrasenya`, `correo`, `ciutat`) VALUES
('Miguel', 'Contrasena1234_', 'miguel@gmail.com', 'Barcelona'),
('Fran', 'Contrasena1234_', 'fran@gmail.com', 'Madrid'),
('Hector', 'Contrasena1234_', 'hector@gmail.com', 'Lloret');

-- Creación de la tabla article
CREATE TABLE `article` (
  `ID` int(11) NOT NULL AUTO_INCREMENT, -- Clave primaria
  `marca` varchar(100) NOT NULL, -- Nueva columna: Marca
  `model` varchar(100) NOT NULL, -- Nueva columna: Modelo
  `color` varchar(50) NOT NULL, -- Nueva columna: Color
  `matricula` varchar(20) NOT NULL, -- Nueva columna: Matrícula
  `nom_usuari` varchar(50) DEFAULT NULL, -- Columna para el nombre de usuario que escribió el artículo
  `imatge` varchar(255) DEFAULT NULL, -- Columna para almacenar la ruta de la imagen (opcional)
  PRIMARY KEY (`ID`), -- Clave primaria en el campo ID
  CONSTRAINT `fk_nomUsuari` FOREIGN KEY (`nom_usuari`) REFERENCES `usuaris` (`nombreUsuario`) ON DELETE CASCADE ON UPDATE CASCADE -- Relación entre article y usuaris
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserción de datos en la tabla article
INSERT INTO `article` (`marca`, `model`, `color`, `matricula`, `nom_usuari`,`imatge`) VALUES
('Toyota', 'Corolla', 'Blanc', '1234ABC', 'Miguel', 'https://noticias.coches.com/wp-content/uploads/2014/10/toyota_corolla-gt-s-sport-liftback-ae86-1985-86_r10.jpg'),
('Ford', 'Fiesta', 'Blau', '5678DEF', 'Miguel', 'https://tennants.blob.core.windows.net/stock/142185-0.jpg?v=63615747600000'),
('Honda', 'Civic', 'Verd', '9101GHI', 'Fran', 'https://live.staticflickr.com/2337/1870361700_31046bb363_c.jpg'),
('Volkswagen', 'Polo', 'Blau', '3568JMG', 'Hector', 'https://www.km77.com/media/fotos/volkswagen_polo_2005_1854_1.jpg'),
('BMW', 'e90 320d', 'Negre', '6733DGS', 'Miguel', 'https://www.largus.fr/images/styles/max_1300x1300/public/images/top-ventes-occasion-2016-07.jpg?itok=qlbyDvaA');
-- Ajustes de AUTO_INCREMENT para las tablas
ALTER TABLE `article`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `usuaris`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

-- Confirmar transacción
COMMIT;
