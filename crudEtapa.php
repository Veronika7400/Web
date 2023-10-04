<?php
$naslov = "Kreiranje etapa"; 
require_once "osnovno.php"; 

include_once "baza.php";
$baza = new Baza(); 

$rezultat = $baza->IzvrsiUpit("select e.naziv as etapa, u.naziv as utrka, d.naziv as drzava from etapa as e join utrka as u on e.utrka = u.id_utrka join drzava as d on u.drzava = d.id_drzava join moderatori as m on d.id_drzava = m.id_drzava where m.id_korisnik = ? order BY u.id_utrka", ("i"), [$_SESSION["id_korisnik"]]); 
$utrke = $baza->IzvrsiUpit("select u.naziv, u.id_utrka from utrka as u join drzava as d on u.drzava=d.id_drzava join moderatori as m on d.id_drzava = m.id_drzava where m.id_korisnik = ? GROUP BY u.naziv",  ("i"), [$_SESSION["id_korisnik"]]); 
?>
<main id = "sredina">  
        <?php
            echo "
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz etapa po utrkama </legend>  
            <table>
            <tr>
                <th>Utrka</th>
                <th>Etapa</th>
                <th>Država</th>
             </tr>"; 
                foreach($rezultat as $key => $value)
                {
                    echo "
                    <tr> 
                        <td>{$value["utrka"]}</td>
                        <td>{$value["etapa"]}</td> 
                        <td>{$value["drzava"]}</td>                                                              
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>

            <form action = 'crudEtapa.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Kreiranje etape utrke</legend>  

            <label for='odaberiUtrku'>Odaberite utrku:</label>
            <select name='odaberiUtrku' id='odaberiUtrku'>";

                foreach($utrke as $key => $value)
                {
                    echo "<option value={$value["id_utrka"]}>{$value["naziv"]}</option>"; 
                }

            echo"
            </select> <br><br>

            <label for='Naziv'>Naziv: </label>
            <input type='text' id='Naziv' name='Naziv'><br><br>

            <label for='datum'>Datum:</label>
            <input type='date' id='datum' name='datum'><br><br>

            <label for='Vrijeme'>Vrijeme:</label>
            <input type='text' id='Vrijeme' name='Vrijeme'><br><br>

            <label for='Duzina'>Dužina: </label>
            <input type='text' id='Duzina' name='Duzina'><br><br>

            <input  class='gumb'  type='submit' name='kreiraj'  value='Kreiraj etapu'>
            </fieldset>
            </form>


        <form action = 'crudEtapa.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Ažuriranje etape utrke</legend>  
            
           <label for='odaberiUtrkuaz'>Odaberite utrku:</label>
            <select name='odaberiUtrkuaz' id='odaberiUtrkuaz'>";

                foreach($utrke as $key => $value)
                {
                    echo "<option value={$value["id_utrka"]}>{$value["naziv"]}</option>"; 
                }

            echo"
            </select> <br><br>
             <input  class='gumb'  type='submit' name='odabranaUtrka'  value='Odaberi utrku'>
             </form>";

             
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['odabranaUtrka']))
            {
                $baza = new Baza(); 
                $moguceEtape = $baza->IzvrsiUpit("select * from etapa as e where e.utrka = ?", ("i"), [$_POST["odaberiUtrkuaz"]]); 
               echo " 
               <br><br><label for='odaberiteEtapuaz'>Odaberite etapu:</label>
                    <select name='odaberiteEtapuaz' id='odaberiteEtapuaz'>";

                        foreach($moguceEtape as $key => $value)
                        {
                            echo "<option value={$value["id_etapa"]}>{$value["naziv"]}</option>"; 
                        }
                echo"
                    </select> <br><br>
                
                <label for='Nazivaz'>Naziv: </label>
                <input type='text' id='Nazivaz' name='Nazivaz'><br><br>

                <label for='datumaz'>Datum:</label>
                <input type='date' id='datumaz' name='datumaz'><br><br>

                <label for='Vrijemeaz'>Vrijeme:</label>
                <input type='text' id='Vrijemeaz' name='Vrijemeaz'><br><br>

                <label for='Duzinaaz'>Dužina: </label>
                <input type='text' id='Duzinaaz' name='Duzinaaz'><br><br>

                <input  class='gumb'  type='submit' name='azuriraj'  value='Ažuriraj etapu'>
                </fieldset>
                </form>";
            }
            else 
            {
                echo "
                 </fieldset>
                 </form>";
            }
            
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['kreiraj']))
        {
            if(!empty($_POST["odaberiUtrku"]) && !empty($_POST["Naziv"]) && !empty($_POST["datum"]) && !empty($_POST["Vrijeme"]) && !empty($_POST["Duzina"]))
            { 
                $baza = new Baza(); 
                $baza->IzvrsiUpit("INSERT INTO etapa(datum, vrijeme, zakljucana, naziv, duzina, utrka) VALUES (?,?,?,?,?,?)", ("ssissi"), [$_POST["datum"], $_POST["Vrijeme"],0,$_POST["Naziv"], (int)$_POST["Duzina"], (int)$_POST["odaberiUtrku"]], true);
            }
        }


        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['azuriraj']))
        {
            if(!empty($_POST["odaberiteEtapuaz"]) && !empty($_POST["Nazivaz"]) && !empty($_POST["datumaz"]) && !empty($_POST["Vrijemeaz"]) && !empty($_POST["Duzinaaz"]))
            { 
                $baza = new Baza(); 
                $baza->IzvrsiUpit("UPDATE etapa SET datum = ?, vrijeme = ?, naziv = ?,duzina = ?, utrka=? WHERE etapa.id_etapa = ?", ("ssssii"), [$_POST["datumaz"], $_POST["Vrijemeaz"],$_POST["Nazivaz"], $_POST["Duzinaaz"], $_POST["odaberiUtrkuaz"], (int)$_POST["odaberiteEtapuaz"]], true);
            }
        }
 ispisiPodnozje(); 
 exit(); 
 ?>