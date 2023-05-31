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

$tables_with_length = array(); // List to store table names

// Iterate through qans__ tables
$table_counter = 1;

while (true) {
    $table_name = "qans__" . $table_counter;

    // Check if the table exists
    $check_table_sql = "SHOW TABLES LIKE '$table_name'";
    $check_table_result = $conn->query($check_table_sql);

    if ($check_table_result->num_rows > 0) {
        // Get the length (number of rows) of the table
        $length_sql = "SELECT COUNT(*) AS length FROM $table_name";
        $length_result = $conn->query($length_sql);

        if ($length_result->num_rows > 0) {
            $length_row = $length_result->fetch_assoc();
            $table_length = $length_row["length"];

            if ($table_length > 0) {
                $tables_with_length[] = $table_name;
            }
        }
    } else {
        // Break the loop if the table doesn't exist
        break;
    }

    $table_counter++;
}

$a_id_counts = array(); // Array to store a_id counts

// Count how many times each a_id appears across all tables
foreach ($tables_with_length as $table_name) {
    $count_sql = "SELECT a_id, COUNT(*) AS count FROM $table_name GROUP BY a_id";
    $count_result = $conn->query($count_sql);

    if ($count_result->num_rows > 0) {
        while ($count_row = $count_result->fetch_assoc()) {
            $a_id = $count_row["a_id"];
            $count = $count_row["count"];

            if (!isset($a_id_counts[$a_id])) {
                $a_id_counts[$a_id] = 0;
            }

            $a_id_counts[$a_id] += $count;
        }
    }
}

// Print the a_id counts
foreach ($a_id_counts as $a_id => $count) {
    $update_included_stmt = "UPDATE answers SET q_included = $count WHERE a_id = $a_id";
    $send_update = $conn->query($update_included_stmt);
}    

$conn->close();

?>