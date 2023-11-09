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
<h3>Online conference registration</h3>
<?php if (isset($nameError)) { echo "<p style='color: red;'>$nameError</p>"; }
elseif (isset($emailError)) { echo "<p style='color: red;'>$emailError</p>"; }
elseif (isset($attendError)) { echo "<p style='color: red;'>$attendError</p>"; }
elseif (isset($typeError)) { echo "<p style='color: red;'>$typeError</p>"; }
elseif (isset($sizeErrorError)) { echo "<p style='color: red;'>$sizeError</p>"; }
elseif (isset($fileError)) { echo "<p style='color: red;'>$fileError</p>"; }
elseif (isset($termError)) { echo "<p style='color: red;'>$termError</p>"; }
        ?>
<form method="post" action=""> <!-- második megoddásként action="feldolgoz.php" -->
    <label for="fname"> First name:
        <input type="text" name="firstName" value="<?php echo $fName?>">
    </label>
    <br><br>
    <label for="lname"> Last name:
        <input type="text" name="lastName" value="<?php echo $lName ?>">
    </label>
    <br><br>
    <label for="email"> E-mail:
        <input type="text" name="email" value="<?php echo $email ?>"">
    </label>
    <br><br>
    <label for="attend"> I will attend:<br>
        <input type="checkbox" name="attend[]" value="Event1">Event 1<br>
        <input type="checkbox" name="attend[]" value="Event2">Event2<br>
        <input type="checkbox" name="attend[]" value="Event3">Event3<br>
        <input type="checkbox" name="attend[]" value="Event4">Event3<br>
    </label>
    <br><br>
    <label for="tshirt"> What's your T-Shirt size?<br>
        <select name="tshirt">
            <option value="P">Please select</option>
            <option value="S">S</option>
            <option value="M" selected disabled>M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select>
    </label>
    <br><br>
    <label for="abstract"> Upload your abstract<br>
        <input type="file" name="abstract"/>
    </label>
    <br><br>
    <input type="checkbox" name="terms" value="">I agree to terms & conditions.<br>
    <br><br>
    <input type="submit" name="submit" value="Send registration"/>
</form>
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


