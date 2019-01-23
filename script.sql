CREATE DATABASE tp_secu;
USE tp_secu;
CREATE TABLE membres (
    id int AUTO_INCREMENT PRIMARY KEY,
    pseudo varchar(255),
    pass varchar(255),
    email varchar(255),
    date_inscription date,
    profil_id int,
    FOREIGN KEY (profil_id) REFERENCES profil(id)
);

CREATE TABLE profil(
    id int PRIMARY KEY,
    label varchar(255),
    description varchar(255)
);
INSERT INTO profil (id, label) VALUES (1, "employée");
INSERT INTO profil (id, label) VALUES (2, "employeur");