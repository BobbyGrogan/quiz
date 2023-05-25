<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST["submit"])) {
    $question = $conn->real_escape_string($_POST["question"]);
    $category = $conn->real_escape_string($_POST["category"]);

    // Insert new question into the questions table
    $insert_question_sql = "INSERT INTO questions (question, first_cat) VALUES ('$question', '$category')";
    $insert_question_result = $conn->query($insert_question_sql);

    if ($insert_question_result) {
        $q_id = $conn->insert_id;

        // Add q_id to category table
        $cat_table = "cat__" . $category;
        $for_cat_stmt = "INSERT INTO $cat_table (q_id) VALUES ('$q_id')";
        $go_for_cat = $conn->query($for_cat_stmt);

        // Create q_cats_ table for category mapping
        $q_cats_table_name = "qcats__" . $q_id;
        $create_q_cats_table_sql = "CREATE TABLE $q_cats_table_name (
            qc_id INT AUTO_INCREMENT PRIMARY KEY,
            cat_id INT,
            asked INT DEFAULT 0,
            correct INT DEFAULT 0,
            time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
            FOREIGN KEY (cat_id) REFERENCES categories (cat_id)
        )";
        $create_q_cats_table_result = $conn->query($create_q_cats_table_sql);

        // Create q_anwrs_ table for answer storage
        $q_anwrs_table_name = "qans__" . $q_id;
        $create_q_anwrs_table_sql = "CREATE TABLE $q_anwrs_table_name (
            qa_id INT AUTO_INCREMENT PRIMARY KEY,
            answer VARCHAR(255),
            is_true INT(8),
            asked INT DEFAULT 0,
            correct INT DEFAULT 0,
            time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
        )";
        $create_q_anwrs_table_result = $conn->query($create_q_anwrs_table_sql);

        $add_to_qcats = "INSERT INTO $q_cats_table_name (cat_id) VALUES ('$category')";
        $send_to_qcats = $conn->query($add_to_qcats);

        if ($create_q_cats_table_result && $create_q_anwrs_table_result) {
            echo "Question added successfully!";
        } else {
            echo "Error creating associated tables: " . $conn->error;
        }
    } else {
        echo "Error inserting question: " . $conn->error;
    }
}

header("../newquestion.php")

?>
