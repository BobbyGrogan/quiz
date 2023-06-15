<?php
$host = "127.0.0.1";
$port = 25003;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user input from the form
    $color = $_POST['color'];

    // Create a socket
    $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

    // Connect to the server
    $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");

    // Send the color to the server
    socket_write($socket, $color, strlen($color)) or die("Could not send data to server\n");

    // Get the server response
    $result = socket_read($socket, 1024) or die("Could not read server response\n");
    echo "Server response: " . $result;

    // Close the socket
    socket_close($socket);
}
?>

<!-- HTML form to accept user input -->
<form method="POST" action="">
    <label>Select a color:</label><br>
    <input type="submit" name="color" value="florida">
    <input type="submit" name="color" value="chess">
    <input type="submit" name="color" value="china">
    <input type="submit" name="color" value="billionares">
</form>
