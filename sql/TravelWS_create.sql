-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2015-12-02 04:11:44.371

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS travel_ws;
CREATE DATABASE travel_ws CHARACTER SET utf8 COLLATE utf8_general_ci;
USE travel_ws;

-- tables
-- Table contracts
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE contracts (
    id int NOT NULL,
    tour_id int  NOT NULL,
    customer_id_number varchar(45)  NOT NULL,
    company_name varchar(45)  NOT NULL,
    company_phone varchar(45)  NOT NULL,
    company_address varchar(90)  NOT NULL,
    booking_tickets int  NOT NULL,
    total_money int  NOT NULL,
    CONSTRAINT contract_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table places
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE places (
    id int  NOT NULL,
    name varchar(45)  NOT NULL,
    city varchar(45)  NOT NULL,
    country varchar(45)  NOT NULL,
    address varchar(90)  NOT NULL,
    services varchar(200)  NOT NULL,
    description varchar(10000)  NOT NULL,
    CONSTRAINT place_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table tours
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE tours (
    id int  NOT NULL,
    place_id int  NOT NULL,
    start_date date  NOT NULL,
    tickets int  NOT NULL,
    available_tickets int NOT NULL,
    cost int  NOT NULL,
    description varchar(10000)  NOT NULL,
    CONSTRAINT tour_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

-- foreign keys
-- Reference:  contract_tour (table: contract)


ALTER TABLE contracts ADD CONSTRAINT contracts_tours FOREIGN KEY contracts(tour_id)
    REFERENCES tours (id);
-- Reference:  tour_place (table: tour)


ALTER TABLE tours ADD CONSTRAINT tours_places FOREIGN KEY tours(place_id)
    REFERENCES place (id);



-- End of file.

