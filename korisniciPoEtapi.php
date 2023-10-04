<?php
$naslov = "Popis korisnika po etapi"; 
require_once "osnovno.php"; 

include_once "baza.php";
$baza = new Baza(); 
$rezultat = $baza->IzvrsiUpit("select k.ime, k.prezime, pe.odustao, e.naziv as etapa, u.naziv as utrka, d.naziv as drzava from korisnik as k join prijava_etape as pe on pe.korisnik=k.id_korisnik join etapa as e on pe.etapa = e.id_etapa join utrka as u on e.utrka=u.id_utrka join drzava as d on u.drzava=d.id_drzava join moderatori as m on d.id_drzava=m.id_drzava and m.id_korisnik = ?", ("i"), [$_SESSION["id_korisnik"]]); 

            echo "
            <main id = 'sredina'>  
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz stanja korisnika po etapi </legend>  
            <table>
            <tr>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Naziv etape</th>
                <th>Utrka</th>
                <th>Država</th>
                <th>Status</th>
             </tr>"; 
             
                foreach($rezultat as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["ime"]}</td>   
                        <td>{$value["prezime"]}</td>
                        <td>{$value["etapa"]}</td>
                        <td>{$value["utrka"]}</td>
                        <td>{$value["drzava"]}</td>    
                        <td>".($value["odustao"] == 0 ? " Nije odustao":" Odustao je")."</td>                                                                
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>" ; 

 ispisiPodnozje(); 
 exit(); 
 ?>