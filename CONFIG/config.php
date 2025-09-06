<?php
$conn = new mysqli('localhost', 'root', 'password', 'keralaTourism');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>