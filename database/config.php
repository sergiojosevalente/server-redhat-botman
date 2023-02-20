<?php

$host = "localhost";
$user = "sergiovalente";
$pass = "@Nazalsp0315";
$db   = "get_attached";

$mysqli = new mysqli($host, $user, $pass, $db);

if (mysqli_connect_errno()) {
    error_log("Error: Could not connect to database.");
    exit;
}
