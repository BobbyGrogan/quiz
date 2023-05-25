<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the maximum cat_id from categories table
$get_max_cat_id_sql = "SELECT MAX(cat_id) AS max_cat_id FROM categories";
$result = $conn->query($get_max_cat_id_sql);

// Check if the query is successful
if ($result) {
    $row = $result->fetch_assoc();
    $max_cat_id = $row['max_cat_id'];

    $inc = 1;

    while ($inc <= $max_cat_id) {
        $table_name = "cat__" . $inc;

        $get_table_length_sql = "SELECT COUNT(*) AS table_length FROM $table_name";
        $result_length = $conn->query($get_table_length_sql);

        if ($result_length && $result_length->num_rows > 0) {
            $length_row = $result_length->fetch_assoc();
            $table_length = $length_row['table_length'];

            // Update the num_of_questions column in categories table
            $update_num_of_questions_sql = "UPDATE categories SET num_of_questions = $table_length WHERE cat_id = $inc";
            $update_result = $conn->query($update_num_of_questions_sql);

        }

        $inc++;
    }
} else {
    echo "Error executing the query: " . $conn->error;
}

// Close the connection
$conn->close();

?>
