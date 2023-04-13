CREATE TABLE if not exists stations
(
    id   int         not null auto_increment,
    name varchar(50) not null,
    PRIMARY KEY (id)
);
CREATE TABLE if not exists routes
(
    id     int         not null auto_increment,
    name   varchar(3)  not null,
    colour varchar(20) not null,
    PRIMARY KEY (id),
    INDEX (name)
);
CREATE TABLE if not exists schedules
(
    route_id    varchar(3) not null,
    station_id  int        not null,
    time        varchar(5) not null,
    train_num   int        not null,
    stop_number smallint   not null,
    PRIMARY KEY (route_id, station_id, time),
    CONSTRAINT fk_route_id FOREIGN KEY (route_id) REFERENCES routes (name),
    CONSTRAINT fk_station_id FOREIGN KEY (station_id) REFERENCES stations (id)
);
CREATE TABLE if not exists users
(
    id       int          not null auto_increment,
    name     varchar(255) not null,
    password varchar(255) not null,
    email    varchar(255) not null,
    PRIMARY KEY (id)
);
CREATE TABLE if not exists users_permissions
(
    user_id  int        not null,
    route_id varchar(3) not null,
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users (id),
    CONSTRAINT fk_line_users_id FOREIGN KEY (route_id) REFERENCES routes (name)
);

CREATE OR REPLACE VIEW user_admin AS
SELECT *
FROM users
WHERE email <> "admin@tenfe.com";

DELIMITER $$

DROP FUNCTION IF EXISTS getScheduleOrigin$$

CREATE FUNCTION getScheduleOrigin(train_number INT)
    RETURNS VARCHAR(50)
    READS SQL DATA
BEGIN
    DECLARE destination_station VARCHAR(50);
    SELECT s.name
    INTO destination_station
    FROM schedules
             INNER JOIN stations AS s on schedules.station_id = s.id
    WHERE train_num = train_number
    ORDER BY stop_number
    LIMIT 1;
    RETURN destination_station;
END $$

DELIMITER ;

DELIMITER $$

DROP FUNCTION IF EXISTS getScheduleDestination$$

CREATE FUNCTION getScheduleDestination(train_number INT)
    RETURNS VARCHAR(50)
    READS SQL DATA
BEGIN
    DECLARE destination_station VARCHAR(50);
    SELECT s.name
    INTO destination_station
    FROM schedules
             INNER JOIN stations s on schedules.station_id = s.id
    WHERE train_num = train_number
    ORDER BY stop_number DESC
    LIMIT 1;
    RETURN destination_station;
END $$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS getStationsByRouteId$$

CREATE PROCEDURE getStationsByRouteId(IN routeId VARCHAR(3))
BEGIN
    SELECT DISTINCT station_id, s.name
    FROM schedules
             INNER JOIN stations s ON s.id = schedules.station_id
    WHERE route_id = routeId;
END $$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS getLines$$

CREATE PROCEDURE getLines()
BEGIN
    SELECT name FROM routes;
END $$

DELIMITER ;

DELIMITER $$

DROP FUNCTION IF EXISTS getLastTrainNumber$$

CREATE FUNCTION getLastTrainNumber()
    RETURNS INT
    READS SQL DATA
BEGIN
    DECLARE lastTrainNumber INT;
    SELECT MAX(train_num) INTO lastTrainNumber FROM schedules;
    RETURN lastTrainNumber;
END $$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS getStations$$

CREATE PROCEDURE getStations()
BEGIN
    SELECT id, name
    FROM stations
    ORDER BY name;
END $$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS getConnectionsStation$$

CREATE PROCEDURE getConnectionsStation(IN stationId INT)
BEGIN
    SELECT DISTINCT route_id, colour
    FROM schedules
             INNER JOIN routes r ON schedules.route_id = r.name
    WHERE station_id = stationId
    ORDER BY route_id;
END $$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS list_all_lines$$
CREATE PROCEDURE list_all_lines()
BEGIN
    SELECT
        route_id,
        colour,
        Origin,
        Destiny
    FROM
        routes AS R
    INNER JOIN(
        SELECT
            route_id,
            Origin,
            Destiny
        FROM
            (
            SELECT
                S3.route_id,
                T.train_num,
                S1.name AS Origin,
                S2.name AS Destiny
            FROM
                (
                SELECT
                    train_num,
                    MIN(stop_number) AS min_stop_number,
                    MAX(stop_number) AS max_stop_number
                FROM
                    schedules
                GROUP BY
                    train_num
            ) T
        INNER JOIN schedules O ON
            O.train_num = T.train_num AND O.stop_number = T.min_stop_number
        INNER JOIN schedules D ON
            D.train_num = T.train_num AND D.stop_number = T.max_stop_number
        INNER JOIN stations AS S1
        ON
            S1.id = O.station_id
        INNER JOIN stations AS S2
        ON
            S2.id = D.station_id
        INNER JOIN schedules AS S3
        ON
            S3.train_num = T.train_num
        WHERE
            O.station_id <> D.station_id
        ORDER BY
            T.train_num
        ) AS P
    GROUP BY
        route_id,
        Origin,
        Destiny
    ) AS A
    ON
        A.route_id = R.name;
END$$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS get_line_variants$$
CREATE PROCEDURE get_line_variants(IN name VARCHAR(5))
BEGIN
    SELECT
        route_id,
        colour,
        Origin,
        Destiny
    FROM
        routes AS R
    INNER JOIN(
        SELECT
            route_id,
            Origin,
            Destiny
        FROM
            (
            SELECT
                S3.route_id,
                T.train_num,
                S1.name AS Origin,
                S2.name AS Destiny
            FROM
                (
                SELECT
                    train_num,
                    MIN(stop_number) AS min_stop_number,
                    MAX(stop_number) AS max_stop_number
                FROM
                    schedules
                GROUP BY
                    train_num
            ) T
        INNER JOIN schedules O ON
            O.train_num = T.train_num AND O.stop_number = T.min_stop_number
        INNER JOIN schedules D ON
            D.train_num = T.train_num AND D.stop_number = T.max_stop_number
        INNER JOIN stations AS S1
        ON
            S1.id = O.station_id
        INNER JOIN stations AS S2
        ON
            S2.id = D.station_id
        INNER JOIN schedules AS S3
        ON
            S3.train_num = T.train_num
        WHERE
            O.station_id <> D.station_id
        ORDER BY
            T.train_num
        ) AS P
    GROUP BY
        route_id,
        Origin,
        Destiny
    ) AS A
ON
    A.route_id = R.name
WHERE R.name = name;
END$$

DELIMITER ;