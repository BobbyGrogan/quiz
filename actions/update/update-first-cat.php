<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve all q_id values from the questions table
$get_q_ids_sql = "SELECT q_id FROM questions";
$result = $conn->query($get_q_ids_sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $q_id = $row['q_id'];

        // Check if first_cat is NULL in the questions table
        $check_first_cat_sql = "SELECT first_cat FROM questions WHERE q_id = $q_id";
        $first_cat_result = $conn->query($check_first_cat_sql);
        $first_cat_row = $first_cat_result->fetch_assoc();
        $first_cat = $first_cat_row['first_cat'];

        if (is_null($first_cat)) {
            $qcats_table_name = "qcats__" . $q_id;

            // Check if there are any entries in the corresponding qcats table
            $check_qcats_sql = "SELECT * FROM $qcats_table_name";
            $qcats_result = $conn->query($check_qcats_sql);

            if ($qcats_result->num_rows > 0) {
                // Retrieve the cat_id value where qc_id = 1
                $get_cat_id_sql = "SELECT cat_id FROM $qcats_table_name WHERE qc_id = 1";
                $cat_id_result = $conn->query($get_cat_id_sql);
                $cat_id_row = $cat_id_result->fetch_assoc();
                $cat_id = $cat_id_row['cat_id'];

                // Update first_cat in the questions table
                $update_first_cat_sql = "UPDATE questions SET first_cat = $cat_id WHERE q_id = $q_id";
                $update_first_cat_result = $conn->query($update_first_cat_sql);

                if ($update_first_cat_result) {
        //            echo "Updated first_cat for q_id $q_id to $cat_id<br>";
                } else {
        //           echo "Error updating first_cat for q_id $q_id<br>";
                }
            } else {
        //        echo "No entries found in $qcats_table_name<br>";
            }
        } else {
        //    echo "first_cat is not NULL for q_id $q_id<br>";
        }
    }
} else {
//    echo "No questions found<br>";
}

?>