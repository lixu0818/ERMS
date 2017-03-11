####Login as user3 
####On the Main Menu, click the "Report New Incident" link
---

**regular insertion**

* Type in date "12/23/2016"
* Type in Description "snow storm"
* Type in Lat "80" and Lon "10.111"
* Click 'save' button 
* Expect to go the Main Menu page with data saved in database

---

**missing input**

* leave the date, Description or location blank
* Click 'save' button 
* Expect to have a error message "Please enter date, description and location. "

---
**Latitude out of range**

* Type in date "12/23/2016"
* Type in Description "snow storm"
* Type in Lat "100" and Lon "10"
* Click 'save' button 
* Expect to have a error message for text box Lat "You must enter a value between -90 and 90"

---
**Longitude out of range**

* Type in date "12/23/2016"
* Type in Description "snow storm"
* Type in Lat "80" and Lon "200.111"
* Click 'save' button 
* Expect to have a error message for text box Lat "You must enter a value between -180 and 180"

---
**Reset button**

* Type in date "12/23/2016"
* Type in Description "snow storm"
* Type in Lat "80" and Lon "10.111"
* Click 'Reset' button 
* Expect to refresh the page and erase all input data

---
**Cancel button**

* Type in date "12/23/2016"
* Type in Description "snow storm"
* Type in Lat "80" and Lon "10.111"
* Click 'Cancel' button 
* Expect to go the Main Menu page with no data saved in database