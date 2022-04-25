DROP DATABASE IF EXISTS accidents_app;
CREATE DATABASE accidents_app;

USE accidents_app;

SHOW TABLES;

DROP TABLE IF EXISTS accidents;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255),
  password VARCHAR(255)
);

CREATE TABLE accidents (
  id INT UNIQUE PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  title VARCHAR(255),
  description VARCHAR(1024),
  date DATE,
  level TINYINT(3),

  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO users (username, password)
VALUES ("test1", "$2y$10$l.a3vQF047eXnkg9kYp5ZuDCRQRvUd4S6wzAkS4tl6iG8J.LKJVlK"), -- user_id: 1, password: 123
       ("test2", "$2y$10$l.a3vQF047eXnkg9kYp5ZuDCRQRvUd4S6wzAkS4tl6iG8J.LKJVlK"); -- user_id: 2, password: 123

INSERT INTO accidents (user_id, title, description, date, level)
VALUES ( 1, "Pikatrueno en el techo", "Un pikachu hizo desmanes", "2019-01-01", 2 ),
       ( 1, "Un perro atacó al jefe", "Le mordió la piernaAAAA", "2022-04-21", 3 ),
       ( 2, "Incendio en la cocina", "Fue épico, pero catastrófico", "2022-04-20", 2 ),
       ( 2, "Borrachera en el área de recursos humanos", "Se salió de control", "2022-04-10", 2 );
