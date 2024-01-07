<?php
include "DBConnection.php";
global $conn;
$userId = $_GET['userId'];

$deleteUser = function () use ($conn, $userId) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE users SET is_active=0 WHERE ID=$userId;";

    if ($conn->query($sql) === TRUE) {
        header("Location:adminPage.php?delete=true");

    } else {

        header("Location:adminPage.php?delete=false");
    }
};
$deleteUser();



