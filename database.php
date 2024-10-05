<?php
$servername = "localhost:3305";
$username = "root";
$password = "";
$database = "blogging";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// You are now connected to the database. You can perform database operations here.

// Don't forget to close the connection when you're done with it.
$conn->close();
?>
