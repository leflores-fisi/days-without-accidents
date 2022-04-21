DROP DATABASE IF EXISTS accidents_app;
CREATE DATABASE accidents_app;

USE accidents_app;

SHOW TABLES;

DROP TABLE IF EXISTS accidents;

CREATE TABLE accidents (
  id INT UNIQUE PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  description VARCHAR(1024),
  date DATE,
  level TINYINT(3)
);

INSERT INTO accidents ( title, description, date, level )
VALUES ( "Pikatrueno en el techo", "Un pikachu hizo desmanes", "2019-01-01", 2 ),
       ( "Un perro atacó al jefe", "Le mordió la piernaAAAA", "2022-04-21", 3 ),
       ( "Incendio en la cocina", "Fue épico, pero catastrófico", "2022-04-20", 2 ),
       ( "Borrachera en el área de recursos humanos", "Se salió de control", "2022-04-10", 2 );
