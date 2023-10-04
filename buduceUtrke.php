<?php
$naslov = "Buduce utrke"; 
require_once "osnovno.php"; 

require_once "baza.php"; 
$baza = new Baza(); 

$t=time();
$date= date("Y-m-d",$t);

$rezultat = $baza->IzvrsiUpit("select * from utrka WHERE utrka.zavrsetak_prijava > ?", ("s"), [$date]); 
?>
<main id = "sredina">  
        <?php
            echo "
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz država</legend>  
            <table>
            <tr>
                <th>Id utrke</th>
                <th>Naziv</th>
                <th>Lokacija</th>
                <th>Završetak prijava</th>
             </tr>"; 
                foreach($rezultat as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["id_utrka"]}</td>   
                        <td>{$value["naziv"]}</td>  
                        <td>{$value["lokacija"]}</td> 
                        <td>{$value["zavrsetak_prijava"]}</td>                                                           
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>"; 
        ?>
           