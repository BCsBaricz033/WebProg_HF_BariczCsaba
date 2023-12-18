<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallgatók Lista</title>
    <a href="letrehoz.php">Hallgató hozzáadása</a>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
</body>
</html>

<?php
include "connection.php";

global $conn;

if ($conn->connect_error) {
    die("Sikertelen csatlakozás: " . $conn->connect_error);
}


$sql = "SELECT * FROM hallgatok";
$result = $conn->query($sql);


if ($result->num_rows > 0) {

    echo "<table><tr><th>ID</th><th>Név</th><th>Szak</th><th>Átlag</th><th colspan='2' style='text-align: center'>Actions</th></tr>";


    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["id"]) . "</td><td>" . htmlspecialchars($row["nev"]) . "</td><td>" . htmlspecialchars($row["szak"]) . "</td><td>" . htmlspecialchars($row["atlag"]) . "</td><td><a href='letrehoz.php?id=" . htmlspecialchars($row["id"]) . "'>Update</a></td><td><a href='delete.php?id=" . htmlspecialchars($row["id"]) . "'>Delete</a></td></tr>";
    }


    echo "</table>";
} else {
    echo "Nincsenek eredmények a hallgatók táblában.";
}


$conn->close();
?>



