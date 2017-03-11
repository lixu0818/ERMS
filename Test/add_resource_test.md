####Login as user3
####On the Main Menu, click the "Add new resource" link
---

**regular insertion**

* Type in resource name "antibiotics"
* Select from dropdown menu "(#8) Public Health and Medical Services"
* Type in Model "Ampicilin"
* Type in Lat "10" and Lon "10"
* Type in cost$ "5" and per "item"
* Click 'save' button 
* Expect data saved in database

---

**insertion with additional ESFs**

* Type in resource name "car"
* Select from ESF dropdown menu "(#1) "Transportation"
* Select from Addtional ESF list "(#2) Communications and (#3) Public Workds and Engineering"
* Type in Model "Ford"
* Type in Lat "10" and Lon "10"
* Type in cost$ "100" and per "day"
* Click 'save' button 
* Expect data saved in database 

---
**insertion with Capabilities **

* Type in resource name "bandage"
* Select from dropdown menu "(#8) Public Health and Medical Services"
* Type in Model "1.0"
* Type in Capabilities "protection, hygiene, recovery"
* Type in Lat "10" and Lon "10"
* Type in cost$ "1" and per "item"
* Click 'save' button 
* Expect data saved in database with repeated capabilities only saved once.

---
**missing input**

* leave the resource name, primary ESF, Lat, Lon or Cost blank
* Click 'save' button 
* Expect to have a error message "Must enter resource name, primary ESF, Lat, Lon and Cost."

---
---
**similar to add_incident**
---

**Latitude out of range**

* Type in resource name "antibiotics"
* Select from dropdown menu "(#8) Public Health and Medical Services"
* Type in Model "Ampicilin"
* Type in Lat "100" and Lon "10"
* Click 'save' button 
* Expect to have a error message for text box Lat "You must enter a value between -90 and 90"

---
**Longitude out of range**

* Type in resource name "antibiotics"
* Select from dropdown menu "(#8) Public Health and Medical Services"
* Type in Model "Ampicilin"
* Type in Lat "80" and Lon "200.111"
* Click 'save' button 
* Expect to have a error message for text box Lat "You must enter a value between -180 and 180"

---
**Reset button**

* Type in resource name "antibiotics"
* Select from dropdown menu "(#8) Public Health and Medical Services"
* Type in Model "Ampicilin"
* Type in Lat "10" and Lon "10"
* Type in cost$ "5" and per "item"
* Click 'Reset' button 
* Expect to refresh the page and erase all input data

---
**Cancel button**


* Type in resource name "antibiotics"
* Select from dropdown menu "(#8) Public Health and Medical Services"
* Type in Model "Ampicilin"
* Type in Lat "10" and Lon "10"
* Type in cost$ "5" and per "item"
* Click 'Cancel' button 
* Expect to go the Main Menu page with no data saved in database