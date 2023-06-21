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

// Prepare the statements
$go_selected_a_id = $conn->prepare("SELECT `a_id` FROM `answers` WHERE `answer` = ?");
$go_selected_a_id->bind_param("s", $selectedAnswer);
$go_selected_a_id->execute();
$get_selected_a_id = $go_selected_a_id->get_result();
$row_selected_a_id = $get_selected_a_id->fetch_assoc();
$real_selected_a_id = $row_selected_a_id['a_id'];

$go_correct_a_id = $conn->prepare("SELECT `a_id` FROM `answers` WHERE `answer` = ?");
$go_correct_a_id->bind_param("s", $correctAnswer);
$go_correct_a_id->execute();
$get_correct_a_id = $go_correct_a_id->get_result();
$row_correct_a_id = $get_correct_a_id->fetch_assoc();
$real_correct_a_id = $row_correct_a_id['a_id'];

$go_question = $conn->prepare("SELECT `q_id` FROM `questions` WHERE `question` = ?");
$go_question->bind_param("s", $question);
$go_question->execute();
$get_question = $go_question->get_result();
$row_question = $get_question->fetch_assoc();
$real_question = $row_question['q_id'];

$go_category = $conn->prepare("SELECT `cat_id` FROM `categories` WHERE `name` = ?");
$go_category->bind_param("s", $category);
$go_category->execute();
$get_category = $go_category->get_result();
$row_category = $get_category->fetch_assoc();
$real_category = $row_category['cat_id'];

// Insert the data into the logs__questions table using a prepared statement
$sql = $conn->prepare("INSERT INTO logs__questions (`user_ip`, `selected_a_id`, `correct_a_id`, `time_taken`, `q_id`, `cat_id`, `q_num_in_quiz`) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("siisiii", $userIP, $real_selected_a_id, $real_correct_a_id, $timeTaken, $real_question, $real_category, $questionIndex);

# SHOULD HAVE STUFF LIKE THIS BE LOGGED BEFORE THE QUESTION IS ANSWERED
# $update_cat_stmt1 = "UPDATE `cat__$real_category` SET $asked = $asked + 1 WHERE `q_id` = $real_question";
# $update_cats_stmt1 = "UPDATE `categories` SET $asked = $asked + 1 WHERE `cat_id` = $real_category"
# $update_ans_stmt = "UPDATE answers SET $asked = $asked + 1 WHERE `aid_id` = $AIDS";
# $update_qans_stmt = "UPDATE `qans__$real_category` SET $asked = $asked + 1 WHERE `a_id` = $AIDS";
# $UPDATE `questions` SET $asked = $asked + 1 WHERE `q_id` = $real_question";


if ($real_selected_a_id == $real_correct_a_id) {
    $update_cat_stmt2 = "UPDATE `cat__$real_category` SET correct = correct + 1 WHERE `q_id` = $real_question";
    $conn->query($update_cat_stmt2);

    $update_cats_stmt2 = "UPDATE `categories` SET correct = correct + 1 WHERE `cat_id` = $real_category";
    $conn->query($update_cats_stmt2); 

    $update_ans_stmt = "UPDATE `answers` SET q_correct = q_correct + 1 WHERE `a_id` = $real_selected_a_id";
    $conn->query($update_ans_stmt);

    $update_qans_stmt = "UPDATE `qans__$real_question` SET correct = correct + 1 WHERE `a_id` = $real_selected_a_id";
    $conn->query($update_qans_stmt);

    $update_q_stmt = "UPDATE `questions` SET correct = correct + 1 WHERE `q_id` = $real_question";
    $conn->query($update_q_stmt);
}

if ($real_selected_a_id == 10) {
    $update_qans_oot_stmt = "UPDATE `qans__$real_question` SET asked = asked + 1 WHERE `a_id` = 10";
    $conn->query($update_qans_oot_stmt);
}

if ($sql->execute()) {
    echo "Insertion Post-Answer Sucessful!";
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
