<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add Stuff</title>
        <style>
            li { width: 80vw; }
        </style>
    </head>
    <body>
        <nav>
            <a target="_blank" href="./index.php">Home</a><br>
            <a target="_blank" href="./allupdate.php">Perform All Updates</a><br>
            <a target="_blank" href="./allcats.php">Show all Categories</a><br>
            <a target="_blank" href="./allquestions.php">Show all Questions</a><br>
            <a target="_blank" href="./allanswers.php">Show all Answers</a><br>
            <a target="_blank" href="./fullquestion.php">Add new Data</a>
        </nav> 
        <hero>
            <div>
                <form action="actions/fullquestion.php" method="post">
                    <ul>
                        <li><input type=text name="question" placeholder="Question?"></li>
                        <li><input type=text name="category" placeholder="Category?"></li>
                        <li><input type=text name="answers" placeholder="Answers?"></li>
                        <li><input type=text name="correct" placeholder="Correct Answers?"></li>
                    </ul>
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </hero>
    </body>
</html>
