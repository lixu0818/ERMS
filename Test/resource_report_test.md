1. Insert some mock data into the database.
2. Login as 'user3' and password is '123'.
3. Click 'Resource Report' link on the Main Page.
4. Expect to see that user3 has x total resources and y of them are in use.
5. Confirm the numbers match what is in the database by issusing the following queries:
```
select count(*) from Resource where owner_username = 'user3';
```
```
select 
	count(*) 
from 
	Deploy_Schedule d 
	join Resource r 
	on d.resource_id = r.id  
where 
    r.owner_username = 'user3'
    and d.start_date <= sysdate()
    and d.end_date > sysdate();
```