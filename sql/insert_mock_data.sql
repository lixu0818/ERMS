use cs6400_team021;

insert into User (username, password, type) VALUES ('user1', '123', 'Individual');
insert into User (username, password, type) VALUES ('user2', '123', 'Company');
insert into User (username, password, type) VALUES ('user3', '123', 'Municipality');
insert into User (username, password, type) VALUES ('user4', '123', 'Government_Agency');
insert into User (username, password, type) VALUES ('user5', '123', 'Individual');
insert into User (username, password, type) VALUES ('user6', '123', 'Company');
insert into User (username, password, type) VALUES ('user7', '123', 'Municipality');
insert into User (username, password, type) VALUES ('user8', '123', 'Government_Agency');
insert into User (username, password, type) VALUES ('user9', '123', 'Individual');
insert into User (username, password, type) VALUES ('user10', '123', 'Company');
insert into User (username, password, type) VALUES ('user11', '123', 'Municipality');
insert into User (username, password, type) VALUES ('user12', '123', 'Government_Agency');
insert into User (username, password, type) VALUES ('user13', '123', 'Individual');
insert into User (username, password, type) VALUES ('user14', '123', 'Company');
insert into User (username, password, type) VALUES ('user15', '123', 'Municipality');
insert into User (username, password, type) VALUES ('user16', '123', 'Government_Agency');
insert into User (username, password, type) VALUES ('user17', '123', 'Individual');
insert into User (username, password, type) VALUES ('user18', '123', 'Company');
insert into User (username, password, type) VALUES ('user19', '123', 'Municipality');
insert into User (username, password, type) VALUES ('user20', '123', 'Government_Agency');

insert into Individual (username, firstname, lastname, job_title, hired_date) VALUES ('user1', 'Harry', 'Potter', 'Software Developer', '1997-06-26');
insert into Individual (username, firstname, lastname, job_title, hired_date) VALUES ('user5', 'Hao', 'Chen', 'Chemical Engineer', '2014-06-26');
insert into Individual (username, firstname, lastname, job_title, hired_date) VALUES ('user9', 'Joe', 'Smith', 'Dentist', '1998-06-26');
insert into Individual (username, firstname, lastname, job_title, hired_date) VALUES ('user13', 'Andrew', 'Ng', 'Professor', '1996-06-26');
insert into Individual (username, firstname, lastname, job_title, hired_date) VALUES ('user17', 'David', 'Nash', 'Software Developer', '2016-06-26');
insert into Company (username, name, headquarter_location) VALUES ('user2', 'Caterpillar', 'Illinois');
insert into Company (username, name, headquarter_location) VALUES ('user6', 'Intel', 'Portland');
insert into Company (username, name, headquarter_location) VALUES ('user10', 'Microsoft', 'Seattle');
insert into Company (username, name, headquarter_location) VALUES ('user14', 'Google', 'SF');
insert into Company (username, name, headquarter_location) VALUES ('user18', 'Seven Bridges', 'Cambridge');
insert into Municipality (username, name, population_size) VALUES ('user3', 'City of Atlanta', '1000000');
insert into Municipality (username, name, population_size) VALUES ('user7', 'City of Boston', '300000');
insert into Municipality (username, name, population_size) VALUES ('user11', 'City of Cambridge', '200000');
insert into Municipality (username, name, population_size) VALUES ('user15', 'City of Watertown', '100000');
insert into Municipality (username, name, population_size) VALUES ('user19', 'City of Portland', '800000');
insert into Government_Agency (username, name, jurisdiction) VALUES ('user4', 'CDC', 'Federal');
insert into Government_Agency (username, name, jurisdiction) VALUES ('user8', 'FBI', 'Federal');
insert into Government_Agency (username, name, jurisdiction) VALUES ('user12', 'FDA', 'Federal');
insert into Government_Agency (username, name, jurisdiction) VALUES ('user16', 'DoD', 'Federal');
insert into Government_Agency (username, name, jurisdiction) VALUES ('user20', 'DoT', 'Federal');

insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (1, 'user1', '2016-11-01', 'flood', 31.005, 38.202);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (2, 'user1', '2016-11-18', 'traffic accident', 31.122, 38.513);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (3, 'user2', '2016-11-16', 'flood', 27.156, 38.211);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (4, 'user2', '2016-11-16', 'fire', 27.101, 38.204);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (5, 'user3', '2016-11-17', 'land slide', 31.511, 38.721);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (6, 'user3', '2016-11-17', 'midtown power outage', 31.503, 38.701);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (7, 'user3', '2016-11-17', 'hurricane', 31.123, 38.123);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (8, 'user3', '2016-11-18', 'traffic accident', 31.123, 38.521);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (9, 'user4', '2016-11-18', 'flu', 31.235, 38.513);
insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (10, 'user7', '2016-11-18', 'earthquake', 42.35, 71.06);
-- insert into Incident (id, reporter_username, incident_date, description, lon, lat) VALUES (11, 'user5', '2016-11-18', 'fire', 45.52, -122.68);

insert into Cost_Denominator (cost_denominator) VALUES ('day');
insert into Cost_Denominator (cost_denominator) VALUES ('hour');
insert into Cost_Denominator (cost_denominator) VALUES ('week');
insert into Cost_Denominator (cost_denominator) VALUES ('month');
insert into Cost_Denominator (cost_denominator) VALUES ('item');

insert into ESF (id, description) VALUES (1, 'Transportation');	
insert into ESF (id, description) VALUES (2, 'Communications');	
insert into ESF (id, description) VALUES (3, 'Public Works and Engineering');	
insert into ESF (id, description) VALUES (4, 'Firefighting');	
insert into ESF (id, description) VALUES (5, 'Emergency Management');	
insert into ESF (id, description) VALUES (6, 'Mass Care, Emergency Assistance, Housing, and Human Services');
insert into ESF (id, description) VALUES (7, 'Logistics Management and Resource Support');
insert into ESF (id, description) VALUES (8, 'Public Health and Medical Services');	
insert into ESF (id, description) VALUES (9, 'Search and Rescuse');	
insert into ESF (id, description) VALUES (10, 'Oil and Hazardous Materials Response');	
insert into ESF (id, description) VALUES (11, 'Agriculture and Natural Resources');	
insert into ESF (id, description) VALUES (12, 'Energy');	
insert into ESF (id, description) VALUES (13, 'Public Safety and Security');	
insert into ESF (id, description) VALUES (14, 'Long-Term Community Recovery');	
insert into ESF (id, description) VALUES (15, 'External Affairs');	


insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (1, 'user2', 'Tractor', 'toyota', 27.1, 38.3, 3, 50, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (2, 'user2', 'Truck', 'ford', 27.1, 38.3, 3, 40, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (3, 'user2', 'Tent', 'peak', 27.1, 38.3, 6, 60, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (4, 'user3', 'Water', '10000 ton', 30.1, 38.3, 11, 1000, 'week');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (5, 'user3', 'All Terrain Vehicle', 'CAT', 30.1, 38.3, 1, 150, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (6, 'user3', 'Ambulance', 'Medical', 30.1, 38.3, 8, 100, 'hour');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (7, 'user3', 'Hummer', '', 30.1, 38.3, 1, 100, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (8, 'user3', 'Fire truck', '', 30.1, 38.3, 4, 200, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (9, 'user3', 'Bus', '30 seats', 30.1, 38.3, 1, 100, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (10, 'user2', 'Corn', '1000 ton', 27.1, 38.3, 11, 100, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (11, 'user1', 'SUV', 'GMC', 26.1, 39.1, 1, 50, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (12, 'user3', 'Fax machine', '', 30.1, 38.3, 2, 10, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (13, 'user2', 'Portable power supply', '', 27.1, 38.3, 12, 1000, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (14, 'user2', 'Warehouse', '10000 sqft', 27.1, 38.3, 7, 200, 'day');
insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
VALUES (15, 'user3', 'Medicine', 'Tylenol', 30.1, 38.3, 8, 10, 'item');
-- insert into Resource (id, owner_username, name, model, lon, lat, primary_ESF_id, cost_dollar_amount, cost_denominator)
-- VALUES (16, 'user19', 'Fire Truck', '', 45.52, -122.71, 4, 100, 'day');
	
insert into	 Resource_AdditionalESF (resource_id, ESF_id) VALUES (1, 9);
insert into	 Resource_AdditionalESF (resource_id, ESF_id) VALUES (5, 9);
insert into	 Resource_AdditionalESF (resource_id, ESF_id) VALUES (6, 9);
insert into	 Resource_AdditionalESF (resource_id, ESF_id) VALUES (7, 9);
insert into	 Resource_AdditionalESF (resource_id, ESF_id) VALUES (8, 1);
insert into	 Resource_AdditionalESF (resource_id, ESF_id) VALUES (9, 6);
insert into	 Resource_AdditionalESF (resource_id, ESF_id) VALUES (14, 6);

insert into Capability (resource_id, capability) VALUES (1, '500 hp');
insert into Capability (resource_id, capability) VALUES (7, 'GPS');

insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (1, 1, '2016-10-01', '2016-10-07');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (2, 5, '2016-11-01', '2016-12-30');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (3, 6, '2016-12-15', '2016-12-30');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (4, 7, '2016-11-01', '2016-12-30');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (5, 8, '2016-12-10', '2016-12-30');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (6, 9, '2016-12-10', '2016-12-30');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (7, 12, '2017-01-01', '2017-02-01');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (8, 13, '2017-01-01', '2017-02-01');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (9, 2, '2016-12-15', '2016-12-31');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (10, 3, '2017-01-01', '2017-02-01');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (11, 14, '2017-01-01', '2017-02-01');
insert into Repair_Schedule (id, resource_id, start_date, end_date) VALUES (12, 11, '2017-01-01', '2017-02-01');

insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id) 
VALUES (1, 'Accepted', '2016-02-01', 1, 'user1', 1);
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id) 
VALUES (2, 'Pending', '2016-12-10', 6, 'user1', 2);
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (3, 'Accepted', '2017-01-30', 10, 'user2', 3);	
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (4, 'Pending', '2016-12-15', 4, 'user2', 4);	
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (5, 'Pending', '2016-12-19', 4, 'user2', 5);
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (6, 'Accepted', '2016-12-15', 13, 'user3', 6);	
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (7, 'Accepted', '2016-12-15', 3, 'user3', 7);	
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (8, 'Pending', '2017-12-30', 2, 'user3', 8);	
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (9, 'Pending', '2016-12-30', 15, 'user4', 9);
insert into Request (id, status, expected_return_date, requesting_resource_id, sender_username, incident_id)
VALUES (10, 'Pending', '2016-12-30', 5, 'user1', 1);

insert into Deploy_Schedule (id, resource_id, responding_incident_id, start_date, end_date) VALUES (1, 1, 1, '2016-11-01', '2017-01-07');
insert into Deploy_Schedule (id, resource_id, responding_incident_id, start_date, end_date) VALUES (2, 10, 3, '2016-11-02', '2016-12-15');
insert into Deploy_Schedule (id, resource_id, responding_incident_id, start_date, end_date) VALUES (3, 13, 6, '2016-11-02', '2016-12-15');
insert into Deploy_Schedule (id, resource_id, responding_incident_id, start_date, end_date) VALUES (4, 3, 7, '2016-11-02', '2016-12-15');
insert into Deploy_Schedule (id, resource_id, responding_incident_id, start_date, end_date) VALUES (5, 11, 7, '2016-11-02', '2016-12-15');


