####Insert some mock data into the database.
* Login as 'user1' and password is '123'.
* Click 'Login' button 
* Expect to go the Main Menu page with the user's information displayed and links

---
* Login as 'user1' and password is 'wrongPassword'.
* Click 'Login' button 
* Expect to stay on the Login page with an error message "Login failed. Please try again." displayed

---
* Login as 'userNotExist' and password is 'someRandomPassword'.
* Click 'Login' button 
* Expect to stay on the Login page with an error message "Login failed. Please try again." displayed

