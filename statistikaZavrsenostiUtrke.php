<?php
$naslov = "Statistika završenosti utrka"; 
require_once "osnovno.php"; 

require_once "baza.php"; 
$baza1 = new Baza(); 
$odustaliPoEtapi = $baza1->IzvrsiUpit("select s.odustali, s.etapa, u.id_utrka, e.naziv from utrka as u join etapa as e on e.utrka = u.id_utrka join (select count(*) as odustali, p.etapa from prijava_etape as p where p.odustao = 1 GROUP by p.etapa) as s on s.etapa = e.id_etapa GROUP BY u.id_utrka, s.etapa,  s.odustali"); 
?>
<?php
 
$baza2 = new Baza(); 
$zavrsiliPoEtapi = $baza2->IzvrsiUpit("select s.zavrsili, s.etapa, u.id_utrka, e.naziv from utrka as u join etapa as e on e.utrka = u.id_utrka join (select count(*) as zavrsili, p.etapa from prijava_etape as p where p.odustao = 0 GROUP by p.etapa) as s on s.etapa = e.id_etapa GROUP BY u.id_utrka, s.etapa,  s.zavrsili"); 
?>
<?php

$baza3 = new Baza(); 
$utrke = $baza3->IzvrsiUpit("select * from utrka");
?>


<main id = "sredina">  
        <?php
             
        $proslaUtrka=""; 
        foreach ($utrke as $key => $value)
        {
            echo " 
                    <fieldset class='dokumentacija-fieldset'>
                    <legend class='legenda'>{$value["naziv"]}</legend>    
                    <div>"; 
            foreach($zavrsiliPoEtapi as $kljuc => $vrijednost)
            {
                if($value["id_utrka"] == $vrijednost["id_utrka"])
                {
                    echo " Broj natjecatelja koji su završili etapu pod nazivom {$vrijednost["naziv"]}: ".$vrijednost["zavrsili"]."<br>"; 
                }
            }
            foreach($odustaliPoEtapi as $kljuc1 => $vrijednost1)
            {
                if($value["id_utrka"] == $vrijednost1["id_utrka"])
                {
                    echo " Broj natjecatelja koji su odustali od etape pod nazivom {$vrijednost1["naziv"]}: ".$vrijednost1["odustali"]."<br>"; 
                }
            }
            echo " 
            </div>
            </fieldset>";
        }
        ?>