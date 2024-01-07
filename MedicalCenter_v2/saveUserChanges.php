<?php
include "DBConnection.php";
global $conn;
$findSectionId=function ($Name) use ($conn) {
    $sectionID="-----------------";

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT * FROM sections WHERE Name LIKE '" . $Name . "'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $sectionID = $row["ID"];

        }
    }

    return $sectionID;
};

$userId = $_GET['userid'];
$username = urldecode($_GET['username']);
$name = urldecode($_GET['name']);
$email = urldecode($_GET['email']);
$phone = urldecode($_GET['phone']);
$address = urldecode($_GET['adress']);
$type = urldecode($_GET['type']);
$section = urldecode($_GET['section']);
$UpdateUser = function () use ($conn, $userId, $username, $name, $email, $phone, $address, $type,$section,$findSectionId) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sectionId = $findSectionId($section);
    if($sectionId!="-----------------"){
        $sql = "UPDATE users SET user_name='$username', name='$name', email='$email', phone='$phone', adress='$address', type='$type', section_id='$sectionId' WHERE ID=$userId;";

    }else{
        $sql = "UPDATE users SET user_name='$username', name='$name', email='$email', phone='$phone', adress='$address', type='$type',section_id=NULL WHERE ID=$userId;";

    }

    if ($conn->query($sql) === TRUE) {
        header("Location:adminPage.php?update=true");

    } else {

        header("Location:adminPage.php?update=false");
    }
};
$UpdateUser();



