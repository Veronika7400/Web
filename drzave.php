<?php
$naslov = "Države"; 
require_once "osnovno.php"; 

require_once "baza.php"; 
$baza = new Baza(); 

$rezultat = $baza->IzvrsiUpit("SELECT d.id_drzava, d.naziv from drzava as d"); 
$drzave = $baza->IzvrsiUpit("SELECT * from drzava as d"); 
$moderatori = $baza->IzvrsiUpit("SELECT k.id_korisnik as id_moderatora, k.korisnicko_ime from korisnik as k where k.tip_korisnika =?",("i"), [2]); 
?>
<main id = "sredina">  
        <?php
            echo "
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz država</legend>  
            <table>
            <tr>
                <th>Id države</th>
                <th>Naziv</th>
             </tr>"; 
                foreach($rezultat as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["id_drzava"]}</td>   
                        <td>{$value["naziv"]}</td>                                                            
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>
            
            <form action = 'drzave.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Kreiranje države</legend>  
            <label for='Naziv'>Naziv: </label><br> 
            <input type='text' id='Naziv' name='Naziv'><br>
            <input  class='gumb'  type='submit' name='kreiraj'  value='Kreiraj novu državu'>
            </fieldset>
            </form>

            <form action = 'drzave.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Ažuriranje države</legend>  

            <label for='id'>Odaberite državu:</label>
                <select name='id' id='id'>";

                foreach($drzave as $key => $value)
                {
                    echo "<option value={$value["id_drzava"]}>{$value["naziv"]}</option>"; 
                }

            echo"
            </select> 
            <br><br>
            <label for='naziv'>Novi naziv: </label><br> 
            <input type='text' id='naziv' name='naziv'><br>
            <input  class='gumb'  type='submit' name='azuriraj' value='Ažuriraj državu'>
            </fieldset>
            </form>

            <form action = 'drzave.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Dodavanje moderatora</legend>  
            
            <label for='odabirModeratora'>Odaberite moderatora:</label>
                <select name='odabirModeratora' id='odabirModeratora'>";

                foreach($moderatori as $key => $value)
                {
                    echo "<option value={$value["id_moderatora"]}>{$value["korisnicko_ime"]}</option>"; 
                }

            echo"
            </select> 
            <br><br>
            <label for='odabirDrzave'>Odaberite državu:</label>
            <select name='odabirDrzave' id='odabirDrzave'>";

            foreach($drzave as $key => $value)
            {
                echo "<option value={$value["id_drzava"]}>{$value["naziv"]}</option>"; 
            }

            echo"
            </select> 
            <br><br>
            <input  class='gumb'  type='submit' name='dodijeli'  value='Dodijeli moderatora'>
            </fieldset>
            </form>
            "; 
        ?>

    </form>  
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dodijeli']))
    {
        $baza = new Baza(); 
        $dodjela = $baza->IzvrsiUpit("INSERT INTO moderatori(id_korisnik, id_drzava) VALUES (?,?)", ("ii"), [$_POST["odabirModeratora"], $_POST["odabirDrzave"]], true);
        exit;
         header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/drzave.php');
    }
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['kreiraj']))
    {
        $baza = new Baza(); 
        if(!empty($_POST["Naziv"]))
        {
            $rezultat = $baza->IzvrsiUpit("INSERT INTO drzava(naziv) VALUES (?)", ("s"), [$_POST["Naziv"]], true);
        }
        exit;
       header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/drzave.php');
    }

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['azuriraj']))
    {
        $baza = new Baza(); 
        if(!empty($_POST["id"]) && !empty($_POST["naziv"]) )
        {
            $rezultat = $baza->IzvrsiUpit("UPDATE drzava SET naziv = ?  WHERE id_drzava = ?", ("si"), [$_POST["naziv"], $_POST["id"]], true);
        }
        exit;
       header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/drzave.php');
    }
    ?>
 <?php
 ispisiPodnozje(); 
 ?>