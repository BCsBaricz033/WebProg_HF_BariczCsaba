<?php
include "connection.php";
global $conn;
$checkUser = function ($pUserName, $pPassword) use ($conn) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pUserName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["password"] == $pPassword) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
};

if (isset($_POST['login'])) {
    if ($_POST['username'] == "" || $_POST['password'] == "") {
        $error = "A mező nem lehet üres";
    } else {
        if ($checkUser($_POST['username'], $_POST['password'])) {
            header("Location: listazas.php");
            exit();
        } else {
            $error = "Érvénytelen felhasználónév vagy jelszó";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<div id="main-div">

    <?php if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    } ?>
    <form method="post">
        <h1>Login</h1>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" name="login" id="loginButton" value="Log In">
    </form>

</div>
</body>
</html>
