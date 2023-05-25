<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST["submit"])) {
    $name = $conn->real_escape_string($_POST["name"]);

    $sql = "INSERT INTO `categories` (`Name`) VALUES ('$name')";
    $result = $conn->query($sql);

    $get_max_cat_id_sql = "SELECT MAX(cat_id) AS max_cat_id FROM categories";
    $result = $conn->query($get_max_cat_id_sql);
    $row = $result->fetch_assoc();
    $max_cat_id = $row['max_cat_id'];

    // Increment the max_cat_id by 1 for the new table name
    $new_table_name = "cat_" . ($max_cat_id + 1);


    if ($result) {
        $category_table_name = 'cat__' . $max_cat_id;
        $create_table_sql = "CREATE TABLE `$category_table_name` (
            cq_id INT AUTO_INCREMENT PRIMARY KEY,
            q_id INT,
            asked INT DEFAULT 0,
            correct INT DEFAULT 0,
            time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
            FOREIGN KEY (q_id) REFERENCES questions(q_id)
        )";
        $create_table_result = $conn->query($create_table_sql);

     /*   if ($create_table_result) {
            echo "Table creation and category insertion successful!";
        } else {
            echo "Error creating category table: " . $conn->error;
        }
    } else {
        echo "Error inserting category: " . $conn->error;
    } */
}
} 

header("Location: ../newcat.php");

?>
