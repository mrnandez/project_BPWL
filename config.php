<?php

/* Database credentials. Assuming you are running MySQL
Server with  your Username and Password */

define('EMAIL', 'wandi20ti@mahasiswa.pcr.ac.id');
define('PASSWORD', 'pekanbaru12345');

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'projects');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("Error: Could not connect, check your code again.".

    mysqli_connect_error());
}
