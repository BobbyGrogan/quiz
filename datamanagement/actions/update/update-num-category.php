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

// Retrieve the q_ids from the question table
$query = "SELECT q_id FROM questions";
$result = $conn->query($query);

// Check if any rows were returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $q_id = $row["q_id"];
        $qcats_table = "qcats__" . $q_id;

        // Get the length of the qcats__ table
        $qcats_query = "SELECT COUNT(*) as num_cats FROM $qcats_table";
        $qcats_result = $conn->query($qcats_query);

        if ($qcats_result->num_rows > 0) {
            $qcats_row = $qcats_result->fetch_assoc();
            $num_cats = $qcats_row["num_cats"];

            // Update the num_cats field in the questions table
            $update_query = "UPDATE questions SET num_cats = $num_cats WHERE q_id = $q_id";
            $update_result = $conn->query($update_query);

            if ($update_result === TRUE) {
                //echo "Updated num_cats for q_id: $q_id<br>";
            } else {
                echo "Error updating num_cats for q_id: $q_id. Error: " . $conn->error . "<br>";
            }
        }
    }
}

// Close the connection
$conn->close();
?>
