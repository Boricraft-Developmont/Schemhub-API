<?php

function getAuthor($key) {
    include '../../config/apikey.php';

    $query = "SELECT username FROM users WHERE apikey='$key' LIMIT 1";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
    return $user['username'];

}