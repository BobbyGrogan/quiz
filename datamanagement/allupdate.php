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

require 'actions/update/update-num-answers.php';
echo "Number of answers per question updated in the 'questions' table <br>";

require 'actions/update/update-num-category.php';
echo "Number of categories per question updated in the 'questions' table <br>";

require 'actions/update/update-question-per-cat.php';
echo "Number of questions per category updated in the 'categories' table <br>";

require 'actions/update/update-questions-per-answer.php';
echo "Number of question including this answer updated in 'answers' table <br>";

require 'actions/update/update-first-cat.php';
echo "First_cat for each question has been updated  in the 'questions' table <br><br>";

echo "All data updates complete";

?>