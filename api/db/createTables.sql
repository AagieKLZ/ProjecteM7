CREATE TABLE if not exists parades
(
    id_parada int         not null auto_increment,
    nom       varchar(50) not null,
    PRIMARY KEY (id_parada)
);

CREATE TABLE if not exists linies
(
    id  int        not null auto_increment,
    nom varchar(3) not null,
    PRIMARY KEY (id),
    INDEX (nom)
);

CREATE TABLE if not exists horarios
(
    linia     varchar(3)                   not null,
    id_parada int                          not null,
    hora      varchar(5)                   not null,
    dia       enum ('feiners','capsetmana') not null,
    id_viaje  int                          not null,
    orden     smallint                     not null,
    FOREIGN KEY (linia) REFERENCES linies (nom),
    FOREIGN KEY (id_parada) REFERENCES parades (id_parada)
);

CREATE TABLE if not exists usuarios
(
    id_usuario int          not null auto_increment,
    nombre     varchar(255) not null,
    password   varchar(255) not null,
    email      varchar(255) not null,
    PRIMARY KEY (id_usuario)
);