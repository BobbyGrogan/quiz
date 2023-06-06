<?php

include("./connect.php");

// Retrieve the value of 'name' from the query parameters
$name = $_GET['name'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT cat_id FROM categories WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cat_id = $row['cat_id'];

// Return the cat_id as the response
echo $cat_id;

$stmt->close();
$conn->close();
?>
