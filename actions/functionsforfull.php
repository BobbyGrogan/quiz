<?php 

function filledOut($variable) {
    if (!empty($variable)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// TAKES QUESTION INPUT AND SHOWS WHETHER IT EXISTS
function handleQuestion($question, $conn) {
    $result = array(); // Array to store the result values
    
    if (empty($question)) {
        $result['exists'] = "empty";
        $result['question'] = "empty";
        $result['q_id'] = "empty";

    } elseif (is_numeric($question)) {
        $query_for_question_by_q_id = "SELECT question FROM questions WHERE q_id = $question";
        $result_for_question_by_q_id = $conn->query($query_for_question_by_q_id);

        if ($result_for_question_by_q_id->num_rows > 0) {
            $row_for_question_by_q_id = $result_for_question_by_q_id->fetch_assoc();
            $questionValue_for_question_by_q_id = $row_for_question_by_q_id["question"];
            $result['exists'] = 1;
            $result['question'] = $questionValue_for_question_by_q_id;
            $result['q_id'] = $question;
        } else {
            $result['exists'] = 0;
            $result['question'] = "NULL";
            $result['q_id'] = "NULL";
        }
    } else {
        $query_for_question_by_text = "SELECT q_id, question FROM questions WHERE question = '$question'";
        $result_for_question_by_text = $conn->query($query_for_question_by_text);

        if ($result_for_question_by_text->num_rows > 0) {
            $row_for_question_by_text = $result_for_question_by_text->fetch_assoc();
            $q_id_for_question_by_text = $row_for_question_by_text["q_id"];
            $questionValue_for_question_by_text = $row_for_question_by_text["question"];
            $result['exists'] = 1;
            $result['question'] = $questionValue_for_question_by_text;
            $result['q_id'] = $q_id_for_question_by_text;
        } else {
            $result['exists'] = 0;
            $result['question'] = $question;
            $result['q_id'] = "NULL";
        }
    }
    return $result;
}

// DOES NECESSARY MySQL STMTs FOR QUESTION WITHOUT CATEGORY
function addJustQuestion($question, $conn) {

        // Insert new question into the questions table
        $insert_question_sql = "INSERT INTO questions (question) VALUES ('$question')";
        $insert_question_result = $conn->query($insert_question_sql);

        if ($insert_question_result) {
            $q_id = $conn->insert_id;
    
            // Create q_cats_ table for category mapping
            $q_cats_table_name = "qcats__" . $q_id;
            $create_q_cats_table_sql = "CREATE TABLE $q_cats_table_name (
                qc_id INT AUTO_INCREMENT PRIMARY KEY,
                cat_id INT,
                asked INT DEFAULT 0,
                correct INT DEFAULT 0,
                time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
                FOREIGN KEY (cat_id) REFERENCES categories (cat_id)
            )";
            $create_q_cats_table_result = $conn->query($create_q_cats_table_sql);
    
            // Create q_anwrs_ table for answer storage
            $q_anwrs_table_name = "qans__" . $q_id;
            $create_q_anwrs_table_sql = "CREATE TABLE $q_anwrs_table_name (
                qa_id INT AUTO_INCREMENT PRIMARY KEY,
                answer VARCHAR(255),
                is_true INT(8),
                asked INT DEFAULT 0,
                correct INT DEFAULT 0,
                time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
            )";
            $create_q_anwrs_table_result = $conn->query($create_q_anwrs_table_sql);
    
            if ($create_q_cats_table_result && $create_q_anwrs_table_result) {
                return $q_id;
            } else {
                return 0;
            }
        } else {
            return 0;
        } 
}

