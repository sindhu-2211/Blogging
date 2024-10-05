<!DOCTYPE html>
<html lang="en">
<head>
    <title>Article List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        header {
            background-color: #007BFF;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
        }

        article {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007BFF;
            cursor: pointer; /* Add cursor pointer to indicate clickable */
        }

        p {
            font-size: 16px;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 15px 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Article List</h1>
</header>

<main>
    <?php
    // Example connection to a database (replace with your actual database connection code)
    $servername = "localhost:3305";
    $username = "root";
    $password = "";
    $dbname = "blogging";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch articles from the database (replace with your actual query)
    $sql = "SELECT id, title, content FROM article";
    $result = $conn->query($sql);

    // Display articles
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<article>';
            echo '<h2 onclick="showContent(' . $row['id'] . ')">' . $row['title'] . '</h2>';
            echo '<div id="content-' . $row['id'] . '" style="display:none;">';
            echo '<p>' . $row['content'] . '</p>';
            echo '<hr>';
            echo '</div>';
            echo '</article>';
        }
    } else {
        echo 'No articles found.';
    }

    // Close connection
    $conn->close();
    ?>

    <script>
        function showContent(articleId) {
            var contentDiv = document.getElementById('content-' + articleId);
            if (contentDiv.style.display === 'none') {
                contentDiv.style.display = 'block';
            } else {
                contentDiv.style.display = 'none';
            }
        }
    </script>
</main>

</body>
</html>
