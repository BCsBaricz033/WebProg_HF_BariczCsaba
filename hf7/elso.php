<?php
if(!isset($_COOKIE["szam"]))
    setcookie("szam", mt_rand(1, 10), time() + (86400 * 30));


if (isset($_POST["formSubmit"])) {
    $szam = $_POST["talalgatas"];

    if (is_numeric($szam) && $szam != "") {
        if ($_COOKIE["szam"] > $szam) {
            echo "A szám nagyobb";
        } elseif ($_COOKIE["szam"] < $szam) {
            echo "A szám kisebb";
        } elseif ($_COOKIE["szam"] == $szam) {
            setcookie("szam", "", time() - 3600);
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


