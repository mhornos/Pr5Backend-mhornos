-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS `pt05_miguel_hornos` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pt05_miguel_hornos`;

-- Creación de la tabla usuaris
CREATE TABLE `usuaris` (
    `ID` int(11) NOT NULL AUTO_INCREMENT, -- Clave primaria
    `nombreUsuario` varchar(50) NOT NULL, -- Nombre de usuario
    `contrasenya` varchar(255) NOT NULL, -- Contraseña
    `correo` varchar(100) NOT NULL, -- Correo
    `ciutat` varchar(100) NOT NULL, -- Ciudad
    `token` varchar(255) DEFAULT NULL, -- Nueva columna: Token para recuperación de contraseña
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
  `marca` varchar(100) NOT NULL, -- Marca
  `model` varchar(100) NOT NULL, -- Modelo
  `color` varchar(50) NOT NULL, -- Color
  `matricula` varchar(20) NOT NULL, -- Matrícula
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
('BMW', 'e90 320d', 'Negre', '6733DGS', 'Miguel', 'https://www.largus.fr/images/styles/max_1300x1300/public/images/top-ventes-occasion-2016-07.jpg?itok=qlbyDvaA'),
('Volkswagen', 'Kombi', 'Blau', '6434DSA', 'Fran', 'https://a.ccdn.es/cnet/2023/06/15/55373819/682216819_g.jpg'),
('Dodge', 'Challenger', 'Negre', '0954OIS', 'Fran', 'https://www.buscocoches.com/data/vehicles/76563579714E32BD907FCE57C12CA61B@1706013716425@690x460-adjust_middle.jpg'),
('Mazda', 'Mx5', 'Vermell', '4321KKL', 'Hector', 'https://images.classic.com/vehicles/d6e13b05eef5cda655d726d7b4631f31.jpeg?ar=16%3A9&fit=crop&w=600'),
('Porsche', 'GT3 RS', 'Gris', '9999FSA', 'Miguel', 'https://images0.autocasion.com/unsafe/origxorig/ad/19/1281/4bf586922f5544159059695d4c1fdfb1460b6101.jpeg'),
('Lexus', 'LFA V10', 'Blanc', '1282AOI', 'Fran', 'https://periodismodelmotor.com/venta-lexus-lfa-2011-6-000-km/337385/venta-lexus-lfa-2011/');


-- Ajustes de AUTO_INCREMENT para las tablas
ALTER TABLE `article`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `usuaris`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

-- Confirmar transacción
COMMIT;
