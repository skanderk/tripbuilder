----------------------------------------------------------
-- Cities
----------------------------------------------------------
INSERT INTO city (`name`, `country`) VALUES 
    ('Montreal', 'Canada'), 
    ('Toronto', 'Canada'), 
    ('New York', 'United States'), 
    ('San Francisco', 'United States'), 
    ('Paris', 'France'), 
    ('Rome', 'Italy'), 
    ('Berlin', 'Germany')
;

----------------------------------------------------------
-- Airports
----------------------------------------------------------
-- Montreal
 INSERT INTO airport (`city_id`, `iata_code`, `name`) VALUES 
    (1, 'YUL', 'Pierre Elliot Trudeau Intl')
;

-- Toronto
 INSERT INTO airport (`city_id`, `iata_code`, `name`) VALUES 
    (2, 'YYZ', 'Lester B Pearson Intl'),
    (2, 'YTZ', 'City Centre')
;

-- New York
 INSERT INTO airport (`city_id`, `iata_code`, `name`) VALUES 
    (3, 'JFK', 'John F Kennedy Intl'),
    (3, 'LGA', 'La Guardia')
;

-- San Francisco
 INSERT INTO airport (`city_id`, `iata_code`, `name`) VALUES 
    (4, 'SFO', 'San Francisco Intl')
;

-- Paris
 INSERT INTO airport (`city_id`, `iata_code`, `name`) VALUES 
    (5, 'CDG', 'Charles De Gaulle'),
    (5, 'ORY', 'Orly')
;

----------------------------------------------------------
-- Trips
----------------------------------------------------------
INSERT INTO trip (`name`) VALUES (
    'Vacation in Paris', 
    'Trip to the Valley'
);

----------------------------------------------------------
-- Flights
----------------------------------------------------------
INSERT INTO flight (`departure_airport_id`, `arrival_airport_id`) VALUES 
    (1, 4), -- YUL to JFK
    (4, 6), -- JFK to CDG
    (6, 1), -- CDG to YUL
    (2,8),  -- YYZ to SOF 
    (8,2)   -- SOF to YYZ
;