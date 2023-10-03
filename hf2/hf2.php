<!Doctype html>
<head>
    <title>Hf2</title>
</head>
<body>
<div>
    <h2>elso feladat</h2>
    <?php
        $tomb=([5, '5', '05', 12.3, '16.7', 'five', 0xDECAFBAD, '10e200']);
        foreach ($tomb as $item){
            echo gettype($item);
            if(is_numeric($item)){
                echo "  igen<br>";
            }else {echo "  nem<br>";}
    }

    ?>
    <h2>masodik feladat</h2>
    <?php
    $orszagok = array( " Magyarország "=>" Budapest", " Románia"=>" Bukarest",
        "Belgium"=> "Brussels", "Austria" => "Vienna", "Poland"=>"Warsaw");
    foreach ($orszagok as $orszag=>$ertek){
        echo $orszag." fovárosa: ".$ertek."<br>";
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
            echo $nap." ";
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
    $szinek = array('A' => 'Kek', 'B' => 'Zold', 'c' => 'Piros');
    atalakit($szinek,"kisbetu");
    echo"kisbetu"."<br>";
    var_dump($szinek);

    atalakit($szinek,"nagybetu");
    echo"<br>nagybetu"."<br>";
    var_dump($szinek);
    ?>
</div>
</body>