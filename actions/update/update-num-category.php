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

// SQL query to get the number of rows in each qcats__ table and update num_cats in the questions table
$query = "SELECT q_id FROM questions";
$result = $conn->query($query);

// Check if any rows were returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $q_id = $row["q_id"];
        $qcats_table = "qcats__" . $q_id;
        
        // Get the number of rows in the qcats__ table
        $qcats_query = "SELECT COUNT(*) as num_rows FROM $qcats_table";
        $qcats_result = $conn->query($qcats_query);
        
        if ($qcats_result->num_rows > 0) {
            $qcats_row = $qcats_result->fetch_assoc();
            $num_cats = $qcats_row["num_rows"];
            
            // Update the num_cats variable in the questions table
            $update_query = "UPDATE questions SET num_cats = $num_cats WHERE q_id = $q_id";
            $conn->query($update_query);
        }
    }
}

// Close the connection
$conn->close();

?>
