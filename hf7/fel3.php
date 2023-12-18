<?php
// Start or resume the session
session_start();

if (!isset($_SESSION['szam'])) {
    $_SESSION['szam'] = mt_rand(1, 10);
}

if (isset($_POST["formSubmit"])) {
    $szam = $_POST["talalgatas"];

    if (is_numeric($szam) && $szam != "") {
        if ($_SESSION['szam'] > $szam) {
            echo "A szám nagyobb";
        } elseif ($_SESSION['szam'] < $szam) {
            echo "A szám kisebb";
        } elseif ($_SESSION['szam'] == $szam) {
            // Töröljük a számot a munkamenetből
            unset($_SESSION['szam']);
            session_destroy();
            echo "Eltalálta";
        }
    } else {
        echo "Adj meg egy számot!";
    }
}
?>

<form method="POST" action="">
    <input type="hidden" name="elkuldott" value="true">
    Melyik számra gondoltam 1 és 10 között?
    <input name="talalgatas" type="text">
    <br>
    <br>
    <input type="submit"  name="formSubmit" value="Elküld">
</form>

