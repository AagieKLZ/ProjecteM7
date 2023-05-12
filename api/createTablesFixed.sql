CREATE TABLE if not exists stations
(
    id   int         not null auto_increment,
    name varchar(50) not null UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE if not exists routes
(
    id     int         not null auto_increment,
    name   varchar(3)  not null UNIQUE,
    colour varchar(20) not null,
    PRIMARY KEY (id),
    INDEX (name)
);

CREATE TABLE if not exists schedules
(
    station_id  int        not null,
    time        varchar(5) not null,
    train_num   int        not null,
    stop_number smallint   not null,
    PRIMARY KEY (train_num, stop_number),
    CONSTRAINT fk_station_id FOREIGN KEY (station_id) REFERENCES stations (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE if not exists route_trains
(
    route_id VARCHAR(3) NOT NULL,
    train_num INT NOT NULL,
    PRIMARY KEY (route_id, train_num),
    CONSTRAINT fk_route_id FOREIGN KEY (route_id) REFERENCES routes (name) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_train_num FOREIGN KEY (train_num) REFERENCES schedules (train_num) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE if not exists users
(
    id       int          not null auto_increment,
    name     varchar(255) not null,
    password varchar(255) not null,
    email    varchar(255) not null,
    PRIMARY KEY (id)
);
