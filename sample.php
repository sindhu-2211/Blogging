<?php
// Database connection (replace with your actual database credentials)
$servername = "localhost:3305";
$username = "root";
$password = "";
$dbname = "blogging";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted and the 'title' and 'content' keys are set
if (isset($_POST['title']) && isset($_POST['content'])) {
    // Get article title and content from the form
    $article_title = $_POST['title'];
    $article_content = $_POST['content'];

    // Insert article into the database using prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO article (title, content, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $article_title, $article_content);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Article submitted successfully!";
    } else {
        // Check for duplicate entry error
        if ($conn->errno == 1062) {
            echo "Error: Duplicate entry. Please try again.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Form not submitted.";
}

// Close the database connection
$conn->close();
?>
