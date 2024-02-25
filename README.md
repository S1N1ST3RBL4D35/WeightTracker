# WeightTracker
**Weight Tracker**

This application is a simple weight tracker application using the following teech stack: HTML & CSS (structure and styling), JavaScript (Vue.js as framework for dynamic changing of information, PHP and MySQL for handling login/register process and database work

Using XAMPP Server to test (be sure to change your settings so that it works for your machine). Be sure to update files for sendmail php file so that PHP's mail function will work well with your system.

https://www.codingnepalweb.com/configure-xampp-to-send-mail-from-localhost/  = - This article is fantastic in helping set up sendmail and PHP's mail function

**UPDATE**
Only one table needed: users (id, username, email, password) for registration and login purposes

Changed the plan of this project and just going to use Vue.js to enter weights dynamically onto the screen when user enters the information (won't be saved anywhere as of yet, eventually maybe)


Features Completed:
Home Index Page
Contact Us form and submission so that the message the user writes gets emailed to the admin of the website
Register (registration, then it sends an OTP to the user's email which then they have to enter to verify their account, which will then take them back to the main page as a logged in user)

Login (log in process and takes them to the main page as a logged in user)

Verify_Otp (when the user gets their OTP from their email, they'll enter it in this form)

Logout - Kills the session and logs the user out bringing them back to the home page

Log Weight - Simple form where user enters the date and their weight, click "Log Weight" and their entry will be dynamically displayed in a table underneath the form. Will work on more features at a later date.


