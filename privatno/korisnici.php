<?php
$naslov = "Korisnici privatno"; 

require_once "../baza.php"; 
$baza1 = new Baza(); 
$rezultat = $baza1->IzvrsiUpit("select k.korisnicko_ime, k.lozinka from korisnik as k "); 

         echo "
         <main id = 'sredina'>  
         <fieldset class='registracija-prijava'>
         <legend class='legenda'>Prikaz korisnika i lozinki</legend>  
         <table>
         <tr>
             <th>Korisnicko ime</th>
             <th>Lozinka</th>
          </tr>"; 
          
             foreach($rezultat as $key => $value)
             {
                 echo "
                 <tr>
                     <td>{$value["korisnicko_ime"]}</td>   
                     <td>{$value["lozinka"]}</td>                                                          
                 </tr> 
                 "; 
             }
         echo "
         </table>
         </fieldset>" ; 
?>