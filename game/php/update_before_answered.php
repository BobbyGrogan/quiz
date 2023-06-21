<?php
// Include the database connection file
include_once('./connect.php');

// Retrieve the data from the query parameters
$question = $_GET['question'];
$category = $_GET['category'];

// Prepare the statements

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


    $update_cat_stmt2 = "UPDATE `cat__$real_category` SET asked = asked + 1 WHERE `q_id` = $real_question";
    $conn->query($update_cat_stmt2);

    $update_cats_stmt2 = "UPDATE `categories` SET asked = asked + 1 WHERE `cat_id` = $real_category";
    $conn->query($update_cats_stmt2); 

    $update_q_stmt = "UPDATE `questions` SET asked = asked + 1 WHERE `q_id` = $real_question";
    $conn->query($update_q_stmt);

// Retrieve the 'a1', 'a2', etc. parameters from the URL header
$answerParams = array_filter($_GET, function($key) {
    return strpos($key, 'a') === 0;
}, ARRAY_FILTER_USE_KEY);

// Iterate over the answer parameters
foreach ($answerParams as $answerParam => $answerValue) {
    // Get the 'a_id' of the answer from the database
    $go_selected_a_id = $conn->prepare("SELECT `a_id` FROM `answers` WHERE `answer` = ?");
    $go_selected_a_id->bind_param("s", $answerValue);
    $go_selected_a_id->execute();
    $get_selected_a_id = $go_selected_a_id->get_result();
    $row_selected_a_id = $get_selected_a_id->fetch_assoc();
    $real_selected_a_id = $row_selected_a_id['a_id'];

    // Update 'q_included' for the answer
    $update_ans_stmt = "UPDATE `answers` SET q_included = q_included + 1 WHERE `a_id` = $real_selected_a_id";
    $conn->query($update_ans_stmt);

    $update_qans_stmt = "UPDATE `qans__$real_question` SET asked = asked + 1 WHERE `a_id` = $real_selected_a_id";
    $conn->query($update_qans_stmt);
}

    echo "Insertion Pre-Answer Sucessful!";


// Close the database connection
$conn->close();
?>
