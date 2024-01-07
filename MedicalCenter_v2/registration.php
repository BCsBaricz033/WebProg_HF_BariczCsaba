<?php

include "DBConnection.php";
global $conn;
$checkUser = function ($pUserName)use($conn)  {

    $sql = "SELECT ID FROM users WHERE user_name = '$pUserName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        return true;
    } else {

        return false;
    }
};
$insertUser=function ($name,$email,$phone,$adress,$userName,$pPassword) use($conn) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO users (name, email, phone, adress, user_name, password) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', '" . $adress . "', '" . $userName . "', '" . $pPassword . "')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    }else{
        return false;
    }


};
if (isset($_POST['signUp'])) {
    if (isset($_POST['rUsername']) && isset($_POST['rPassword']) && isset($_POST['rConfirmPassword'])) {

        if(strlen($_POST['rUsername'])>25){
            $error = "Too long username";
        }
    else
        if ($checkUser(htmlspecialchars($_POST['rUsername'])) != false) {
            $error = "Username already exists";
        } else if ($_POST['rPassword'] != $_POST['rConfirmPassword']) {
            $error = "Password confirmation is invalid!";
        } else {
            $insertUser(htmlspecialchars($_POST['rName']),htmlspecialchars($_POST['rEmail']),htmlspecialchars($_POST['rPhone']),htmlspecialchars($_POST['rAdress']),htmlspecialchars($_POST['rUsername']), htmlspecialchars(password_hash($_POST['rPassword'], PASSWORD_DEFAULT)));
            header("Location:login.php");
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
<div id="main-div">


    <form method="post">
        <img class="logo" src="logo.jpg" alt="logo">
        <h1>Registration</h1>
        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; }?>
        <label for="name">Name:</label>
        <input type="text" name="rName" id="name"  required><br><br>
        <label for="username">Username:</label>
        <input type="text" name="rUsername" id="username"  required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="rEmail" id="email"  required><br><br>
        <label for="phone">Phone:</label>
        <input type="text" name="rPhone" id="phone"  required><br><br>
        <label for="adress">Adress:</label>
        <input type="text" name="rAdress" id="adress"  required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="rPassword" id="password" required><br><br>
        <label for="password">Confirm Password:</label>
        <input type="password" name="rConfirmPassword" id="rPassword" required><br><br>
        <input type="submit" name="signUp"  id="signUp" value="Sign Up">
    </form>
    <p>Dou you  have an account? <a href="login.php">Login</a></p>
</div>
</body>
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }



    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 12px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }


    .logo{
        width: 201px;
        height: 179px;

    }

</style>
</html>