// TAKES CATEGORY INPUT AND SHOWS WHETHER IT EXISTS
function handleCategory($category, $conn) {
    $result = array(); // Array to store the result values
    
    if (empty($category)) {
        $result['exists'] = 'empty';
        $result['category'] = 'empty';
        $result['cat_id'] = 'empty';

    } elseif (is_numeric($category)) {
        $query_for_category_by_cat_id = "SELECT `name` FROM categories WHERE cat_id = $category";
        $result_for_category_by_cat_id = $conn->query($query_for_category_by_cat_id);

        if ($result_for_category_by_cat_id->num_rows > 0) {
            $row_for_category_by_cat_id = $result_for_category_by_cat_id->fetch_assoc();
            $categoryValue_for_category_by_cat_id = $row_for_category_by_cat_id["name"];
            $result['exists'] = 1;
            $result['category'] = $categoryValue_for_category_by_cat_id;
            $result['cat_id'] = $category; // since cat_id is what was submitted
            
        } else {
            $result['exists'] = 0;
            $result['category'] = "NULL";
            $result['cat_id'] = "NULL";
        }
    } else {
        $query_for_category_by_text = "SELECT cat_id, `name` FROM categories WHERE `name` = '$category'";
        $result_for_category_by_text = $conn->query($query_for_category_by_text);

        if ($result_for_category_by_text->num_rows > 0) {
            $row_for_category_by_text = $result_for_category_by_text->fetch_assoc();
            $cat_id_for_category_by_text = $row_for_category_by_text["cat_id"];
            $categoryValue_for_category_by_text = $row_for_category_by_text["name"];
            $result['exists'] = 1;
            $result['category'] = $categoryValue_for_category_by_text;
            $result['cat_id'] = $cat_id_for_category_by_text;

        } else {
            $result['exists'] = 0;
            $result['category'] = $category;
            $result['cat_id'] = "NULL";
        }
    }
    
    return $result;
}

function addJustCategory($name, $conn) {
    $sql = "INSERT INTO `categories` (`name`) VALUES ('$name')";
    $result = $conn->query($sql);
    $max_cat_id = $conn->insert_id;

    if ($result) {
        $category_table_name = 'cat__' . $max_cat_id;
        $create_table_sql = "CREATE TABLE `$category_table_name` (
            cq_id INT AUTO_INCREMENT PRIMARY KEY,
            q_id INT,
            asked INT DEFAULT 0,
            correct INT DEFAULT 0,
            time_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
            FOREIGN KEY (q_id) REFERENCES questions(q_id)
        )";
        $create_table_result = $conn->query($create_table_sql);
    }

    return $max_cat_id; 
}


// TAKES ANSWERS INPUT AND SHOWS WHETHER THEY EXISTS
function handleAnswers($wrongs, $conn) {
    $result = array(); // Result array to store the item results

    $wrongItems = explode('++', $wrongs); // Split the input by '+'

    foreach ($wrongItems as $item) {
        $item = trim($item); // Remove leading/trailing whitespace

        $itemResult = array();
        
        if (is_numeric($item)) {
            $query = "SELECT a_id, answer FROM answers WHERE a_id = $item";
        } else {
            $query = "SELECT a_id, answer FROM answers WHERE LOWER(answer) = LOWER('$item')";
        }

        $queryResult = $conn->query($query);

        if ($queryResult->num_rows > 0) {
            $row = $queryResult->fetch_assoc();
            $itemResult['exists'] = 1;
            $itemResult['a_id'] = $row['a_id'];
            $itemResult['answer'] = $row['answer'];
        } else {
            $itemResult['exists'] = 0;
            $itemResult['a_id'] = "NULL";
            $itemResult['answer'] = $item;
        }

        $result[] = $itemResult;
    }

    return $result;
}

function noCurrent($exists, $value, $topic, $topicname, $conn) {
    if ($exists == 0) {
        if ($question != "NULL") {
            $for_return = array();

            $to_add_stmt = "INSERT INTO `$topic` ($topicname) VALUES ('$value')";
            $for_return['stmt'] = $to_add_stmt;
            $for_return['new_q_id'] = 1;

            return $for_return;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}



?>