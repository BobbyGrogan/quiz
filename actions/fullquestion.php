<?php

echo '<nav>
<a target="_blank" href="../index.php">Home</a><br>
<a target="_blank" href="../allupdate.php">Perform All Updates</a><br>
<a target="_blank" href="../allcats.php">Show all Categories</a><br>
<a target="_blank" href="../allquestions.php">Show all Questions</a><br>
<a target="_blank" href="../allanswers.php">Show all Answers</a><br>
<a href="../fullquestion.php">Add new Data</a>
</nav>';

echo '<br><br>';

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
    $from_answers = $conn->real_escape_string($_POST["answers"]);
    $from_correct = $conn->real_escape_string($_POST["correct"]);

    // QUESTION
    echo "QUESTION <br>";
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
    echo "CATEGORY <br>";
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
    else { echo "No category entered"; }

    // WRONG ANSWERS
    echo "<br><br>ANSWERS <br>";
    if (filledOut($from_answers)) {
        $conv_wrong_answers = handleAnswers($from_answers, $conn);
        $all_a_ids = addAnswers($conv_wrong_answers, $conn);     

        if (!empty($all_a_ids)) {
            foreach ($all_a_ids as $a_id) {
                $added_answer_stmt = "SELECT answer FROM answers WHERE a_id = $a_id";
                $added_answer_result = $conn->query($added_answer_stmt);
        
                if ($added_answer_result->num_rows > 0) {
                    $added_row = $added_answer_result->fetch_assoc();
                    $new_name = $added_row['answer'];
                    echo "$new_name" . " is in answers with a_id " . "$a_id" . "<br>";
                } else {
                    echo "Answer with ID $a_id not found.<br>";
                }
            }
        } 
    }
    else {
        echo "No answers were added.";
    }
    

    if (filledOut($from_category) && filledOut($from_questions)) {
        echo "<br><br>The question id is: " . $used_q_id;
        echo "<br>The category id is: " . $used_cat_id . "<br>";

        $cat_and_q = checkQuestionInCategory($used_q_id, $used_cat_id, $conn);

        echo $cat_and_q;
    }
    //else { echo "No wrong answers entered"; }


    if (filledOut($from_questions) && filledOut($from_answers)) {
        
        $questionanswers = "qans__" . $used_q_id;
        foreach ($all_a_ids as $one_a_id) {
            $is_a_in_q = "SELECT COUNT(*) AS count FROM $questionanswers WHERE a_id = $one_a_id";
            $result = $conn->query($is_a_in_q);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row['count'];

            if ($count > 0) {
               // echo "$one_a_id: Yes<br>";
            } else {
                $insert_a_id = "INSERT INTO $questionanswers (a_id) VALUES ($one_a_id)";
                $insert_result = $conn->query($insert_a_id);

                if ($insert_result) {
                    //echo "$one_a_id: Inserted<br>";
                } else {
                    echo "$one_a_id: Insertion failed<br>";
                }
            }
        }
    }
}  

echo "<br><br>CORRECT ANSWER <br>"; 
if (filledOut($from_correct) && filledOut($from_questions)) {
    $conv_and_add = handleAndAddCorrect($from_correct, $used_q_id, $conn);
    echo $conv_and_add;
}



}

?>
