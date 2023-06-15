<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

include("./connect.php");

// Get the cat_id from the query parameters
$cat_id = $_GET['cat_id'];
$how_many = 15; //$_GET['how_many'];

// Prepare the SQL statement to fetch the q_id values from cat__$cat_id table
$qidQuery = "SELECT q_id FROM `cat__$cat_id` ORDER BY RAND() LIMIT ?";

// Prepare the statement
$stmt = $conn->prepare($qidQuery);

// Bind the parameter
$stmt->bind_param("i", $how_many);

// Execute the query
$stmt->execute();

// Check if the query execution was successful
if ($stmt === false) {
    die("Error executing qidQuery: " . $conn->error);
}

// Get the result
$qidResult = $stmt->get_result();

// Array to store the q_id values
$qids = array();

// Fetch the q_id values
if ($qidResult->num_rows > 0) {
    while ($row = $qidResult->fetch_assoc()) {
        $qids[] = $row['q_id'];
    }
}

// Array to store the questions, a_id values, answer values, and is_true values
$questions = array();

// Fetch the questions, a_id values, answer values, and is_true values
foreach ($qids as $q_id) {
    // Prepare the SQL statement to fetch the question from the questions table
    $questionQuery = "SELECT question FROM questions WHERE q_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($questionQuery);

    // Bind the parameter
    $stmt->bind_param("i", $q_id);

    // Execute the query
    $stmt->execute();

    // Check if the query execution was successful
    if ($stmt === false) {
        die("Error executing questionQuery: " . $conn->error);
    }

    // Get the result
    $questionResult = $stmt->get_result();

    // Fetch the question
    if ($questionResult->num_rows > 0) {
        $questionRow = $questionResult->fetch_assoc();
        $question = $questionRow['question'];

        // Generate the table name for qans__$q_id
        $qansTableName = "qans__" . $q_id;

        // Prepare the SQL statement to fetch the a_id values and is_true values from qans__$q_id table
        $aIdQuery = "SELECT a_id, is_true FROM `$qansTableName`";

        // Prepare the statement
        $stmt = $conn->prepare($aIdQuery);

        // Execute the query
        $stmt->execute();

        // Check if the query execution was successful
        if ($stmt === false) {
            die("Error executing aIdQuery: " . $conn->error);
        }

        // Get the result
        $aIdResult = $stmt->get_result();

        // Fetch the a_id values and is_true values
        if ($aIdResult->num_rows > 0) {
            while ($aIdRow = $aIdResult->fetch_assoc()) {
                $a_id = $aIdRow['a_id'];
                $is_true = $aIdRow['is_true'];

                // Prepare the SQL statement to fetch the answer from the answers table
                $answerQuery = "SELECT answer FROM answers WHERE a_id = ?";

                // Prepare the statement
                $stmt = $conn->prepare($answerQuery);

                // Bind the parameter
                $stmt->bind_param("i", $a_id);

                // Execute the query
                $stmt->execute();

                // Check if the query execution was successful
                if ($stmt === false) {
                    die("Error executing answerQuery: " . $conn->error);
                }

                // Get the result
                $answerResult = $stmt->get_result();

                // Fetch the answer
                if ($answerResult->num_rows > 0) {
                    $answerRow = $answerResult->fetch_assoc();
                    $answer = $answerRow['answer'];

                    // Store the question, a_id, answer, and is_true values in the array
                    $questions[] = array(
                        'question' => $question,
                        'a_id' => $a_id,
                        'answer' => $answer,
                        'is_true' => $is_true
                    );
                }
            }
        }
    }
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();

$quizData = array();

$questionMap = array();
foreach ($questions as $questionData) {
    $question = $questionData['question'];
    $options = $questionData['answer'];
    $correctAnswer = $questionData['is_true'];

    // Check if the question already exists in the map
    if (isset($questionMap[$question])) {
        // Add options to the existing question entry
        $quizData[$questionMap[$question]]['options'][] = $options;
        // Update the correct answer if necessary
        if ($correctAnswer == 1) {
            $quizData[$questionMap[$question]]['correct_answer'] = $options;
        }
    } else {
        // Add a new question entry to the quiz data
        $quizData[] = array(
            'question' => $question,
            'options' => array($options),
            'correct_answer' => ($correctAnswer == 1) ? $options : ''
        );
        // Update the question map
        $questionMap[$question] = count($quizData) - 1;
    }
}

// Output the quiz data as JSON
$jsonData = json_encode($quizData);

if ($jsonData === false) {
    die("Error encoding quizData to JSON: " . json_last_error_msg());
}

echo $jsonData;
?>
