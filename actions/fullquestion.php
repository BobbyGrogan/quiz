<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST["submit"])) {

    echo "<a style='font-size: 1.5em;' href='../fullquestion.php'>Back</a><br><br>";

    include "./functionsforfull.php";

    $from_questions = $conn->real_escape_string($_POST["question"]);
    $from_category = $conn->real_escape_string($_POST["category"]);
    $from_wrong_answers = $conn->real_escape_string($_POST["wrong-answers"]);
    $from_correct_answers = $conn->real_escape_string($_POST["correct-answers"]);


    // QUESTION
    if (filledOut($from_questions)) {
        $conv_questions = handleQuestion($from_questions, $conn);
        if ($conv_questions['exists'] == 0) {
            if ($conv_questions['question'] != 'NULL') {
                $question_added_id = addJustQuestion($conv_questions['question'], $conn);
                echo "Question has been added with the q_id: " . $question_added_id;
                $used_q_id = $question_added_id;
            }
            else {
                echo "Question ID entered out of Range";
            }
        }
        else {
            $used_q_id = $conv_questions['q_id'];
            echo "Question entered exists with the q_id <strong>'" . $conv_questions['q_id'] . "'</strong> and the content <strong>'" . $conv_questions['question'] . "'</strong>";
        }
    }
    else { echo "No question entered"; }

    echo "<br><br>";

    // CATEGORY
    if (filledOut($from_category)) {
        $conv_category = handleCategory($from_category, $conn);
        if ($conv_category['exists'] == 0) {
            if ($conv_category['category'] != 'NULL') {
                $cat_added_id = addJustCategory($conv_category['category'], $conn);
                echo "Category " . $conv_category['category'] . " has been added with the cat_id " . $cat_added_id;
                $used_cat_id = $cat_added_id;
            }
            else {
                echo "Question ID entered out of Range";
            }
        }
        else {
            $used_cat_id = $conv_category['cat_id'];
            echo "Question entered exists with the q_id <strong>'" . $conv_category['cat_id'] . "'</strong> and the content <strong>'" . $conv_category['category'] . "'</strong>";
        }
    }
    else { echo "No question entered"; }


    if (filledOut($from_category) && filledOut($from_questions)) {
        echo "<br><br>The question id is: " . $used_q_id;
        echo "<br><br>The category id is: " . $used_cat_id;
    }

}

?>
