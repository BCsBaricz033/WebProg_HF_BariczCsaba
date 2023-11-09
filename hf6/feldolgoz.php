<?php
$fName=$lName=$email=$tShirt=$fileName=$fileSize=$fileType=$terms='';
$attends=[];
if(isset($_POST['submit'])){
    if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email'])) {
        $nameError = "Név és email cím megadása kötelező!";
    }else{
        $fName=$_POST['firstName'];
        $lName=$_POST['lastName'];
        $email=$_POST['email'];

    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailError = "Érvénytelen email cím formátum!";
    }
    else{
        $email=$_POST['email'];
    }
    if (!isset($_POST['attend'])){
        $attendError = "Nincs kiválasztva esemény!";
    }
    else{
        $attends=$_POST['attend'];
    }

    if(isset($_FILES['abstract']) && $_FILES['abstract']['error'] == 0) {
        $allowedExtensions = ['pdf'];
        $maxFileSize = 3 * 1024 * 1024; // 3MB
        $fileExtension = strtolower(pathinfo($_FILES['abstract']['name'], PATHINFO_EXTENSION));
        if(!in_array($fileExtension, $allowedExtensions)) {
            $typeError = "Csak PDF fájlokat fogadunk el.";
        }
        elseif($_FILES['abstract']['size'] > $maxFileSize) {
            $sizeError = "A fájl mérete nem lehet nagyobb, mint 3MB.";
        }

    } elseif(!isset($_FILES['abstract']) || $_FILES['abstract']['error'] > 0) {
        $fileError = "Kérjük, válasszon ki egy fájlt az abstract feltöltéséhez.";
    }
    if (!isset($_POST['terms'])){
        $termError="Felhasználási feltételek elfogadása kötelező!";
    }
}
?>
<?php
if(!isset($nameError) && !isset($attendError) && !isset($typeError) &&!isset($sizeErrorError) && !isset($fileError) && !isset($termError)){
    echo "Name: ".$fName." ".$lName." Email: ".$email."<br>";
    foreach ($attends as $attend){
        echo $attend."<br>";
    }
    if(isset($_POST['tshirt'])){
        echo "T-shirt size ".$_POST['tshirt']."<br>";
    }
    echo "File:".$_FILES['abstract']['name']."<br>";

}?>
