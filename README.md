# WeightTracker
**Weight Tracker**

This application is a simple weight tracker application using the following teech stack: HTML & CSS (structure and styling), JavaScript (Vue.js as framework for dynamic changing of information, PHP and MySQL for handling login/register process and database work

Using XAMPP Server to test (be sure to change your settings so that it works for your machine). Be sure to update files for sendmail php file so that PHP's mail function will work well with your system.

Have 2 tables under one database for this program:

Database name: 'insert-name-here'
tables: 
  1. Users - User registration/login information here: id, username, email, password, otp and verified:  Password is hashed through PHP (you may want to use a stronger hashing algorithm) and OTP is the one time passcode that is emailed to the user upon registering. Once OTP is submitted successfully, The verified field (which is defaulted to N for "No") will change to a "Y" for yes.
  2. weight_logs - id, user_id, log_date, weight, unit: this will hold the entry logs the user enters their weight in. user_id is a foreign key to users id field and log_id is the primary key of this database.


Features Completed:
Home Index Page
Contact Us form and submission so that the message the user writes gets emailed to the admin of the website
Register (registration, then it sends an OTP to the user's email which then they have to enter to verify their account, which will then take them back to the main page as a logged in user)

Login (log in process and takes them to the main page as a logged in user)

Verify_Otp (when the user gets their OTP from their email, they'll enter it in this form)

Logout - Kills the session and logs the user out bringing them back to the home page


Features needed to work on:
Log Weight - Refactored code oas of 02/21/2024 - Testing in progress


Features wanting to add:
