CREATE TABLE if not exists stations (
    id int not null auto_increment,
    name varchar(50) not null,
    PRIMARY KEY (id)
);
CREATE TABLE if not exists routes (
    id int not null auto_increment,
    name varchar(3) not null,
    colour varchar(20) not null,
    PRIMARY KEY (id),
    INDEX (name)
);
CREATE TABLE if not exists schedules (
    route_id varchar(3) not null,
    station_id int not null,
    time varchar(5) not null,
    train_num int not null,
    stop_number smallint not null,
    PRIMARY KEY (route_id, station_id, time),
    CONSTRAINT fk_route_id FOREIGN KEY (route_id) REFERENCES routes (name),
    CONSTRAINT fk_station_id FOREIGN KEY (station_id) REFERENCES stations (id)
);
CREATE TABLE if not exists users (
    id int not null auto_increment,
    name varchar(255) not null,
    password varchar(255) not null,
    email varchar(255) not null,
    PRIMARY KEY (id)
);
CREATE TABLE if not exists users_permissions (
    user_id int not null,
    route_id varchar(3) not null,
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users (id),
    CONSTRAINT fk_line_users_id FOREIGN KEY (route_id) REFERENCES routes (name)
);

CREATE OR REPLACE VIEW user_admin AS SELECT * FROM users WHERE email <> "admin@tenfe.com";