<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.html"); // Redirect to the dashboard if the user is already logged in
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Establish a database connection
    $servername = "localhost:3305";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "blogging";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user exists in the database
    $sql = "SELECT user_id, username, email, password FROM signin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User exists, check the password
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, user is logged in
            // You can set up user sessions or redirect to a dashboard here
        
            header("Location:dashboard.html");
            exit();
        } else {
            // Incorrect password
            echo "Incorrect password. Please try again.";
        }
    } else {
        // User does not exist
        echo "User not found. Please sign up.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
