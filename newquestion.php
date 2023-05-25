<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add Category</title>
    </head>
    <body>
        <!-- <nav>
            <ul>
                <li><a href="##">###</a></li>
                <li><a href="##">###</a></li>
            </ul>
        </nav> -->
        <hero>
            <div>
                <form action="actions/newquestion.php" method="post">
                    <ul>
                        <li><input style="width: 80vw" type=text name="question" placeholder="Question?"></li>
                        <li><input type=text name="category" placeholder="Category ID?"></li>
                    </ul>
                    <button type="submit" name="submit">Add New Question</button>
                </form>
            </div>
        </hero>
    </body>
</html>
