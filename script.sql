CREATE DATABASE tp_secu;
USE tp_secu;
CREATE TABLE membres (
    id int AUTO_INCREMENT PRIMARY KEY,
    pseudo varchar(255),
    pass varchar(255),
    email varchar(255),
    date_inscription date,
    profil_id int,
    rec_st varchar(1),
    FOREIGN KEY (profil_id) REFERENCES profil(id)
);

CREATE TABLE profil(
    id int PRIMARY KEY,
    label varchar(255),
    description varchar(255)
);
INSERT INTO profil (id, label) VALUES (1, "employée");
INSERT INTO profil (id, label) VALUES (2, "employeur");

create table session_user (
    id int AUTO_INCREMENT PRIMARY KEY,
    id_membre int,
    open_close varchar(1),
    token varchar(255),
    creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_membre) REFERENCES membres(id)
)