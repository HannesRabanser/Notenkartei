<?php
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_dbname = "noa_notenarchiv";

    // Create connection
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>