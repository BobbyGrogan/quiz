<?php
// Establish a connection to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the a_id values from the answers table
$answers_sql = "SELECT a_id FROM answers";
$answers_result = $conn->query($answers_sql);

if ($answers_result->num_rows > 0) {
    while ($answers_row = $answers_result->fetch_assoc()) {
        $a_id = $answers_row["a_id"];
        
        // Count the number of qans__ tables containing the a_id
        $tables_sql = "SHOW TABLES LIKE 'qans__%'";
        $tables_result = $conn->query($tables_sql);
        
        $included_count = 0; // Counter for the number of qans__ tables including the a_id
        
        if ($tables_result->num_rows > 0) {
            while ($table_row = $tables_result->fetch_row()) {
                $table_name = $table_row[0];
                
                // Check if the a_id exists in the current qans__ table
                $check_sql = "SELECT COUNT(*) AS count FROM $table_name WHERE a_id = $a_id";
                $check_result = $conn->query($check_sql);
                
                if ($check_result->num_rows > 0) {
                    $check_row = $check_result->fetch_assoc();
                    $count = $check_row["count"];
                    
                    // Increment the counter if the a_id is found in the current qans__ table
                    if ($count > 0) {
                        $included_count++;
                    }
                }
            }
        }

        $num_of_questions_stmt = "UPDATE answers SET q_included = '$included_count' WHERE a_id = '$a_id'";
        $send_num_of_questions = $conn->query($num_of_questions_stmt);

    }
}

$conn->close();
?>
