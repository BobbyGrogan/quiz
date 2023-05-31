<?php

// set some variables
$host = "127.0.0.1";
$port = 25003;
// don't timeout!
set_time_limit(0);

// create socket, bind socket, start listening
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");


// Create a new connection
$conn = new mysqli("localhost", "root", "", "quiz");

// accept incoming connections
while (True) {
$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
$input = socket_read($spawn, 1024) or die("Could not read input\n");

$inputupdate = "INTERT INTO `test_logs` (cat_id, q_id, chosen_a_id, correct_a_id) VALUES ($category, $question, $chosen, $correct)";


$query = "SELECT * FROM categories WHERE cat_id=$input";
$result = $conn->query($query);
$go = $result->fetch_assoc();
$output=$go['name'];

socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
}

// close sockets
socket_close($spawn);
socket_close($socket);

?>
