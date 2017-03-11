use cs6400_team021;

drop table if exists Deploy_Schedule_Audit;
create table Deploy_Schedule_Audit
(
	id int not null auto_increment,
	deploy_schedule_id int not null,
	action varchar(10) not null,
	column_name varchar(50),
	old_value varchar(100),
	new_value varchar(100),
	modified_date date,
	primary key (id)
);

drop table if exists Repair_Schedule_Audit;
create table Repair_Schedule_Audit
(
	id int not null auto_increment,
	repair_schedule_id int not null,
	action varchar(10) not null,
	column_name varchar(50),
	old_value varchar(100),
	new_value varchar(100),
	modified_date date,
	primary key (id)
);

drop table if exists Request_Audit;
create table Request_Audit
(
	id int not null auto_increment,
	request_id int not null,
	requesting_resource_id int not null,
	incident_id int not null,
	sender_username varchar(30),
	action varchar(10) not null,
	column_name varchar(50),
	old_value varchar(100),
	new_value varchar(100),
	modified_date date,
	primary key (id)
);

drop table if exists Resource_Audit;
create table Resource_Audit
(
	id int not null auto_increment,
	resource_id int not null,
	resource_name varchar(50),
	owner_username varchar(20),
	action varchar(10) not null,
	column_name varchar(50),
	old_value varchar(100),
	new_value varchar(100),
	modified_date date,
	primary key (id)
);