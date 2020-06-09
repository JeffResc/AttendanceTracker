# AttendanceTracker
On online attendance tracker written in PHP using MySQL

Login page based on [felixhaeberle/pfsense-captive-portal](https://github.com/felixhaeberle/pfsense-captive-portal).
Administration page designed by [HTML5UP](https://html5up.net).

# Setup
Use the following SQL in order to setup your databases
```sql
CREATE TABLE users (username VARCHAR(20), password VARCHAR(20), salt VARCHAR(25), session VARCHAR(25), fname VARCHAR(20), lname VARCHAR(20));
CREATE TABLE class (fname VARCHAR(20), lname VARCHAR(20), photo TINYTEXT);
ALTER TABLE `class` ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY
CREATE TABLE record (studentID TINYINT, status TINYINT, date VARCHAR(20));
```

Then use the following SQL in order to create your admin account keeping in mind sha512 encryption and salt in front of the password
```sql
INSERT INTO `users` (`username`,`password`,`salt`,`fname`,`lname`,`fulladmin`) VALUES ('username','password','salt','First Name','Last Name',`1`);
```