<!Doctype html>
<head>
    <title>Hf2</title>
</head>
<body>
<div>
    <h2>Elso feladat</h2>
    <?php
    $szin="blue";
    $szorzotabla=function ($n) use($szin){
        echo "<table>";
        for ($x = 1; $x <= $n; $x++) {
            echo "<tr>";
            for ($y = 1; $y <= $n; $y++) {
                if($x==$y){
                    echo"<td style='background-color: $szin'>";
                }else{
                    echo"<td>";
                }

                echo $x*$y;
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    };
    $szorzotabla(10);


    ?>
    <h2>Második feladat</h2>
    <?php
    $orszagok = array( " Magyarország "=>" Budapest", " Románia"=>" Bukarest",
        "Belgium"=> "Brussels", "Austria" => "Vienna", "Poland"=>"Warsaw");
    foreach ($orszagok as $orszag=>$ertek){
        echo $orszag." fovárosa: <span style='color: red'>".$ertek."</span><br>";
    }
    ?>
    <h2>Harmadik feladat</h2>
    <?php
        $napok = array(
	"HU" => array("H", "K", "Sze", "Cs", "P", "Szo", "V"),
	"EN" => array("M", "Tu", "W", "Th", "F", "Sa", "Su"),
	"DE" => array("Mo", "Di", "Mi", "Do", "F", "Sa", "So"),
        );
    foreach ($napok as $nyelvek=>$nyelv){
        echo $nyelvek.": ";
        foreach ($nyelv as $nap){
            if($nap=="K" || $nap=="Cs"  || $nap=="Szo" || $nap=="Tu" || $nap=="Th"  || $nap=="Sa" || $nap=="Di"  || $nap=="Do" ){
                echo "<strong>".$nap." </strong>";
            }
            else{
                echo $nap." ";
            }

        }
        echo "<br>";
    }
    ?>
    <h2>Negyedik feladat</h2>
    <?php
    function atalakit(&$list,$tulajdonsag){
        if($tulajdonsag==="nagybetu"){
            foreach ($list as $key=>&$item){
                $item=strtoupper($item);
            }
        }elseif ($tulajdonsag==="kisbetu"){
            foreach ($list as $key=>&$item){
                $item=strtolower($item);
            }
        }
    };
    function atalakitBeture($tomb, $tulajdonsag) {
        return array_map(function ($elem) use ($tulajdonsag) {
            if ($tulajdonsag == "nagybetu") {
                return strtoupper($elem);
            } else {
                return strtolower($elem);
            }
        }, $tomb);
    }

    $szinek = array('A' => 'Kek', 'B' => 'Zold', 'c' => 'Piros');
    atalakit($szinek,"kisbetu");
    echo"kisbetu"."<br>";
    var_dump($szinek);

    atalakit($szinek,"nagybetu");
    echo"<br>nagybetu"."<br>";
    var_dump($szinek);
    echo"<br>nagybetu"."<br>";
    var_dump(  atalakitBeture($szinek, "nagybetu"));

    echo"<br>kisbetu"."<br>";

    var_dump( atalakitBeture($szinek, "kisbetu"));

    ?>
</div>

</body>
<style>
    table, th, td {
        border:1px solid black;
    }
</style>