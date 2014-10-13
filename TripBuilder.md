Trip Builder API
========================

Trip Builder is a collection of webservices for trip management. The application is built using 
Symfony2 framework. 

[composer][1] is needed to install the packages required by this application.

[phpunit][2] is needed to run the functional tests.

1) Installation instructions
----------------------------------

Please follow the steps below in order to install the application on your computer. We assume
that the application will be installed under a directory called TripBuilder.

* Pull the source code from GitHub: `git@github.com:skanderk/tripbuilder.git`

* run: `php composer.phar install` within `TripBuilder` directory.

2) Setting up the database
----------------------------------

* Please edit file `TripBuilder/app/config/parameters.yml`, and set the database 
user and password (`database_user` and `database_password` keys).

* Create database trip_builder: `CREATE DATABASE trip_builder`;

* Create database trip_builder_test. This database is required if you are planning to
run the functional tests: `CREATE DATABASE trip_builder_test`

* Create the required tables in databases trip_builder and trip_builder_test using the SQL queries in file `src/KortS/TripBundle/Resources/sql/schema.sql`

* Populate the created tables using the dataset provided in file `src/KortS/TripBundle/Tests/datasets/dataset_0.sql`

3) Using the API
---------------------------
* Get the list of all airports: http://trips.skanderkort.com/airport/list
* Get at most 3 airports starting from index 2: http://trips.skanderkort.com/airport/list?s=2&c=3
* Add a flight to trip 1 from airport 1 (Montreal, YUL) to airport 4 (New York, JFK): http://trips.skanderkort.com/trip/addFlight/1/d/1/a/4
* List all the flights of trip 1: http://trips.skanderkort.com/trip/flights/1
* Remove flight 1 from trip 1: http://trips.skanderkort.com/trip/removeFlight/1/f/1
* Rename trip 1: http://trips.skanderkort.com/trip/rename/1/n/A%20new%20cool%20name

Request formats are defined in file `src/KortS/TripBundle/Resources/config/routing.yml`

4) Running tests
-----------------

Please use the following command within TripBuilder directory to run the application's functional tests: `phpunit -c app/`

 

[1]:  http://getcomposer.org/
[2]:  https://phpunit.de
