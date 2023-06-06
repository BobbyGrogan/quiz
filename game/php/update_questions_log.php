<?php

// Include the database connection file
include_once('./connect.php');

// Retrieve the data from the query parameters
$question = $_GET['question'];
$selectedAnswer = $_GET['hitAnswer'];
$correctAnswer = $_GET['correctAnswer'];
$category = $_GET['category'];
$timeTaken = $_GET['timeTaken'];
$questionIndex = $_GET['questionIndex'];
$userIP = $_SERVER['REMOTE_ADDR'];

// Get the IDs from the respective tables
$go_selected_a_id = "SELECT `a_id` FROM `answers` WHERE `answer`='$selectedAnswer'";
$get_selected_a_id = $conn->query($go_selected_a_id);
$row_selected_a_id = $get_selected_a_id->fetch_assoc();
$real_selected_a_id = $row_selected_a_id['a_id'];

$go_correct_a_id = "SELECT `a_id` FROM `answers` WHERE `answer`='$correctAnswer'";
$get_correct_a_id = $conn->query($go_correct_a_id);
$row_correct_a_id = $get_correct_a_id->fetch_assoc();
$real_correct_a_id = $row_correct_a_id['a_id'];

$go_question = "SELECT `q_id` FROM `questions` WHERE `question`='$question'";
$get_question = $conn->query($go_question);
$row_question = $get_question->fetch_assoc();
$real_question = $row_question['q_id'];

$go_category = "SELECT `cat_id` FROM `categories` WHERE `name`='$category'";
$get_category = $conn->query($go_category);
$row_category = $get_category->fetch_assoc();
$real_category = $row_category['cat_id'];

// Insert the data into the logs__questions table
$sql = "INSERT INTO logs__questions (`user_ip`, `selected_a_id`, `correct_a_id`, `time_taken`, `q_id`, `cat_id`, `q_num_in_quiz`) 
        VALUES ('$userIP', '$real_selected_a_id', '$real_correct_a_id', '$timeTaken', '$real_question', '$real_category', '$questionIndex')";

if ($conn->query($sql) === TRUE) {
    echo "Insertion successful";
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();

?>
