<?php

echo '<nav>
<a target="_blank" href="./index.php">Home</a><br>
<a target="_blank" href="./allupdate.php">Perform All Updates</a><br>
<a target="_blank" href="./allcats.php">Show all Categories</a><br>
<a target="_blank" href="./allquestions.php">Show all Questions</a><br>
<a target="_blank" href="./allanswers.php">Show all Answers</a><br>
<a target="_blank" href="./fullquestion.php">Add new Data</a>
</nav>';

echo '<br><br>';

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve the q_id and question from the table
$query = "SELECT q_id, question, num_cats, num_ans FROM questions";

// Execute the query
$result = $conn->query($query);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Loop through each row and print the data
    while ($row = $result->fetch_assoc()) {
        $q_id = $row["q_id"];
        $question = $row["question"];
        $num_cats = $row["num_cats"];
        $num_ans = $row["num_ans"];
        
        echo "Question ID: $q_id<br>";
        echo "Question: $question<br>";
        echo "Number of Answers: $num_ans<br>";
        echo "Number of Categories: $num_cats<br>";
        
        // Get the answers for the current question
        $qans_table = "qans__" . $q_id;
        $answers_query = "SELECT q.a_id, a.answer, q.is_true
                          FROM $qans_table AS q
                          JOIN answers AS a ON q.a_id = a.a_id";
        $answers_result = $conn->query($answers_query);
        
        if ($answers_result->num_rows > 0) {
            echo "Answers:<br>";
            while ($answer_row = $answers_result->fetch_assoc()) {
                $a_id = $answer_row["a_id"];
                $answer = $answer_row["answer"];
                $is_true = $answer_row["is_true"];
                
                if ($is_true == 1) {
                    echo "<strong>$answer ($a_id)</strong><br>";
                } else {
                    echo "$answer ($a_id)<br>";
                }
            }
        } else {
            echo "No answers found for this question.<br>";
        }
        
        echo "<br>";
    }
} else {
    echo "No rows found.";
}

// Close the connection
$conn->close();
?>
