<?php
include "DBConnection.php";
include "User.php";
global $conn;
session_start();
if(!isset($_SESSION['user']) ||$_SESSION['user']['Type']!='admin' ){
    header("Location:login.php");
    exit();
}
$getSections=function () use ($conn) {
    $sections=array();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT Name FROM sections";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            array_push($sections, $row["Name"]);
        }
    }

    return $sections;
};
$getUsers=function () use ($conn) {
    $users=array();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "";
    if (isset($_POST['search']) && $_POST['search'] !== "") {
        $searchTerm = $_POST['search'];
        $sql = "SELECT users.ID,users.user_name,users.name,users.email,users.phone,users.adress,users.type,sections.Name AS section_name FROM users INNER JOIN sections ON users.section_id=sections.ID  WHERE Name LIKE '%$searchTerm%' AND is_active=1 ORDER BY users.name";
    } else {
        $sql = "SELECT users.ID,users.user_name,users.name,users.email,users.phone,users.adress,users.type,sections.Name AS section_name FROM users LEFT JOIN sections ON users.section_id=sections.ID WHERE  is_active=1 ORDER BY users.name";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = new User($row["ID"],$row["user_name"],$row["name"],$row["email"],$row["phone"],$row["adress"],$row["type"],$row["section_name"]);
            array_push($users, $user);
        }
    }

    return $users;
};


if (isset($_GET['update'])) {
    if($_GET['update']=="true"){
        echo '<script>alert("User updated successfully");</script>';
        echo '<script>window.location.href = "adminPage.php";</script>';
    }else{
        echo '<script>alert("Error updating user ");</script>';
        echo '<script>window.location.href = "adminPage.php";</script>';
    }
}
if (isset($_GET['delete'])) {
    if($_GET['delete']=="true"){
        echo '<script>alert("User deleted successfully");</script>';
        echo '<script>window.location.href = "adminPage.php";</script>';
    }else{
        echo '<script>alert("Error deleting user ");</script>';
        echo '<script>window.location.href = "adminPage.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MCenter</title>
</head>
<body>

<?php
$user = $_SESSION['user'];
echo "<h1>Welcome " . $user["UserName"] . "</h1>";
?>
<ul>
    <li> <a href="#">Users</a></li>
    <li><a href="adminPageAddDates.php">New Dates</a></li>
    <li><a href="adminRiportsPage.php">Reports</a></li>
</ul>





<div id="usersMenu">
    <table>
        <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Type</th>
            <th>Section</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($getUsers() as $user): ?>
            <tr>
                <form action="saveUserChanges.php" method="GET">
                    <input type="hidden" name="userid" value="<?= $user->getId(); ?>">
                    <td><input type="text" name="username" value="<?= $user->getUserName(); ?>"></td>
                    <td><input type="text" name="name" value="<?= $user->getName(); ?>"></td>
                    <td><input type="text" name="email" value="<?= $user->getEmail(); ?>"></td>
                    <td><input type="text" name="phone" value="<?= $user->getPhone(); ?>"></td>
                    <td><input type="text" name="adress" value="<?= $user->getAdress(); ?>"></td>
                    <td>
                        <select name="type">
                            <option value="user" <?= ($user->getType() == 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="doctor" <?= ($user->getType() == 'doctor') ? 'selected' : ''; ?>>Doctor</option>
                            <option value="admin" <?= ($user->getType() == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </td>
                    <td>
                        <select name="section">
                            <option value=""></option>
                            <?php foreach ($getSections() as $section): ?>
                                <option value="<?= $section ?>" <?= ($user->getSectionID() == $section) ? 'selected' : ''; ?>>
                                    <?= $section ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>

                        <input type="submit" class="saveIcon" value="Save">
                        <a href="deleteUser.php?userId=<?= $user->getId(); ?>">Delete</a>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<a href="logout.php">Logout</a>
</body>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover {
        background-color: #555;
    }

    .submenu {
        display: none;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input, select, button {
        margin-bottom: 10px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    a {
        display: block;
        margin-top: 20px;
        color: #333;
        text-align: center;
        text-decoration: none;
    }

</style>
</html>
