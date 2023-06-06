<?php

include("./connect.php");

// Retrieve the cat_id from the AJAX request
$catId = $_GET['cat_id'];

// SQL query to retrieve information from the table based on the cat_id
$query = "SELECT * FROM categories WHERE cat_id = '$catId'";

// Execute the query
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the first row from the result set
        $row = $result->fetch_assoc();

        // Extract the necessary information
        $categoryId = $row['cat_id'];
        $categoryName = $row['name'];
        $numOfQuestions = $row['num_of_questions'];

        // Generate the response
        $response = "Category ID: " . $categoryId . "<br>";
        $response .= "Category Name: " . $categoryName . "<br>";
        $response .= "Number of Questions: " . $numOfQuestions;
    } else {
        $response = "No category found for the given ID.";
    }
} else {
    $response = "Query execution failed.";
}

// Close the database connection
$conn->close();

// Return the response
echo $response;
?>
