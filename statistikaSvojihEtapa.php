<?php
$naslov = "Statistika završenosti mojih etapa"; 
require_once "osnovno.php"; 

require_once "baza.php"; 
$baza1 = new Baza(); 
$rezultat = $baza1->IzvrsiUpit("SELECT COUNT(*) as zavrseno, d.naziv from prijava_etape as pe join etapa as e on pe.etapa = e.id_etapa join utrka as u on e.utrka = u.id_utrka join drzava as d on u.drzava = d.id_drzava  where pe.odustao = 0 and pe.korisnik = ? GROUP by d.id_drzava ORDER by zavrseno DESC", ("i"), [$_SESSION["id_korisnik"]]); 

         echo "
         <main id = 'sredina'>  
         <fieldset class='registracija-prijava'>
         <legend class='legenda'>Prikaz završenosti mojih etapa po državama</legend>  
         <table>
         <tr>
             <th>Država</th>
             <th>Broj završenih etapa</th>
          </tr>"; 
          
             foreach($rezultat as $key => $value)
             {
                 echo "
                 <tr>
                     <td>{$value["naziv"]}</td>   
                     <td>{$value["zavrseno"]}</td>                                                          
                 </tr> 
                 "; 
             }
         echo "
         </table>
         </fieldset>" ; 
?>