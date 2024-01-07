<?php
include "DBConnection.php";
include "Date.php";
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
$getDates=function ($doctorId,$startDate,$endDate,$showOnlyReserved) use($conn){
    $dates=[];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


            $sql = "SELECT
                        dates.ID,
                        doctors.name AS doctor_name,
                        patients.name AS patient_name,
                        dates.start_date,
                        dates.end_date,
                        dates.reason,
                        dates.reserved,
                        dates.cnp,
                        dates.birth_date,
                        dates.email,
                        dates.doctor_id,
                        dates.phone
                FROM dates
                INNER JOIN users AS doctors ON doctors.ID = dates.doctor_id
                LEFT JOIN users AS patients ON patients.ID = dates.patient_id 
                WHERE dates.doctor_id = '$doctorId' AND dates.start_date >= '$startDate' AND dates.start_date >= NOW() AND dates.end_date <= '$endDate' AND dates.reserved = 0";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $date = new Date($row["doctor_name"],$row["patient_name"],$row["start_date"],$row["end_date"],$row["reserved"],$row["reason"],$row["cnp"],$row["birth_date"],$row["email"],$row["phone"]);
                $date->setDoctorId($row["doctor_id"]);
                $date->setID($row["ID"]);
                array_push($dates, $date);


            }
        }

    return $dates;

};
$getOwnDates=function () use($conn){
    $dates=[];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT doctors.name AS doctor_name,
                        patients.name AS patient_name,
                        dates.start_date,
                        dates.end_date,
                        dates.reason,
                        dates.reserved,
                        dates.cnp,
                        dates.birth_date,
                        dates.email,
                        dates.phone,
                        dates.doctor_id
                FROM dates
                INNER JOIN users AS doctors ON doctors.ID = dates.doctor_id
                LEFT JOIN users AS patients ON patients.ID = dates.patient_id 
                WHERE  dates.reserved = 1 AND dates.patient_id=".$_SESSION['user']['ID']." ORDER BY dates.start_date;";


    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $date = new Date($row["doctor_name"],$row["patient_name"],$row["start_date"],$row["end_date"],$row["reserved"],$row["reason"],$row["cnp"],$row["birth_date"],$row["email"],$row["phone"]);
            //$date->setDoctorId($row["doctor_id"]);
            array_push($dates, $date);


        }
    }

    return $dates;

};

session_start();
if(!isset($_SESSION['user'])){
    header("Location:login.php");
    exit();
}
if (isset($_GET['newReservation'])) {
    if($_GET['newReservation']=="true"){
        echo '<script>alert("Date reserved successfully");</script>';
        echo '<script>window.location.href = "userPage.php";</script>';
    }else{
        echo '<script>alert("Error while reserving date or date is already reserved user ");</script>';
        echo '<script>window.location.href = "userPage.php";</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MCenter</title>
    <style>
        .submenu {
            display: none;
        }
    </style>
    <script>
        function toggleMenu(menuId) {
            var ownMenu = document.getElementById("ownDatesMenu");
            var datesMenu = document.getElementById("newDatesMenu");

            document.getElementById(menuId).style.display = (document.getElementById(menuId).style.display === 'block' || document.getElementById(menuId).style.display === '') ? 'none' : 'block';


            if (document.getElementById(menuId).style.display === 'block') {
                if (menuId === 'ownDatesMenu') {
                    datesMenu.style.display = 'none';
                } else if (menuId === 'newDatesMenu') {
                    ownMenu.style.display = 'none';
                }
            }
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
</head>
<body>

<?php
$user = $_SESSION['user'];
echo "<h1>Üdvözöljük " . $user["UserName"] . "</h1>";
?>
    <ul>
        <li><a href="javascript:void(0);" onclick="toggleMenu('ownDatesMenu')">Saját időpontjaim</a></li>
        <li><a href="javascript:void(0);" onclick="toggleMenu('newDatesMenu')">Időpontfoglalás</a></li>
    </ul>


<script>
    $(document).ready(function(){
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });

    });
</script>


<div id="ownDatesMenu" class="submenu">
    <div><?php

                $datesForRiport=$getOwnDates();

                echo '<table border="1">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Doctor</th>';
                echo '<th>Start Date</th>';
                echo '<th>End Date</th>';
                echo '<th>Reason</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($datesForRiport as $date) {
                    echo '<tr>';
                    echo '<td>' . $date->getDoctor() . '</td>';
                    echo '<td>' . $date->getStartDate() . '</td>';
                    echo '<td>' . $date->getEndDate() . '</td>';
                    echo '<td>' . $date->getReason() . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
        ?>
    </div>

</div>

<div id="newDatesMenu" class="submenu">
    <form method="post">
        <label for="user">Doctor:</label>
        <select class="" name="doctors" id="doctors">
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
        <button type="submit" name="sendFilter">Select</button>
    </form>

    <div>
        <?php
        if(isset($_POST['sendFilter'])){
            if(!isset($_POST['doctors'])){
                $error="Doctor is not selected";
            }
            else{
                    $datesForRiport=$getDates($_POST['doctors'],$_POST['startDate'],$_POST['endDate'],true);

                echo '<table border="1">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Doctor</th>';
                echo '<th>Start Date</th>';
                echo '<th>End Date</th>';
                echo '<th>Reason</th>';
                echo '<th>CNP</th>';
                echo '<th>Birth Date</th>';
                echo '<th>Reserve</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($datesForRiport as $date) {
                    echo '<tr>';
                    echo '<form action="createReservation.php" method="post">';
                    echo '<input type="hidden" name="reservation_id" value="' . $date->getID() . '" >';
                    echo '<td>' . $date->getDoctor() . '</td>';
                    echo '<td>' . $date->getStartDate() . '</td>';
                    echo '<td>' . $date->getEndDate() . '</td>';
                    echo '<td><input type="text" value="' . $date->getReason() . '"></td>';
                    echo '<td><input type="text" value="' . $date->getCNP() . '"></td>';
                    echo '<td><input type="date" value="' . $date->getBirthDate() . '" required></td>';
                    echo '<td><input type="submit" name="submit" value="Reserve"></></td>';
                    echo '</form>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';


            }
        }
        ?>
    </div>
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
