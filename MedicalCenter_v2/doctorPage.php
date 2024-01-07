<?php
include "DBConnection.php";
include "Date.php";
global $conn;
session_start();
if(!isset($_SESSION['user']) ||$_SESSION['user']['Type']!='doctor' ){
    header("Location:login.php");
    exit();
}
$getDates=function ($doctorId,$startDate,$endDate,$showOnlyReserved) use($conn){

    $dates=[];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

        if($showOnlyReserved==true){

            $sql = "SELECT doctors.name AS doctor_name,
                        patients.name AS patient_name,
                        dates.start_date,
                        dates.end_date,
                        dates.reason,
                        dates.reserved,
                        dates.cnp,
                        dates.birth_date,
                        dates.email,
                        dates.phone
                FROM dates
                INNER JOIN users AS doctors ON doctors.ID = dates.doctor_id
                LEFT JOIN users AS patients ON patients.ID = dates.patient_id 
                WHERE dates.doctor_id = '$doctorId' AND dates.start_date >= '$startDate' AND dates.end_date <= '$endDate' AND dates.reserved = '$showOnlyReserved'";
        }
        else{
            $sql = "SELECT 
                        doctors.name AS doctor_name,
                        patients.name AS patient_name,
                        dates.start_date,
                        dates.end_date,
                        dates.reason,
                        dates.reserved,
                        dates.cnp,
                        dates.birth_date,
                        dates.email,
                        dates.phone
                FROM dates
                INNER JOIN users AS doctors ON doctors.ID = dates.doctor_id
                LEFT JOIN users AS patients ON patients.ID = dates.patient_id 
                WHERE dates.doctor_id = '$doctorId' AND dates.start_date >= '$startDate' AND dates.end_date <= '$endDate';";
        }

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $date = new Date($row["doctor_name"],$row["patient_name"],$row["start_date"],$row["end_date"],$row["reserved"],$row["reason"],$row["cnp"],$row["birth_date"],$row["email"],$row["phone"]);
                array_push($dates, $date);


            }
        }

    return $dates;

};
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
<form method="post">
    <label for="startDate">Start Date:</label>
    <input type="date" id="startDate" name="startDate" required>
    <br>
    <label for="endDate">End Date:</label>
    <input type="date" id="endDate" name="endDate" required>
    <br>
    <label for="reserved">Show only reserved</label>
    <input type="checkbox" id="reserved" name="reserved">
    <br>
    <button type="submit" name="sendFilter">Select</button>
</form>

<div><?php

    if(isset($_POST['sendFilter'])){


            if (isset($_POST['reserved'])){
                $datesForRiport=$getDates($_SESSION['user']['ID'],$_POST['startDate'],$_POST['endDate'],true);
            }
            else{
                $datesForRiport=$getDates($_SESSION['user']['ID'],$_POST['startDate'],$_POST['endDate'],false);
            }
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Patient</th>';
            echo '<th>Start Date</th>';
            echo '<th>End Date</th>';
            echo '<th>Reason</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($datesForRiport as $date) {
                echo '<tr>';
                echo '<td>' . $date->getPatient() . '</td>';
                echo '<td>' . $date->getStartDate() . '</td>';
                echo '<td>' . $date->getEndDate() . '</td>';
                echo '<td>' . $date->getReason() . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
    }
    ?></div>

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
