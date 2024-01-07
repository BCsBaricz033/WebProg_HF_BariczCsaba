<?php
include "Doctor.php";
include "DBConnection.php";
global $conn;
if(!isset($_GET['doctors'])){
    header("Location:adminPageAddDates.php?error=notDoctorSelected");
}
$findSectionId=function ($doctorId)use ($conn){

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT section_id FROM users WHERE ID='$doctorId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id=$row['section_id'];
            return $id;
        }
    }
};
$checkDateExists=function ($doctorId, $appointmentStart) use($conn){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT Id FROM dates WHERE doctor_id='$doctorId' AND start_date='$appointmentStart'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
       return true;
    }
    else{
        return false;
    }
};
$insertAppointmentToDatabase=function($doctorId, $appointmentStart, $appointmentEnd)use ($conn,$findSectionId,$checkDateExists){
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sectionId = $findSectionId($doctorId);
    if(!$checkDateExists($doctorId, $appointmentStart)){
        $sql = "INSERT INTO dates(doctor_id,start_date,end_date,section_id) VALUEs ('$doctorId','$appointmentStart','$appointmentEnd','$sectionId')";
        $conn->query($sql);
    }
};

 $insertAppointments=function($doctorId, $startDate, $startTime, $endTime, $duration) use($insertAppointmentToDatabase) {

     $currentDateTime = new DateTime("$startDate $startTime");
     $endTimeObj = new DateTime("$startDate $endTime");

     while ($currentDateTime < $endTimeObj) {
         $formattedDateTime = $currentDateTime->format('Y-m-d H:i');
         $endDateTime = $currentDateTime->modify("+$duration minutes")->format('Y-m-d H:i');

         $insertAppointmentToDatabase($doctorId, $formattedDateTime, $endDateTime);
     }

 };

$doctors = $_GET['doctors'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$startTime = $_GET['startTime'];
$endTime = $_GET['endTime'];
$duration = $_GET['duration'];

$startDateObj = new DateTime($startDate);
$endDateObj = new DateTime($endDate);

while ($startDateObj <= $endDateObj) {
    foreach ($doctors as $doctorId) {
        $insertAppointments($doctorId, $startDateObj->format('Y-m-d'), $startTime, $endTime, $duration);
    }
    $startDateObj->modify('+1 day');
}
header("Location:adminPageAddDates.php?inserted=true");
exit();

?>