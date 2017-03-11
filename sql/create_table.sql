
# CREATE DATABASE cs6400_team21;
use cs6400_team021;

DROP TABLE IF EXISTS User;
CREATE TABLE User(
          	username varchar(30) NOT NULL,
          	password varchar(30) NOT NULL,
          	type varchar(20) NOT NULL,
          	PRIMARY KEY (username));

DROP TABLE IF EXISTS Individual;
CREATE TABLE Individual(
          	username varchar(30) NOT NULL,
               firstname varchar(50) NOT NULL,
               lastname varchar(50) NOT NULL,
          	job_title varchar(50) NOT NULL,
          	hired_date date NOT NULL,
          	PRIMARY KEY (username),
          	FOREIGN KEY (username) REFERENCES User (username));

DROP TABLE IF EXISTS Company;
CREATE TABLE Company(
          	username varchar(30) NOT NULL,
               name varchar(100) NOT NULL,
               headquarter_location varchar(50) NOT NULL,
          	PRIMARY KEY (username),
          	FOREIGN KEY (username) REFERENCES User (username));

DROP TABLE IF EXISTS Government_Agency;
CREATE TABLE Government_Agency(
          	username varchar(30) NOT NULL,
               name varchar(100) NOT NULL,
          	jurisdiction varchar(30) NOT NULL,
          	PRIMARY KEY (username),
          	FOREIGN KEY (username) REFERENCES User (username));

DROP TABLE IF EXISTS Municipality;
CREATE TABLE Municipality(
          	username varchar(30) NOT NULL,
               name varchar(100) NOT NULL,
          	population_size int NOT NULL,
          	PRIMARY KEY (username),
          	FOREIGN KEY (username) REFERENCES User (username));

DROP TABLE IF EXISTS Incident;
CREATE TABLE Incident (
          	ID int NOT NULL AUTO_INCREMENT,
          	reporter_username varchar(30) NOT NULL,
          	incident_date date NOT NULL,
          	description varchar(100) NOT NULL,
          	lon decimal(10, 3) NOT NULL,
          	lat decimal(10, 3) NOT NULL,
          	PRIMARY KEY (ID),
          	FOREIGN KEY (reporter_username) REFERENCES User (username));

DROP TABLE IF EXISTS ESF;
CREATE TABLE ESF(
          	ID int NOT NULL,
          	description varchar(100) NOT NULL,
          	PRIMARY KEY (ID));

DROP TABLE IF EXISTS Cost_Denominator;
CREATE TABLE Cost_Denominator(
	cost_denominator varchar(10) NOT NULL,
	PRIMARY KEY (cost_denominator));

DROP TABLE IF EXISTS Resource;
CREATE TABLE Resource(
          	ID int NOT NULL AUTO_INCREMENT,
          	owner_username varchar(30) NOT NULL,
          	name varchar(100) NOT NULL,
          	model varchar(30) NULL,
               lon decimal(10, 3) NOT NULL,
          	lat decimal(10, 3) NOT NULL,
          	primary_ESF_id int NOT NULL,
          	cost_dollar_amount decimal NOT NULL,
          	cost_denominator varchar(10) NOT NULL,
          	PRIMARY KEY (ID),
          	FOREIGN KEY (owner_username) REFERENCES User (username),
          	FOREIGN KEY (primary_ESF_id) REFERENCES ESF (ID),
               FOREIGN KEY (cost_denominator) REFERENCES Cost_Denominator (cost_denominator));

DROP TABLE IF EXISTS Capability;
CREATE TABLE Capability(
          	resource_id int NOT NULL,
          	capability varchar(50) NOT NULL,
          	PRIMARY KEY (resource_id, capability),
          	FOREIGN KEY (resource_id) REFERENCES Resource (ID));

DROP TABLE IF EXISTS Resource_AdditionalESF;
CREATE TABLE Resource_AdditionalESF(
          	resource_id int NOT NULL,
          	ESF_id int NOT NULL,
          	PRIMARY KEY (resource_id, ESF_id),
          	FOREIGN KEY (resource_id) REFERENCES Resource(ID),
               FOREIGN KEY (ESF_id) REFERENCES ESF (ID));

DROP TABLE IF EXISTS Request;
CREATE TABLE Request(
               ID int NOT NULL AUTO_INCREMENT,
               status ENUM('Accepted', 'Pending'),
               expected_return_date datetime NOT NULL,
               requesting_resource_id int NOT NULL,
               sender_username varchar(30) NOT NULL,
          	incident_id int NOT NULL,
          	PRIMARY KEY (ID),
          	FOREIGN KEY (requesting_resource_id) REFERENCES Resource (ID),
          	FOREIGN KEY (sender_username) REFERENCES User (username),
          	FOREIGN KEY (incident_id) REFERENCES Incident (ID),
               CONSTRAINT uc_Request UNIQUE (status, requesting_resource_id, sender_username, incident_id));

DROP TABLE IF EXISTS Repair_Schedule;
CREATE TABLE Repair_Schedule(
          	ID int NOT NULL AUTO_INCREMENT,
          	resource_id int NOT NULL,
          	start_date datetime NOT NULL,
          	end_date datetime NOT NULL,
          	PRIMARY KEY (ID),
          	FOREIGN KEY (resource_id) REFERENCES Resource (ID),
               CONSTRAINT uc_RepairSchedule UNIQUE (resource_id, start_date));

DROP TABLE IF EXISTS Deploy_Schedule;
CREATE TABLE Deploy_Schedule(
          	ID int NOT NULL AUTO_INCREMENT,
          	resource_id int NOT NULL,
          	responding_incident_id int NOT NULL,
          	start_date date NOT NULL,
          	end_date date NOT NULL,
               PRIMARY KEY (ID),
               FOREIGN KEY (resource_id) REFERENCES Resource (ID),
               FOREIGN KEY (responding_incident_id) REFERENCES Incident (ID),
               CONSTRAINT uc_DeploySchedule UNIQUE (resource_id, responding_incident_id, start_date));
