<?php
    $SERVER_NAME = "localhost:3307";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";

    $DB_NAME = "mydb_test";
    $conn=mysqli_connect($SERVER_NAME,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);

    if (!$conn) {
        die("Connection failed: ". mysqli_connect_error());
    }
    // echo "Connected successfully";
?>
