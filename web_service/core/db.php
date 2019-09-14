<?php
$servername = "localhost";
$username = "grosshandel16";
$password = "T3g8xClgdity";
$dbname = "koehlert_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
