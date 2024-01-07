<?php
include "DBConnection.php";
include "Doctor.php";
include "Date.php";
include "./vendor/autoload.php";
use TCPDF\TCPDF;
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
$getDates=function ($doctorIds,$startDate,$endDate,$showOnlyReserved) use($conn){
    $dates=[];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    foreach ($doctorIds as $doctorId){
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
    }
    return $dates;

};

session_start();
if(!isset($_SESSION['user']) ||$_SESSION['user']['Type']!='admin' ){
    header("Location:login.php");
    exit();
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
<ul id="menu">
    <li> <a href="adminPage.php">Users</a></li>
    <li><a href="adminPageAddDates.php">New  Dates</a></li>
    <li><a href="">Reports</a></li>
</ul>
<script>
    $(document).ready(function(){
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });

    });
</script>
<form method="post">
    <?php if (isset($error))
    {
        echo "<p style='color: red;'>Doctor isn't selected</p>";
        //echo '<script>window.location.href = "adminPageAddDates.php";</script>';

    } ?>
    <label for="user">Doctor:</label>
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
    <label for="reserved">Show only reserved</label>
    <input type="checkbox" id="reserved" name="reserved">
    <br>
    <button type="submit" name="sendFilter">Select</button>
    <!--
    <button type="submit" name="downloadPdf">Download PDF</button>
    -->
</form>

<div><?php

    if(isset($_POST['sendFilter'])){
        if(!isset($_POST['doctors'])){
            $error="Doctor is not selected";
        }
        else{
            if (isset($_POST['reserved'])){
                $datesForRiport=$getDates($_POST['doctors'],$_POST['startDate'],$_POST['endDate'],true);
            }
            else{
                $datesForRiport=$getDates($_POST['doctors'],$_POST['startDate'],$_POST['endDate'],false);
            }
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Doctor</th>';
            echo '<th>Patient</th>';
            echo '<th>Start Date</th>';
            echo '<th>End Date</th>';
            echo '<th>Reason</th>';
            echo '<th>CNP</th>';
            echo '<th>Birth Date</th>';
            echo '<th>Email</th>';
            echo '<th>Phone</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($datesForRiport as $date) {
                echo '<tr>';
                echo '<td>' . $date->getDoctor() . '</td>';
                echo '<td>' . $date->getPatient() . '</td>';
                echo '<td>' . $date->getStartDate() . '</td>';
                echo '<td>' . $date->getEndDate() . '</td>';
                echo '<td>' . $date->getReason() . '</td>';
                echo '<td>' . $date->getCNP() . '</td>';
                echo '<td>' . $date->getBirthDate() . '</td>';
                echo '<td>' . $date->getEmail() . '</td>';
                echo '<td>' . $date->getPhone() . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';


        }


    }



    /*
    if (isset($_POST['downloadPdf'])) {
        // Adatok generálása vagy lekérdezése

        // TCPDF példány létrehozása

        $pdf = new TCPDF();
        $pdf->AddPage();

        // Táblázat feltöltése adatokkal
        $html = '<table border="1">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reserved</th>
                    <th>Reason</th>
                    <th>CNP</th>
                    <th>Birth Date</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($datesForRiport as $date) {
            $html .= '<tr>
                <td>' . $date->getDoctor() . '</td>
                <td>' . $date->getPatient() . '</td>
                <td>' . $date->getStartDate() . '</td>
                <td>' . $date->getEndDate() . '</td>
                <td>' . $date->getReserved() . '</td>
                <td>' . $date->getReason() . '</td>
                <td>' . $date->getCNP() . '</td>
                <td>' . $date->getBirthDate() . '</td>
                <td>' . $date->getEmail() . '</td>
                <td>' . $date->getPhone() . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        // TCPDF-nek átadás és kimenet generálása
        $pdf->writeHTML($html);
        $pdf->Output('report' . $_POST['startDate'] . '-' . $_POST['endDate'] . '.pdf', 'D');
        // D opció: letöltés, I opció: megjelenítés
        exit();
    }
    */


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
    #menu li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    #menu li a:hover {
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
    button:hover {
        background-color: #45a049;
        cursor: pointer;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }

    input, button {
        margin-bottom: 10px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        cursor: pointer;
    }
</style>
</html>


