CREATE DATABASE tp_secu;
USE tp_secu;
CREATE TABLE membres (
    id int AUTO_INCREMENT PRIMARY KEY,
    pseudo varchar(255),
    pass varchar(255),
    email varchar(255),
    date_inscription date,
    profil varchar(255)
);