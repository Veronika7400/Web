<?php
$naslov = "Prijava na utrku"; 
require_once "osnovno.php"; 

require_once "baza.php"; 
$baza = new Baza(); 
$rezultat =  $baza->IzvrsiUpit("select p.id_prijava_etape, e.naziv as etapa, u.naziv as utrka,u.zavrsetak_prijava, p.datum_rodenja, p.slika from prijava_etape as p join etapa as e on e.id_etapa = p.etapa join utrka as u on u.id_utrka = e.utrka where p.korisnik = ?", ("i"), [$_SESSION["id_korisnik"]]); 
$etape = $baza->IzvrsiUpit("SELECT * from etapa ");
$utrke = $baza->IzvrsiUpit("SELECT * from utrka ");
?>
<main id = "sredina">  
        <?php
            echo "
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz dosadašnjih prijava</legend>  
            <table>
            <tr>
                <th>Id prijave</th>
                <th>Utrka</th>
                <th>Etapa</th>
                <th>Datum rođenja</th>
                <th>Slika</th>
             </tr>"; 
                foreach($rezultat as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["id_prijava_etape"]}</td>   
                        <td>{$value["utrka"]}</td>  
                        <td>{$value["etapa"]}</td>       
                        <td>{$value["datum_rodenja"]}</td>  
                        <td><img src='data:image/png;base64,".base64_encode($value["slika"])."'width='150' height='150'/></td>                                                       
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>
            
        <form action = 'prijavaNaUtrku.php' method = 'post'>
        <fieldset class='registracija-prijava'>
        <legend class='legenda'>Ažuriranje prijave</legend>  
        
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
           <br><br><label for='odabranaPrijava'>Odaberite id prijave:</label>
            <select name='odabranaPrijava' id='odabranaPrijava'>";

            foreach($rezultat as $key => $value)
            {
                echo "<option value={$value["id_prijava_etape"]}>{$value["id_prijava_etape"]}</option>"; 
            }

            echo"
            </select> 
            <br><br>

           <br><br><label for='odaberiteEtapuaz'>Odaberite etapu:</label>
                <select name='odaberiteEtapuaz' id='odaberiteEtapuaz'>";

                    foreach($moguceEtape as $key => $value)
                    {
                        echo "<option value={$value["id_etapa"]}>{$value["naziv"]}</option>"; 
                    }
            echo"
                </select> <br><br>

            <label for='datumaz'>Datum rođenja:</label>
            <input type='date' id='datumaz' name='datumaz'><br><br>

            <label for='odabranaslikaZaAzuriranje'>Odaberite sliku:</label>
            <input type='file' id='odabranaslikaZaAzuriranje' name='odabranaslikaZaAzuriranje'><br>

            <input  class='gumb'  type='submit' name='azuriraj'  value='Ažuriraj prijavu'>
            </fieldset>
            </form>";
        }
        else 
        {
            echo "
             </fieldset>
             </form>";
        }
        echo"
        <form action = 'prijavaNaUtrku.php' method = 'post'>
        <fieldset class='registracija-prijava'>
        <legend class='legenda'>Kreiranje prijave</legend>  
        
       <label for='odaberiUtrkakreiranje'>Odaberite utrku:</label>
        <select name='odaberiUtrkakreiranje' id='odaberiUtrkakreiranje'>";

            foreach($utrke as $key => $value)
            {
                echo "<option value={$value["id_utrka"]}>{$value["naziv"]}</option>"; 
            }

        echo"
        </select> <br><br>
         <input  class='gumb'  type='submit' name='odabranaUtrkak'  value='Odaberi utrku'>
         </form>";

         
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['odabranaUtrkak']))
        {
            $baza = new Baza(); 
            $moguceEtapek = $baza->IzvrsiUpit("select * from etapa as e where e.utrka = ?", ("i"), [$_POST["odaberiUtrkakreiranje"]]); 
           echo " 
           <br><br><label for='odaberiteEtapuk'>Odaberite etapu:</label>
                <select name='odaberiteEtapuk' id='odaberiteEtapuk'>";

                    foreach($moguceEtapek as $key => $value)
                    {
                        echo "<option value={$value["id_etapa"]}>{$value["naziv"]}</option>"; 
                    }
            echo"
            </select> <br><br>

            <label for='datumk'>Datum rođenja:</label>
            <input type='date' id='datumk' name='datumk'><br><br>

            <label for='odabranaslikak'>Odaberite sliku:</label>
            <input type='file' id='odabranaslikak' name='odabranaslikak'><br>

            <input  class='gumb'  type='submit' name='kreiraj'  value='Kreiraj prijavu'>
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
            if(!empty($_POST["odaberiteEtapuk"]) && !empty($_POST["datumk"]) && !empty($_POST["odabranaslikak"]))
            { 
                $baza = new Baza(); 
                $baza->IzvrsiUpit("INSERT INTO prijava_etape(datum_rodenja, slika, odustao, bodovi, korisnik, etapa) VALUES (?,?,?,?,?,?)", ("ssiiii"), [$_POST["datumk"], $_POST["odabranaslikak"],0,0,$_SESSION["id_korisnik"] ,$_POST["odaberiteEtapuk"]], true);
            }
        }

        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['azuriraj']))
        {
            if(!empty($_POST["odaberiteEtapuaz"]) && !empty($_POST["odaberiUtrkuaz"]) && !empty($_POST["datumaz"]) && !empty($_POST["odabranaslikaZaAzuriranje"]))
            { 
                $baza = new Baza(); 
                $baza->IzvrsiUpit("UPDATE prijava_etape SET datum_rodenja = ?,slika = ?,etapa = ? WHERE prijava_etape.id_prijava_etape = ? ", ("ssii"), [$_POST["datumaz"], $_POST["odabranaslikaZaAzuriranje"],$_POST["odaberiteEtapuaz"], (int)$_POST["odabranaPrijava"]], true);
            }
        }
    
    ?>
 <?php
 ispisiPodnozje(); 
 ?>