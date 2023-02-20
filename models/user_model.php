<?php

use BotMan\BotMan\Interfaces\UserInterface;

function insertUserIfNecessary(UserInterface $user)
{
    $id       = $user->getId();
    $username = $user->getUsername();
    $nickname = $user->getFirstName();

    global $mysqli;
    $queryCheckUser = "SELECT * FROM users WHERE id = $id LIMIT 1";
    $resultRow = $mysqli->query($queryCheckUser)->fetch_row();

    if ($resultRow == null) {
        $queryInsert = "INSERT INTO users VALUES ('$id', '$username', '$nickname')";
        $mysqli->query($queryInsert);
        return;
    }

    // Update, kolom 1: username, kolom 2: nickname
    if ($username != $resultRow[1] || $nickname != $resultRow[2]) {
        $queryUpdate = "UPDATE users 
                        SET username = '$username', nickname = '$nickname'
                        WHERE id = $id";
        $mysqli->query($queryUpdate);
    }
}
