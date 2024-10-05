<?php
// Database connection parameters
$servername = "localhost:3305";
$username = "root";
$password = "";
$dbname = "blogging";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$email = $_POST['email'];
$previous_password = $_POST['previous_password'];
$new_password = $_POST['new_password'];

// Perform validation and secure the input (you can use prepared statements)
$email = mysqli_real_escape_string($conn, $email);
$previous_password = mysqli_real_escape_string($conn, $previous_password);
$new_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password

// Check if the email and previous password match in the database
$sql = "SELECT * FROM signin WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    if (password_verify($previous_password, $stored_password)) {
        // Email and previous password match, update the password
        $update_sql = "UPDATE signin SET password = '$new_password' WHERE email = '$email'";
        
        if ($conn->query($update_sql) === TRUE) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Invalid previous password.";
    }
} else {
    echo "Invalid email.";
}

// Close the database connection
$conn->close();
?>
