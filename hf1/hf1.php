<!DOCTYPE html>
<head>
    <title>HF1
    </title>
</head>
<body>
<div>
    <h1>Elso feladat</h1>
    <?php
    /*Kérdezzük le az aktuális napot (date függvény), majd ennek megfelelően írjunk ki egy üzenetet  magyarul (pld. Ma hétfő.)
*/
    setlocale(LC_TIME, 'hu_HU.UTF-8');
    $napok = array('vasárnap', 'hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat');
    $aktualisNap = $napok[date('w')];
    echo 'Ma ' . $aktualisNap . ' van.';
    ?>
</div>
<div>
    <h1>Második feladat</h1>
    <?php
    /*Írjál programot, egy számológép elkészítésére (4 alapműveletre)
*/
    $ElsoSzam = isset($_POST['x']) ? $_POST['x'] : '';
    $MasodikSzam = isset($_POST['y']) ? $_POST['y'] : '';
    $Muvelet = isset($_POST['gombb']) ? $_POST['gombb'] : '';
    $Eredmeny = '';
    if (!empty($ElsoSzam) && !empty($MasodikSzam) && !empty($Muvelet)) {
        switch ($Muvelet) {
            case "osszeadas":
                $Eredmeny = $ElsoSzam + $MasodikSzam;
                break;
            case "kivonas":
                $Eredmeny = $ElsoSzam - $MasodikSzam;
                break;
            case "szorzas":
                $Eredmeny = $ElsoSzam * $MasodikSzam;
                break;
            case "osztas":
                $Eredmeny = $ElsoSzam / $MasodikSzam;
        }
    }
    ?>

    <form action="" method="post" >
        <label>Első szám</label>
        <input type="number" name="x"value="<?php echo $ElsoSzam; ?>"></input>
        <label>Második szám</label>
        <input type="number" name="y"value="<?php echo $MasodikSzam; ?>"></input>
        <button name="gombb" value="osszeadas">+</button>
        <button name="gombb" value="kivonas">-</button>
        <button name="gombb" value="szorzas">*</button>
        <button name="gombb" value="osztas">/</button>

        <input readonly="readonly" name="Eredmeny" value="<?php echo $Eredmeny; ?>">
    </form>

</div>
<div>
    <h1>Harmadik feladat</h1>
    <table border="1">
        <tr>
            <th></th>
            <?php
            //osztotabla
            for ($x = 1; $x <= 10; $x++) {
                echo "<th>$x</th>";
            }
            ?>
        </tr>
        <?php
        for ($y = 1; $y <= 10; $y++) {
            echo "<tr>";
            echo "<th>$y</th>";

            for ($x = 1; $x <= 10; $x++) {
                $result = $x / $y;
                echo "<td>$result</td>";
            }

            echo "</tr>";
        }
        ?>
</div>
<div>
    <h1>Negyedik feladat</h1>
    <?php
    //sakktábla rajzoló
    function sakkRajzolo(){
        echo "<table>";
        for ($x = 1; $x <= 8; $x++) {
            echo "<tr>";
            for ($y = 1; $y <= 8; $y++){
                if(($y+$x)%2==0){echo "<td style='background-color:black;'>"."valami"."</td>";}
                else{echo "<td>".""."</td>";}

            }
            echo "</tr>";}
    }
    echo "</table>";
    sakkRajzolo();
    ?>
</div>
<div>
    <h1>ötödik feladat</h1>
    <form method="post">
        <label for="word">Adjon meg egy szót:</label>
        <input type="text" id="word" name="word">
        <input type="submit" value="Átalakítás">
    </form>

    <?php // szó átalakító -- !nem saját megoldás
    function spongecase($input) {
        $spongecased = '';
        $toggle = true; // Kezdd nagybetűvel

        for ($i = 0; $i < strlen($input); $i++) {
            $char = $input[$i];

            if (ctype_alpha($char)) { // Csak betűket változtatunk
                if ($toggle) {
                    $spongecased .= strtoupper($char);
                } else {
                    $spongecased .= strtolower($char);
                }
                $toggle = !$toggle; // Váltogatás a következő karakterre
            } else {
                $spongecased .= $char; // Egyéb karaktereket nem változtatjuk
            }
        }

        return $spongecased;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = isset($_POST["word"]) ? $_POST["word"] : '';
        $output = spongecase($input);
        echo "<p>Az átalakított szó: $output</p>";
    }
    ?>
</div>

</body>
