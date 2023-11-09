<?php

$name = $email = $password = $confirmPassword = $birthdate = $gender = $interests = $country = "";
$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $errors[] = "A név mező nem lehet üres";
    } else {
        $name = test_input($_POST["name"]);
    }

    
    if (empty($_POST["email"])) {
        $errors[] = "Az e-mail cím mező nem lehet üres";
    } else {
        $email = test_input($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Érvénytelen e-mail formátum";
        }
    }


    if (empty($_POST["password"]) || empty($_POST["confirmPassword"])) {
        $errors[] = "A jelszó és a jelszó megerősítése mezők nem lehetnek üresek";
    } else {
        $password = test_input($_POST["password"]);
        $confirmPassword = test_input($_POST["confirmPassword"]);

        if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[!@#\$%\^&\*\(\)_\+\-=\[\]\{\};:'\"<>,\.\?\/\\|`~]/", $password)) {
            $errors[] = "A jelszó nem felel meg a követelményeknek";
        } else {

            if ($password != $confirmPassword) {
                $errors[] = "A jelszó és a jelszó megerősítése nem egyezik meg";
            }
        }
    }


    if (empty($_POST["birthdate"])) {
        $errors[] = "A születési dátum mező nem lehet üres";
    } else {
        $birthdate = test_input($_POST["birthdate"]);

        if (!strtotime($birthdate)) {
            $errors[] = "Érvénytelen dátum formátum";
        }
    }


    if (empty($_POST["gender"])) {
        $errors[] = "A nem mezőt ki kell választani";
    } else {
        $gender = test_input($_POST["gender"]);
    }


    if (!empty($_POST["interests"])) {
        $interests = implode(", ", $_POST["interests"]);
    }


    if (!empty($_POST["country"])) {
        $country = test_input($_POST["country"]);
    }


    if (empty($errors)) {
        echo "Sikeres regisztráció!<br>";
        echo "Név: " . $name . "<br>";
        echo "E-mail: " . $email . "<br>";
        echo "Születési dátum: " . $birthdate . "<br>";
        echo "Nem: " . $gender . "<br>";
        echo "Érdeklődési területek: " . $interests . "<br>";
        echo "Ország: " . $country . "<br>";
    } else {

        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Név: <input type="text" name="name"><br>
    E-mail cím: <input type="text" name="email"><br>
    Jelszó: <input type="password" name="password"><br>
    Jelszó megerősítése: <input type="password" name="confirmPassword"><br>
    Születési dátum: <input type="date" name="birthdate"><br>
    Nem:
    <input type="radio" name="gender" value="Férfi"> Férfi
    <input type="radio" name="gender" value="Nő"> Nő
    <input type="radio" name="gender" value="Egyéb"> Egyéb<br>
    Érdeklődési területek:
    <input type="checkbox" name="interests[]" value="Sport"> Sport
    <input type="checkbox" name="interests[]" value="Művészet"> Művészet
    <input type="checkbox" name="interests[]" value="Tudomány"> Tudomány<br>
    Ország:
    <select name="country">
        <option value="Magyarország">Magyarország</option>
        <option value="Románia">Románia</option>
        <option value="Szlovákia">Szlovákia</option>

    </select><br>
    <input type="submit" name="submit" value="Regisztráció">
</form>

