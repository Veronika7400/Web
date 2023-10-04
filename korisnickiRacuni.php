<?php
$naslov = "Korisnički računi"; 
require_once "osnovno.php"; 

require_once "baza.php"; 
$baza = new Baza(); 

$rezultat = $baza->IzvrsiUpit("select * from korisnik as k where k.status_korisnika = 0"); 
$korisnici = $baza->IzvrsiUpit("select * from korisnik"); 
?>
<main id = "sredina">  
        <?php
            echo "
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz zaključanih korisničkih računa</legend>  
            <table>
            <tr>
                <th>Id korisnika</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Korisničko ime</th>
                <th>Email</th>
             </tr>"; 
                foreach($rezultat as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["id_korisnik"]}</td>   
                        <td>{$value["ime"]}</td>
                        <td>{$value["prezime"]}</td>
                        <td>{$value["korisnicko_ime"]}</td>
                        <td>{$value["email"]}</td>                                                                   
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>
            
            <form action = 'korisnickiRacuni.php' method = 'post'>
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Blokiranje / deblokiranje korisničkog računa</legend>  

            <label for='id'>Odaberite id korsničkog računa :</label>
                <select name='id' id='id'>";
                foreach($korisnici as $key => $value)
                {
                    echo "<option value={$value["id_korisnik"]}>{$value["id_korisnik"]}</option>"; 
                }

            echo"
            </select> 
            <br><br>
            <label for='status'>Odaberite status korsničkog računa:</label>
            <select name='status' status='status'>
            <option value=0>Blokiran</option>
            <option value=1>Aktivan</option>
            </select><br>
            <input  class='gumb'  type='submit' name='azuriraj'  value='Ažuriraj status'>
            "; 
        ?>

    </form>  
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['azuriraj']))
    { 
        $baza = new Baza(); 
        $baza->IzvrsiUpit("UPDATE korisnik SET status_korisnika = ?  WHERE id_korisnik = ?", ("ii"), [$_POST["status"], $_POST["id"]], true);
    }
    ?>
     <style>
        footer{
            position: fixed;
        }
    </style> 
 <?php
 ispisiPodnozje(); 
 ?>