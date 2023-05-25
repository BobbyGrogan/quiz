<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve the cat_id, name, and num_of_questions from the table
$query = "SELECT cat_id, name, num_of_questions FROM categories";

// Execute the query
$result = $conn->query($query);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Loop through each row and print the data
    while ($row = $result->fetch_assoc()) {
        echo "Category ID: " . $row["cat_id"] . "<br> Category name: <strong>" . $row["name"] . "</strong><br> Number of questions in category: " . $row["num_of_questions"] . "<br><br>";
    }
} else {
    echo "No rows found.";
}

// Close the connection
$conn->close();
?>
