CREATE TABLE if not exists stations
(
    id   int         not null auto_increment,
    name varchar(50) not null,
    PRIMARY KEY (id)
);

CREATE TABLE if not exists routes
(
    id   int        not null auto_increment,
    name varchar(3) not null,
    PRIMARY KEY (id),
    INDEX (name)
);

CREATE TABLE if not exists schedules
(
    route_id    varchar(3) not null,
    station_id  int        not null,
    time        varchar(5) not null,
    train_num    int        not null,
    stop_number smallint   not null,
    FOREIGN KEY (route_id) REFERENCES routes (name),
    FOREIGN KEY (station_id) REFERENCES stations (id)
);

CREATE TABLE if not exists users
(
    id       int          not null auto_increment,
    name     varchar(255) not null,
    password varchar(255) not null,
    email    varchar(255) not null,
    PRIMARY KEY (id)
);