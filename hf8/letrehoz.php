<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Új Hallgató Hozzáadása</title>

    <style>
        form {
            max-width: 400px;
            margin: 20px auto;
        }

        label, input {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
include "connection.php";
global $conn;

if ($conn->connect_error) {
    die("Sikertelen csatlakozás: " . $conn->connect_error);
}

$id = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nev = htmlspecialchars($_POST["nev"]);
    $szak = htmlspecialchars($_POST["szak"]);

    if (isset($_GET["id"])) {

        $id = $_GET["id"];

        $sql = "UPDATE hallgatok SET nev=?, szak=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nev, $szak, $id);

        $result = $stmt->execute();

        if ($result) {
            echo '<script type="text/javascript">alert("Hallgató frissítve")</script>';
        } else {
            echo '<script type="text/javascript">alert("Hiba történt a frissítés során")</script>';
        }

        $stmt->close();
    } else {

        $sql = "INSERT INTO hallgatok (nev, szak) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nev, $szak);

        $result = $stmt->execute();

        if ($result) {
            echo '<script type="text/javascript">alert("Hallgató hozzáadva")</script>';
        } else {
            echo '<script type="text/javascript">alert("Hiba történt a hallgató hozzáadása során")</script>';
        }

        $stmt->close();
    }
}


if (isset($_GET["id"])) {
    $id = $_GET["id"];


    $sql_select = "SELECT * FROM hallgatok WHERE id=?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows > 0) {

        $row = $result_select->fetch_assoc();
        $nev_value = $row["nev"];
        $szak_value = $row["szak"];
    }

    $stmt_select->close();
}

$conn->close();
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?><?php echo isset($id) ? "?id=" . $id : ''; ?>">
    <label for="nev">Név:</label>
    <input type="text" name="nev" value="<?php echo isset($nev_value) ? htmlspecialchars($nev_value) : ''; ?>" required>

    <label for="szak">Szak:</label>
    <input type="text" name="szak" value="<?php echo isset($szak_value) ? htmlspecialchars($szak_value) : ''; ?>" required>

    <button type="submit">Mentés</button>
    <label><a href="listazas.php">Vissza a listázáshoz</a></label>
</form>

</body>
</html>
