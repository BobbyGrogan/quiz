<?php

function getcat($asked, $conn) {
    if (is_numeric($asked)) {
        $query = "SELECT * FROM categories WHERE cat_id=$input";
        $result = $conn->query($query);
        $go = $result->fetch_assoc();
        $output=$go['name'];
        return $output;
    } else {
        $query = "SELECT * FROM categories WHERE `name`=$input";
        $result = $conn->query($query);
        $go = $result->fetch_assoc();
        $output=$go['cat_id'];
        return $output;
    }
}

?>