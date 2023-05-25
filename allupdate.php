<?php

require 'actions/update/update-num-answers.php';
echo "Number of answers per question updated in the 'questions' table <br>";

require 'actions/update/update-num-category.php';
echo "Number of categories per question updated in the 'questions' table <br>";

require 'actions/update/update-question-per-cat.php';
echo "Number of questions per category updated in the 'categories' table <br>";

require 'actions/update/update-questions-per-answer.php';
echo "Number of question including this answer updated in 'answers' table <br><br>";

echo "All data updates complete";

?>