<?php
include "DBConnection.php";
include "Doctor.php";
global $conn;
$getDoctors=function () use ($conn) {
    $doctors=array();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT ID,name,section_id  FROM users WHERE type LIKE 'doctor' AND  is_active=1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $doctor = new Doctor($row['ID'],$row['name'],$row['section_id']);
            array_push($doctors, $doctor);
        }
    }



    return $doctors;

};


session_start();
if(!isset($_SESSION['user']) ||$_SESSION['user']['Type']!='admin' ){
    header("Location:login.php");
    exit();
}
if (isset($_GET['inserted'])) {
    if($_GET['inserted']=="true"){
        echo '<script>alert("Dates inserted successfully");</script>';
        echo '<script>window.location.href = "adminPageAddDates.php";</script>';
    }else{
        echo '<script>alert("Error updating user ");</script>';
        echo '<script>window.location.href = "adminPage.php";</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MCenter</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
</head>
<body>
<?php
$user = $_SESSION['user'];
echo "<h1>Welcome " . $user["UserName"] . "</h1>";
?>
<ul>
    <li> <a href="adminPage.php">Users</a></li>
    <li><a href="#">New  Dates</a></li>
    <li><a href="adminRiportsPage.php">Reports</a></li>
</ul>
<script>
    $(document).ready(function(){
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });

    });
</script>
<form action="addNewDates.php" method="get">

    <?php if (isset($_GET['error']))
    {
        echo "<p style='color: red;'>Doctor isn't selected</p>";
        //echo '<script>window.location.href = "adminPageAddDates.php";</script>';

    } ?>
    <label for="doctors">Doctor:</label>
    <select data-placeholder="Select doctors..." multiple class="chosen-select" name="doctors[]" id="doctors">
        <option value=""></option>
        <?php foreach ($getDoctors() as $doctor): ?>
            <option value="<?= $doctor->getID() ?>">
                <?= $doctor->getName() ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="startDate">Start Date:</label>
    <input type="date" id="startDate" name="startDate" required>
    <br>
    <label for="endDate">End Date:</label>
    <input type="date" id="endDate" name="endDate" required>
    <br>

    <label for="startTime">Start Time:</label>
    <input type="time" id="startTime" name="startTime" required>

    <br>

    <label for="endTime">End Time:</label>
    <input type="time" id="endTime" name="endTime" required>

    <br>

    <label for="duration">Duration in minutes:</label>
    <input type="number" id="duration" name="duration" min="10" max="240" step="5" required>

    <br>

    <button type="submit">Add dates</button>
</form>
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

