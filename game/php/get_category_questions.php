<?php

include("./connect.php");

// Get the cat_id from the query parameters
$cat_id = $_GET['cat_id'];

// SQL query to fetch the q_id values from cat__$cat_id table
$qidQuery = "SELECT q_id FROM cat__$cat_id";

// Execute the query
$qidResult = $conn->query($qidQuery);

// Check if the query execution was successful
if ($qidResult === false) {
    die("Error executing query: " . $conn->error);
}

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
    // Generate the SQL query to fetch the question from the questions table
    $questionQuery = "SELECT question FROM questions WHERE q_id = $q_id";

    // Execute the query
    $questionResult = $conn->query($questionQuery);

    // Check if the query execution was successful
    if ($questionResult === false) {
        die("Error executing query: " . $conn->error);
    }

    // Fetch the question
    if ($questionResult->num_rows > 0) {
        $questionRow = $questionResult->fetch_assoc();
        $question = $questionRow['question'];

        // Generate the table name for qans__$q_id
        $qansTableName = "qans__$q_id";

        // Generate the SQL query to fetch the a_id values and is_true values from qans__$q_id table
        $aIdQuery = "SELECT a_id, is_true FROM $qansTableName";

        // Execute the query
        $aIdResult = $conn->query($aIdQuery);

        // Check if the query execution was successful
        if ($aIdResult === false) {
            die("Error executing query: " . $conn->error);
        }

        // Fetch the a_id values and is_true values
        if ($aIdResult->num_rows > 0) {
            while ($aIdRow = $aIdResult->fetch_assoc()) {
                $a_id = $aIdRow['a_id'];
                $is_true = $aIdRow['is_true'];

                // Generate the SQL query to fetch the answer from the answers table
                $answerQuery = "SELECT answer FROM answers WHERE a_id = $a_id";

                // Execute the query
                $answerResult = $conn->query($answerQuery);

                // Check if the query execution was successful
                if ($answerResult === false) {
                    die("Error executing query: " . $conn->error);
                }

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

echo json_encode($quizData);


