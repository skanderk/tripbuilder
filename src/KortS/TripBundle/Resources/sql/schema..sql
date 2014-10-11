------------------------------------------------------------------
-- SQL queries for creating TripBundle database and tables
------------------------------------------------------------------

-- Database trip_builder
CREATE DATABASE trip_builder;

-- Table city
CREATE TABLE city (
    id INT AUTO_INCREMENT NOT NULL, 
    name VARCHAR(64) NOT NULL, 
    country VARCHAR(64) NOT NULL, 
    PRIMARY KEY(id)
) 
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Table airport
CREATE TABLE airport (
    id INT AUTO_INCREMENT NOT NULL, 
    city_id INT DEFAULT NULL, 
    iata_code VARCHAR(3) NOT NULL, 
    name VARCHAR(128) NOT NULL, 
    INDEX IDX_B12CCE5E8BAC62AF (city_id), 
    PRIMARY KEY(id)
) 
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

ALTER TABLE airport ADD CONSTRAINT FK_B12CCE5E8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id);

-- Table trip
CREATE TABLE trip (
    id INT AUTO_INCREMENT NOT NULL, 
    name VARCHAR(128) NOT NULL, 
    PRIMARY KEY(id)
) 
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Table trip_has_flight
CREATE TABLE trip_has_flight (
    trip_id INT NOT NULL, 
    flight_id INT NOT NULL, 
    INDEX IDX_1B672A83A5BC2E0E (trip_id), 
    INDEX IDX_1B672A8391F478C5 (flight_id), 
    PRIMARY KEY(trip_id, flight_id)
) 
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

-- Table flight
CREATE TABLE flight (
    id INT AUTO_INCREMENT NOT NULL, 
    departure_airport_id INT DEFAULT NULL, 
    arrival_airport_id INT DEFAULT NULL, 
    INDEX IDX_C257E60EF631AB5C (departure_airport_id), 
    INDEX IDX_C257E60E7F43E343 (arrival_airport_id), 
    PRIMARY KEY(id)
) 
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF631AB5C FOREIGN KEY (departure_airport_id) REFERENCES airport (id);
ALTER TABLE flight ADD CONSTRAINT FK_C257E60E7F43E343 FOREIGN KEY (arrival_airport_id) REFERENCES airport (id);


-- Constraints linking tables trip and flight.
ALTER TABLE trip_has_flight ADD CONSTRAINT FK_1B672A83A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id);
ALTER TABLE trip_has_flight ADD CONSTRAINT FK_1B672A8391F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id);




