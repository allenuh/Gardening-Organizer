# Gardening Organizer

## Database Connection Configuration

Before running the application, you need to set up a database connection. Create a file named `db_conn.php` in the root of your project with the following content:
```
<?php

$sname = "localhost";
$unmae = "your_username";
$password = "your_password";
$db_name = "your_database_name";
$port = 3306;  //if not 3306, use the MySQL port you've changed it to

$conn = mysqli_connect($sname, $unmae, $password, $db_name, $port);

if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
}
?>
```
This program also requires a web server, I used the Apache module that came with XAMPP, and can be downloaded here: https://www.apachefriends.org/download.html.
After XAMPP setup, copy the files in the repository into the htdocs directory of your XAMPP installation. 

This code requires an initial database dump:

1. Open your database management tool (e.g., phpMyAdmin or MySQL command line).
2. Run the SQL dump script provided in `database_dump.sql` to create the database schema and initial data.
3. Update the `db_conn.php` file with your database connection credentials.

Finally, once starting the Apache and MySQL module in Xampp, you can open your web browser and navigate to /localhost/gardening-planner/index and explore the website.
