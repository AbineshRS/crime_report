<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crime_report";
$alert_message = '';
$alert_type = '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>