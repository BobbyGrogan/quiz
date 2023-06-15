<?php

// Set some variables
$host = "127.0.0.1";
$port = 25003;
// Set a timeout of 10 seconds
set_time_limit(10);

// Create socket, bind socket, start listening
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

// Create a new connection
$conn = new mysqli("localhost", "root", "", "quiz");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Accept incoming connections
while (true) {
    $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
    $input = socket_read($spawn, 1024) or die("Could not read input\n");

    $output = $input + 1;

    $output = json_encode($output); // Convert output to JSON format

    socket_write($spawn, $output, strlen($output)) or die("Could not write output\n");
}

// Close sockets
socket_close($spawn);
socket_close($socket);

?>
