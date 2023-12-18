<?php
include "connection.php";
global $conn;

if ($conn->connect_error) {
    die("Sikertelen csatlakozás: " . $conn->connect_error);
}


if (isset($_GET["id"])) {
    $id = $_GET["id"];


    $sql = "DELETE FROM hallgatok WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $result = $stmt->execute();


    if ($result) {
        echo '<script type="text/javascript">alert("Hallgató sikeresen törölve")</script>';
    } else {
        echo '<script type="text/javascript">alert("Hiba történt a törlés során")</script>';
    }

    $stmt->close();
}

$conn->close();


header("Location: listazas.php");
exit();
?>

