<?php
include "DBConnection.php";
include "./vendor/phpmailer/phpmailer/src/PHPMailer.php";
include "./vendor/phpmailer/phpmailer/src/SMTP.php";
include "./vendor/phpmailer/phpmailer/src/Exception.php";

session_start();
global $conn;
$reason = isset($_POST['reason']) ? $_POST['reason'] : '';
$cnp = isset($_POST['cnp']) ? $_POST['cnp'] : '';
$birth_date = isset($_POST['birth_date']) ? $_POST['birth_date'] : '';
echo "bemeno id parameter ".$_POST['reservation_id'];
$checkReservation=function () use ($conn) {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT ID  FROM dates WHERE ID='{$_POST['reservation_id']}' AND reserved=1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "fuggveny amit visszaad".$row['ID'];

        }
        return true;
    }
    else{return false;}



    return $doctors;

};

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if($checkReservation()==true){

    header("Location:userPage.php?newReservation=false");
}
else{
    $sql = "UPDATE dates SET reason='$reason', cnp='$cnp', birth_date='$birth_date', reserved=1, email='{$_SESSION['user']['Email']}',patient_id='{$_SESSION['user']['ID']}', phone='{$_SESSION['user']['Phone']}' WHERE ID='{$_POST['reservation_id']}'";
    $result = $conn->query($sql);
    if ($result) {
        /*

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bcsbaricz033@gmail.com'; // A küldő email címe
        $mail->Password = ''; // A Gmail jelszava
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;


        $mail->setFrom('YourSenderEmail', 'Your Name');
        $mail->addAddress($_SESSION['user']['Email']);

        $mail->isHTML(true);
        $mail->Subject = 'Foglalás visszaigazolása';
        $mail->Body = 'Kedves Felhasználó, a foglalását visszaigazoltuk.';

        if (!$mail->send()) {
            echo 'Hiba történt az e-mail küldése közben.';
        }*/
        header("Location:userPage.php?newReservation=true");
    } else {
        echo 'Hiba történt a foglalás közben.';
        header("Location:userPage.php?newReservation=false");
    }
}


