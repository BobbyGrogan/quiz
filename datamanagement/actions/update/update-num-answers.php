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

// SQL query to get the number of rows in each qans__ table and update num_ans in the questions table
$query = "SELECT q_id FROM questions";
$result = $conn->query($query);

// Check if any rows were returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $q_id = $row["q_id"];
        $qans_table = "qans__" . $q_id;
        
        // Get the number of rows in the qans__ table
        $qans_query = "SELECT COUNT(*) as num_rows FROM $qans_table";
        $qans_result = $conn->query($qans_query);
        
        if ($qans_result->num_rows > 0) {
            $qans_row = $qans_result->fetch_assoc();
            $num_ans = $qans_row["num_rows"];
            
            // Update the num_ans variable in the questions table
            $update_query = "UPDATE questions SET num_ans = $num_ans WHERE q_id = $q_id";
            $conn->query($update_query);
        }
    }
}

// Close the connection
$conn->close();

?>
