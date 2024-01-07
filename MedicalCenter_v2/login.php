<?php
session_start(); // Start the session

include "DBConnection.php";
global $conn;

$checkUser = function ($pUserName, $pPassword) use ($conn) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT users.ID,users.user_name,users.name,users.password,users.email,users.phone,users.adress,users.type,sections.Name AS section_name FROM users LEFT JOIN sections ON users.section_id=sections.ID WHERE  is_active=1 AND users.user_name LIKE '$pUserName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pPassword, $row["password"]) == true) {
            $_SESSION['user'] = [
                    "ID"=>$row["ID"],
                    "Name"=>$row["name"],
                    "UserName"=>$row["user_name"],
                    "Email"=>$row["email"],
                    "Phone"=>$row["phone"],
                    "Type"=>$row["type"],

                    "Section"=>$row["section_name"]



            ];
            return true;
        } else {
            //var_dump(password_verify($pPassword, $row["password"]));
            return false;
        }
    } else {
        return false;
    }
    $conn->close();
};

if (isset($_POST['login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($checkUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password'])) != false) {
            $user=$_SESSION['user'];
            if($user['Type']=="user"){
                header('Location: userPage.php');
            }
            if($user['Type']=="doctor"){
                header('Location: doctorPage.php');
            }
            if($user['Type']=="admin"){
                header('Location: adminPage.php');
            }


        } else {
            $error="Invalid username or password";

        }
    }
}

if (isset($_SESSION['user'])) {
    $user=$_SESSION['user'];
    if($user['Type']=="user"){
        header('Location: userPage.php');
    }
    if($user['Type']=="doctor"){
        header('Location: doctorPage.php');
    }
    if($user['Type']=="admin"){
        header('Location: adminPage.php');
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

    <form method="post">
        <img class="logo" src="logo.jpg" alt="logo">
        <h1>Login</h1>
        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; }?>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"  required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" name="login"  id="loginButton" value="Log In">
    </form>
    <p>Don't have an account? <a href="registration.php">Register</a></p>
</div>
</body>
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
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
