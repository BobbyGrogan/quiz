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
        <hero>
            <div>
                <form action="actions/fullquestion.php" method="post">
                    <ul>
                        <li><input type=text name="question" placeholder="Question?"></li>
                        <li><input type=text name="category" placeholder="Category?"></li>
                        <li><input type=text name="wrong-answers" placeholder="Wrong answers?"></li>
                        <li><input type=text name="correct-answers" placeholder="Correct answers?"></li>
                    </ul>
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </hero>
    </body>
</html>
