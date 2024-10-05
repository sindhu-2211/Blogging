<?php
// Establish a database connection
$servername = "localhost:3305";
$dbUsername = "root";
$dbPassword = "";
$database = "blogging";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the 'signin' table if it doesn't exist
$tableCreateSQL = "CREATE TABLE IF NOT EXISTS signin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($tableCreateSQL) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // You should perform data validation and sanitation here

    // In a production environment, you should hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user data into the 'signin' table
    $insertSQL = "INSERT INTO signin (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSQL);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        // User registration successful
        header("Location: login.html");
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
}

$conn->close();
?>
