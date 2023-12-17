<?php
class BevasarloLista {
    private $bevasarloLista = [];


    public function hozzaadElem($nev, $mennyiseg, $egysegar) {
        $elem = ["nev" => $nev, "mennyiseg" => $mennyiseg, "egysegar" => $egysegar];
        $this->bevasarloLista[] = $elem;
        echo "$nev hozzáadva a bevásárlólistához.<br>";
    }


    public function eltavolitElem($nev) {
        foreach ($this->bevasarloLista as $index => $elem) {
            if ($elem["nev"] === $nev) {
                unset($this->bevasarloLista[$index]);
                echo "$nev eltávolítva a bevásárlólistáról.<br>";
                return;
            }
        }
        echo "$nev nem található a bevásárlólistán.<br>";
    }


    public function kiirLista() {
        echo "Bevásárlólista:<br>";
        foreach ($this->bevasarloLista as $elem) {
            echo "Név: {$elem['nev']}, Mennyiség: {$elem['mennyiseg']}, Egysegar: {$elem['egysegar']}<br>";
        }
    }


    public function osszKoltseg() {
        $osszeg = 0;
        foreach ($this->bevasarloLista as $elem) {
            $osszeg += $elem["mennyiseg"] * $elem["egysegar"];
        }
        echo "A bevásárlólista összköltsége: $osszeg.<br>";
    }
}


$bevasarloLista = new BevasarloLista();
$bevasarloLista->hozzaadElem("Kenyer", 2, 8.5);
$bevasarloLista->hozzaadElem("Viz", 1, 2.5);
$bevasarloLista->kiirLista();
$bevasarloLista->eltavolitElem("Kenyer");
$bevasarloLista->kiirLista();
$bevasarloLista->osszKoltseg();
?>

