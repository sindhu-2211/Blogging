<!-- articles-published.php -->

<?php
// Start a session to track user login
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to the login page if the user is not logged in
    exit();
}

// Establish a database connection
$servername = "localhost:3305";
$dbUsername = "root";
$dbPassword = "";
$database = "blogging";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch articles published by the user
$user_id = $_SESSION['user_id'];
$sql = "SELECT id, content, created_at FROM articles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$articles = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your header information here -->
</head>
<body>
    <h1>Your Published Articles</h1>

    <?php
    if (count($articles) > 0) {
        foreach ($articles as $article) {
            echo "<div>";
            echo "<p>Article ID: " . $article['id'] . "</p>";
            echo "<p>Published on: " . $article['created_at'] . "</p>";
            echo "<p>" . $article['content'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No articles published yet.</p>";
    }
    ?>
    
    <a href="dashboard.php">Go back to the dashboard</a>
</body>
</html>
