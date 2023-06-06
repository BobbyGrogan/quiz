<?php

include("./connect.php");

// Fetch categories from the database
$sql = 'SELECT * FROM categories WHERE num_of_questions > 10';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $categories = array();

    // Loop through each row and add it to the categories array
    while ($row = $result->fetch_assoc()) {
        $category = array(
            'name' => $row['name'],
            'description' => $row['description']
        );
        $categories[] = $category;
    }

    // Encode the categories array as JSON and return it
    header('Content-Type: application/json');
    echo json_encode($categories);
} else {
    echo 'No categories found.';
}

$conn->close();
?>
