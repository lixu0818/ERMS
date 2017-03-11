### Set up:
1. Insert some mock data into database.
2. Log in as 'user3' with password '123'.
3. Click 'Resource Status' on the Main Menu.

### Test for Resource in use:
* Run the following query against the database and confirm the output match the displayed information in the form. The `deploy_schedule_id` will be used in the next step. 
```
	SELECT
	    Resource.id resource_id,
	    Resource.name resource_name,
	    Incident.description,
	    All_user.name owner_name,
	    Deploy_Schedule.start_date,
	    Deploy_Schedule.end_date,
	    Deploy_Schedule.id deploy_schedule_id,
	    Incident.id incident_id 
	FROM
	    Resource
	    INNER JOIN Request
	    ON Resource.id = Request.requesting_resource_id
	    INNER JOIN Incident
	    ON Request.incident_id = Incident.id
	    INNER JOIN Deploy_Schedule
	    ON (Resource.id = Deploy_Schedule.resource_id AND Incident.id = Deploy_Schedule.responding_incident_id)
	    INNER JOIN
	    (
	    SELECT username, name FROM Municipality
	    UNION
	    SELECT username, name FROM Government_Agency
	    UNION
	    SELECT username, name FROM Company
	    UNION
	    SELECT username, concat(firstname, ' ', lastname) as name FROM Individual
	    ) AS All_user
	    ON Resource.owner_username = All_user.username
	WHERE
	    Deploy_Schedule.start_date <= sysdate()
	    AND Deploy_Schedule.end_date > sysdate()
	    AND Incident.reporter_username = 'user3';
```                                

* Click 'Return' for a resource in the form. Confirm that the record disappears. Run query against the Deploy_Schedule table to check the return date has been updated to current sysdate. 
```
select * from Deploy_Schedule where id = $deploy_schedule_id
```

### Test for Resource Requested by me:
* Run the following query against the database and confirm the output match the displayed information in the form: 
```
	SELECT
	    Resource.id resource_id,
	    Resource.name resource_name,
	    Incident.description,
	    All_user.name owner_name,
	    Request.expected_return_date,
	    Request.id request_id 
	FROM
	    Request
	    INNER JOIN Resource
	    ON Request.requesting_resource_id = Resource.id
	    INNER JOIN Incident
	    ON Request.incident_id = Incident.id
	    INNER JOIN
	    (
	    SELECT username, name FROM Municipality
	    UNION
	    SELECT username, name FROM Government_Agency
	    UNION
	    SELECT username, name FROM Company
	    UNION
	    SELECT username, concat(firstname, ' ', lastname) as name FROM Individual
	    ) AS All_user
	        ON Resource.owner_username = All_user.username
	WHERE
	    Request.sender_username = 'user3'
	    and Request.status = 'Pending';
```

* Pick a request, run the following query to confirm the record exists in the Request table. Then click 'Cancel' for that request. Confirm that the record disappears from the form. Run the query again to confirm the request has been deleted. The query should now return null. 
```
select * from Request where id = $request_id
```

### Test for Resource Requests received by me:
* Run the following query against the database and confirm the output match the displayed information in the form: 
```
	SELECT
	    Resource.id resource_id,
	    Resource.name resource_name,
	    Incident.description,
	    All_user.name requester_name,
	    Request.expected_return_date,
	    Request.id request_id, 
	    Incident.id incident_id 
	FROM
	    Request
	    INNER JOIN Resource
	    ON Request.requesting_resource_id = Resource.id
	    INNER JOIN Incident
	    ON Request.incident_id = Incident.id
	    INNER JOIN
	    (
	    SELECT username, name FROM Municipality
	    UNION
	    SELECT username, name FROM Government_Agency
	    UNION
	    SELECT username, name FROM Company
	    UNION
	    SELECT username, concat(firstname, ' ', lastname) as name FROM Individual
	    ) AS All_user
	    ON Request.sender_username = All_user.username
	WHERE
	    Resource.owner_username = 'user3'
	    AND Request.status = 'Pending';
```

* Pick a request, run the following query to confirm the record exists in the Request table. Then click 'Reject' for that request. Confirm that the record disappears from the form. Run the query again to confirm the request has been deleted. The query should now return null. 
```
select * from Request where id = $request_id
```

* Click 'Deploy' for a resource. Confirm that the record disappears from the form, and it should appear in the 'Resource in use' form if login as the requesting user. Then run query against the Request table to check the request status has been changed to 'Accepted'. Run another query against the Deploy_Schedule table to confirm a new row has been inserted with correctly information. 
```
select * from Request where id = $request_id;
```
```
select * from Deploy_Schedule where resource_id = $resource_id and responding_incident_id = $incident_id;
```

### Test for Repair Schedule/In-progress:
* Run the following query the database and confirm the output match the displayed information in the form. Confirm that resources that are currently in-repair do not have a 'Cancel' button. 
```
	SELECT
	    Repair_Schedule.resource_id,
	    Resource.name resource_name,
	    Repair_Schedule.start_date, 
	    Repair_Schedule.end_date,
	    Repair_Schedule.id repair_schedule_id
	FROM
	    Repair_Schedule
	    INNER JOIN Resource
	    ON Repair_Schedule.resource_id = Resource.id
	WHERE
	    Resource.owner_username = 'user3'
	    AND Repair_Schedule.end_date > sysdate();
```

* Run the following query for a resource, confirm that there is a record in Repair_Schedule before clicking 'Cancel', and the record is removed after clicking the button.  
```
select * from Repair_Schedule where id = $repair_schedule_id;	     
```

