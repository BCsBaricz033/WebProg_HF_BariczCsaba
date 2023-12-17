<!DOCTYPE html>
<head>
    <title>HF1
    </title>
</head>
<body>
<div>
    <h1>Elso feladat</h1>
    <?php

    $lista=([5, '5', '05', 12.3, '16.7', 'five', 'true', 0xDECAFBAD, '10e200']);
    foreach ($lista as $item){
        if(is_numeric($item)){
            echo "Igen<br>";
        }else{
            echo "Nem<br>";
        }
    }
    ?>
</div>
<div>
    <h1>Második feladat</h1>
    <?php
    $masodpercek = 3600;
    if (filter_var($masodpercek, FILTER_VALIDATE_INT) !== false) {
        $orak = $masodpercek / 3600;


        echo "A megadott másodpercek száma: <strong>{$masodpercek}</strong> másodperc.<br>";
        echo "Ez összesen: <strong>{$orak}</strong> óra.";
    } else {
        echo "Hiba: A megadott érték nem egész szám!";
    }
    ?>



</div>
<div>
    <h1>Harmadik feladat</h1>
    <?php

    $szam1 = 5;
    $szam2 = 2;


    $osszeadas = $szam1 + $szam2;
    echo "Összeadás: {$szam1} + {$szam2} = {$osszeadas}<br>";


    $kivonas = $szam1 - $szam2;
    echo "Kivonás: {$szam1} - {$szam2} = {$kivonas}<br>";


    $szorzas = $szam1 * $szam2;
    echo "Szorzás: {$szam1} * {$szam2} = {$szorzas}<br>";


    if ($szam2 != 0) {
        $osztas = $szam1 / $szam2;
        echo "Osztás: {$szam1} / {$szam2} = {$osztas}<br>";
    } else {
        echo "Hiba: Osztás nullával nem lehetséges!<br>";
    }


    $hatvanyozas = pow($szam1, $szam2);
    echo "Hatványozás: {$szam1} ^ {$szam2} = {$hatvanyozas}<br>";
    ?>

</div>
<div>
    <h1>Negyedik feladat</h1>
    <?php
    function sakkRajzolo(){
        echo "<table>";
        for ($x = 1; $x <= 3; $x++) {
            echo "<tr>";
            for ($y = 1; $y <= 3; $y++){
                if(($y+$x)%2==0){
                    echo "<td style='background-color:black;'>"."valami"."</td>";
                }
                else{
                    echo "<td>".""."</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    sakkRajzolo();
    ?>
</div>
<div>
    <h1>Ötödik feladat</h1>
    <?php
    $szam3 = 10;
    $szam4 = 5;
    $muveletiJel = '+';


    switch ($muveletiJel) {
        case '+':
            $eredmeny = $szam3 + $szam4;
            break;
        case '-':
            $eredmeny = $szam3 - $szam4;
            break;
        case '*':
            $eredmeny = $szam3 * $szam4;
            break;
        case '/':

            if ($szam4 != 0) {
                $eredmeny = $szam3 / $szam4;
            } else {
                echo "Hiba: 0-val nem lehet osztani!<br>";

                break;
            }
            break;
        default:
            echo "Hiba: Érvénytelen műveleti jel!<br>";

            break;
    }


    if (isset($eredmeny)) {
        echo "{$szam3} {$muveletiJel} {$szam4}=  {$eredmeny}<br>";
    }
    ?>


</div>
<div>
    <h1>Hatodik feladat</h1>
    <?php
    function meghatarozEvszak($honap) {
        /*
        if ($honap >= 3 && $honap <= 5) {
            return "Tavasz";
        } elseif ($honap >= 6 && $honap <= 8) {
            return "Nyár";
        } elseif ($honap >= 9 && $honap <= 11) {
            return "Ősz";
        } else {
            return "Tél";
        }
        */
        switch($honap){
            case 3:
            case 4:
            case 5:
                return "Tavasz";
                break ;
            case 6:
            case 7:
            case 8:
                return "Nyár";
                break;
            case 9:
            case 10:
            case 11:
                return "Ősz";
                break;
            case 12:
            case 1:
            case 2:
                return "Tél";
                break;
        }



    }

    $honap = 11;
    $evszak = meghatarozEvszak($honap);
    echo " $honap. hónap  $evszak ";
    ?>

</div>

</body>
