<?php
$naslov = "Utrke trčanja"; 
require_once "osnovno.php"; 

require_once "baza.php";  
$baza = new Baza();
$rezultat = $baza->IzvrsiUpit("select d.naziv as drzava, u.naziv, u.zavrsetak_prijava, u.lokacija, u.tip_utrke, u.drzava, t.naziv as tip, u.id_utrka from utrka as u join drzava as d on d.id_drzava = u.drzava join tip_utrke as t on t.id_tip_utrke = u.tip_utrke ");
$tipovi = $baza->IzvrsiUpit("select * from tip_utrke"); 
$drzave =  $baza->IzvrsiUpit("select * from drzava"); 
?>
<main id = "sredina">  
        <?php  
            echo "
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz utrka trčanja</legend>  
            <table>
            <tr>
                <th>Naziv</th>
                <th>Država</th>
                <th>Lokacija</th>
                <th>Završetak prijava</th>
                <th>Tip utrke</th>
             </tr>"; 
                foreach($rezultat as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["naziv"]}</td>   
                        <td>{$value["drzava"]}</td>    
                        <td>{$value["lokacija"]}</td> 
                        <td>{$value["zavrsetak_prijava"]}</td> 
                        <td>{$value["tip"]}</td>                                                         
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>
            
            <form action = 'utrkeTrcanja.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Kreiranje utrke trčanja</legend>  
            <label for='Naziv'>Naziv: </label>
            <input type='text' id='Naziv' name='Naziv'><br><br>
            <label for='zavrsetakPrijava'>Datum od:</label>
            <input type='date' id='zavrsetakPrijava' name='zavrsetakPrijava'><br><br>
            <label for='Lokacija'>Lokacija: </label>
            <input type='text' id='Lokacija' name='Lokacija'><br><br>
            <label for='odaberiDrzavu'>Odaberite državu:</label>
            <select name='odaberiDrzavu' id='odaberiDrzavu'>";

            foreach($drzave as $key => $value)
            {
                echo "<option value={$value["id_drzava"]}>{$value["naziv"]}</option>"; 
            }

        echo"
        </select> <br><br>
        <label for='odaberiTipUtrke'>Odaberite tip utrke:</label>
        <select name='odaberiTipUtrke' id='odaberiTipUtrke'>";

            foreach($tipovi as $key => $value)
            {
                echo "<option value={$value["id_tip_utrke"]}>{$value["naziv"]}</option>"; 
            }

        echo"
        </select>
        <br><br>
        <input  class='gumb'  type='submit' name='kreiraj'  value='Kreiraj utrku'>
        </fieldset>
        </form>


        <form action = 'utrkeTrcanja.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Ažuriranje utrke trčanja</legend>  
            
            <label for='idaz'>Odaberite utrku:</label>
                <select name='idaz' id='idaz'>";
                foreach($rezultat as $key => $value)
                {
                    echo "<option value={$value["id_utrka"]}>{$value["naziv"]}</option>"; 
                }

            echo"
            </select> <br><br>

            <label for='odaberiDrzavuaz'>Odaberite novu državu održavanja :</label>
            <select name='odaberiDrzavuaz' id='odaberiDrzavuaz'>";
                foreach($drzave as $key => $value)
                {
                    echo "<option value={$value["id_drzava"]}>{$value["naziv"]}</option>"; 
                }
            echo"
            </select> <br><br>
            <label for='odaberiTipaz'>Odaberite tip utrke:</label>
            <select name='odaberiTipaz' id='odaberiTipaz'>";
                foreach($tipovi as $key => $value)
                {
                    echo "<option value={$value["id_tip_utrke"]}>{$value["naziv"]}</option>"; 
                }
            echo"
            </select> <br><br>
            <label for='novinaziv'>Upišite novi naziv: </label>
            <input type='text' id='novinaziv' name='novinaziv'><br><br>

            <label for='novizavrsetak'>Datum završetka prijava:</label>
            <input type='date' id='novizavrsetak' name='novizavrsetak'><br><br>

            <label for='novalokacija'>Upišite novu lokaciju: </label>
            <input type='text' id='novalokacija' name='novalokacija'><br><br>

            <input  class='gumb'  type='submit' name='azuriraj'  value='Ažuriraj utrku'>
            </fieldset>
            </form>
        "; 
        ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['kreiraj']))
    {
        if(!empty($_POST["Naziv"]) && !empty($_POST["zavrsetakPrijava"]) && !empty($_POST["Lokacija"]) && !empty($_POST["odaberiDrzavu"]) && !empty($_POST["odaberiTipUtrke"]))
        { 
            $baza = new Baza(); 
           $baza->IzvrsiUpit("INSERT INTO utrka(naziv, zavrsetak_prijava, lokacija, tip_utrke, drzava) VALUES (?,?,?,?,?)", ("sssii"), [$_POST["Naziv"], $_POST["zavrsetakPrijava"],$_POST["Lokacija"], (int)$_POST["odaberiTipUtrke"], (int)$_POST["odaberiDrzavu"]], true);
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['azuriraj']))
    {
        var_dump("$_POST"); 
        if(!empty($_POST["idaz"]) && !empty($_POST["odaberiDrzavuaz"]) && !empty($_POST["odaberiTipaz"]) && !empty($_POST["novinaziv"]) && !empty($_POST["novizavrsetak"]) && !empty($_POST["novalokacija"]))
        { 
            $baza = new Baza(); 
           $baza->IzvrsiUpit("UPDATE utrka SET naziv = ? ,zavrsetak_prijava = ?,lokacija = ?, tip_utrke = ?,drzava = ? WHERE utrka.id_utrka = ?", ("sssiii"), [$_POST["novinaziv"], $_POST["novizavrsetak"],$_POST["novalokacija"], (int)$_POST["odaberiTipaz"], (int)$_POST["odaberiDrzavuaz"], (int)$_POST["idaz"]], true);
        }
        
    }
?>

 <?php
 ispisiPodnozje(); 
 ?>