####Insert some mock data into the database.
## select an incident and enter a distance on the search_resource page

1. Click on the 'Request' button (write down the resource id).
2. Enter a expected return date. Click 'Submit'.
3. Expect to see the message 'Request updated successfully' and return to profile page.
4. Click on 'Resource status' and expect to see the new request displayed.
5. Check Request table to confirm new request added.

---
1. Click on the 'Deploy' button (write down the resource id).
2. Enter the period of deployment in days.
3. Expect to see the message 'Deploy schedule updated successfully' and return to profile page.
4. Restart the resource search and expect to see the deployed resource status as 'In Use'.
5. Check Resource Status page, confirm that the deployed resource is 'in use'.
6. Check Request table to confirm new request added, and the status is set as 'Accepted' because it is a self-request.

---
1. Click on the 'Repair' button for a resource that is 'Available'(write down the resource id).
2. Enter the period of repair in days.
(3. If invalid value(negative days/past date) is entered, expect to see an error message and promp to enter the value again.)
3. Expect to see the message 'Repair schedule updated successfully' and return to profile page.
4. Click on 'Resource status' and expect to see the new repair scheduled.
5. Check Repair_Schedule table to confirm the new schedule entered.

---

1. Click on the 'Repair' button for a resouce that is 'In use'(write down the resource id).
2. Enter the period of repair in days.
3. Expect to see the message 'Repair schedule updated successfully' and return to profile page.
4. Click on 'Resource status' and expect to see the new repair scheduled.
5. Check Repair_Schedule table to confirm the new schedule entered.
