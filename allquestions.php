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

// SQL query to retrieve the q_id and question from the table
$query = "SELECT q_id, question, num_cats, num_ans FROM questions";

// Execute the query
$result = $conn->query($query);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Loop through each row and print the data
    while ($row = $result->fetch_assoc()) {
        echo "Question ID: " . $row["q_id"] . "<br> Question: " . $row["question"] . "<br>Number of Answers: " . $row["num_ans"] . "<br>Number of Categories: " . $row["num_cats"] . "<br><br>";
    }
} else {
    echo "No rows found.";
}

// Close the connection
$conn->close();
?>
