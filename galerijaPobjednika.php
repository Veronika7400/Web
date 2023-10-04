<?php
$naslov = "Galerija pobjednika"; 
require_once "osnovno.php"; 

require_once "baza.php"; 
$baza = new Baza(); 

$rezultat = $baza->IzvrsiUpit("SELECT k.ime, k.prezime, rez.naziv, rez.slika, rez.utrka, rez.bodovi from korisnik as k join (select noveEtape.naziv, noveEtape.utrka, p.slika, sum(p.bodovi) as bodovi, p.korisnik from prijava_etape as p join (SELECT e.id_etapa, naziviDrzava.naziv, naziviDrzava.utrka from etapa as e join (select d.naziv, u.naziv as utrka, u.id_utrka from drzava as d join utrka as u on d.id_drzava=u.drzava ) as naziviDrzava on naziviDrzava.id_utrka = e.utrka) as noveEtape on noveEtape.id_etapa = p.etapa GROUP BY noveEtape.utrka, noveEtape.naziv,  p.slika, p.korisnik ORDER BY  noveEtape.utrka, bodovi DESC) as rez on rez.korisnik = k.id_korisnik"); 
?>
<main id = "sredina">  
        <?php
            $baza = new Baza(); 
            $popisDrzava = $baza->IzvrsiUpit("select d.naziv from drzava as d join utrka as u on d.id_drzava = u.drzava group by d.naziv "); 
            
            echo "<h3>Filtriranje po državi</h3>
            <form action = 'galerijaPobjednika.php' method = 'post'>
                <label for='drzava'>Odaberite državu:</label>
                <select name='drzava' id='drzava'>";

                foreach($popisDrzava as $key => $value)
                {
                    echo "<option value={$value["naziv"]}>{$value["naziv"]}</option>"; 
                }

                echo"
                </select>
                <br>
                <input  class='gumb'  type='submit' name='filtriraj'  value='Filtriraj'>
                </form>"; 
        ?>

    </form>  

    <form action = "galerijaPobjednika.php" method = "post">
    <h3>Sortiranje </h3>
        <input  class="gumb"  type="submit" name="sortPoImenu"  value="Po imenu">
        <input  class="gumb"  type="submit" name="sortPoPrezimenu"  value="Po prezimenu">
    </form> 
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sortPoImenu']))
    {
        sortiraj_po_imenu();
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sortPoPrezimenu']))
    {
        sortiraj_po_prezimenu();
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['filtriraj']))
    {  

        $proslaUtrka=""; 
        foreach ($rezultat as $key => $value)
        {
            if($_POST["drzava"] == $value["naziv"])
            {
                if( $proslaUtrka=="")
                {
                    $proslaUtrka = $value["utrka"]; 
                    echo " 
                    <fieldset class='dokumentacija-fieldset'>
                    <legend class='legenda'>{$value["naziv"]}</legend>    
                    <div>
                    <img src='data:image/png;base64,".base64_encode($value["slika"])."'width='200' height='200'/>
                    <p>{$value["ime"]} {$value["prezime"]}</p>
                    <p> Prvo mjesto u utrci {$value["utrka"]}</p>
                    <p> Ostvareni bodovi: {$value["bodovi"]}</p>
                    </div>
                    </fieldset>"; 
                }
    
                if($proslaUtrka !== $value["utrka"]) 
                {
                    $proslaUtrka = $value["utrka"];  
                    echo " 
                    <fieldset class='dokumentacija-fieldset'>
                    <legend class='legenda'>{$value["naziv"]}</legend>    
                    <div>
                    <img src='data:image/png;base64,".base64_encode($value["slika"])."'width='200' height='200'/>
                    <p>{$value["ime"]} {$value["prezime"]}</p>
                    <p> Prvo mjesto u utrci {$value["utrka"]}</p>
                    <p> Ostvareni bodovi: {$value["bodovi"]}</p>
                    </div>
                    </fieldset>"; 
                }
            }
        }
    }
    else
    {
          Ispisi($rezultat); 
    }

        function sortiraj_po_imenu()
        {
            $baza = new Baza(); 
            $sortiranoPoImenu = $baza->IzvrsiUpit("SELECT k.ime, k.prezime, rez.naziv, rez.slika, rez.utrka, max(rez.bodovi) as bodovi from korisnik as k join (select noveEtape.naziv, noveEtape.utrka, p.slika, sum(p.bodovi) as bodovi, p.korisnik from prijava_etape as p join (SELECT e.id_etapa, naziviDrzava.naziv, naziviDrzava.utrka from etapa as e join (select d.naziv, u.naziv as utrka, u.id_utrka from drzava as d join utrka as u on d.id_drzava=u.drzava ) as naziviDrzava on naziviDrzava.id_utrka = e.utrka) as noveEtape on noveEtape.id_etapa = p.etapa GROUP BY noveEtape.utrka, noveEtape.naziv, p.slika, p.korisnik ORDER BY noveEtape.utrka, bodovi DESC) as rez on rez.korisnik = k.id_korisnik GROUP BY k.ime, k.prezime, rez.naziv, rez.slika, rez.utrka ORDER BY  rez.utrka, bodovi desc, k.ime "); 
            Ispisi($sortiranoPoImenu); 
        }; 

        function sortiraj_po_prezimenu()
        {
            $baza = new Baza(); 
            $sortiranoPoPrezimenu = $baza->IzvrsiUpit("SELECT k.ime, k.prezime, rez.naziv, rez.slika, rez.utrka, max(rez.bodovi) as bodovi from korisnik as k join (select noveEtape.naziv, noveEtape.utrka, p.slika, sum(p.bodovi) as bodovi, p.korisnik from prijava_etape as p join (SELECT e.id_etapa, naziviDrzava.naziv, naziviDrzava.utrka from etapa as e join (select d.naziv, u.naziv as utrka, u.id_utrka from drzava as d join utrka as u on d.id_drzava=u.drzava ) as naziviDrzava on naziviDrzava.id_utrka = e.utrka) as noveEtape on noveEtape.id_etapa = p.etapa GROUP BY noveEtape.utrka, noveEtape.naziv, p.slika, p.korisnik ORDER BY noveEtape.utrka, bodovi DESC) as rez on rez.korisnik = k.id_korisnik GROUP BY k.ime, k.prezime, rez.naziv, rez.slika, rez.utrka ORDER BY  rez.utrka, bodovi desc, k.prezime"); 
            Ispisi($sortiranoPoPrezimenu); 
        }; 

        function Ispisi($rezultat)
        {
            $proslaUtrka=""; 
            foreach ($rezultat as $key => $value)
            {
                if( $proslaUtrka=="")
                {
                    $proslaUtrka = $value["utrka"]; 
                    echo " 
                    <fieldset class='dokumentacija-fieldset'>
                    <legend class='legenda'>{$value["naziv"]}</legend>    
                    <div>
                    <img src='data:image/png;base64,".base64_encode($value["slika"])."'width='200' height='200'/>
                    <p>{$value["ime"]} {$value["prezime"]}</p>
                    <p> Prvo mjesto u utrci {$value["utrka"]}</p>
                    <p> Ostvareni bodovi: {$value["bodovi"]}</p>
                    </div>
                    </fieldset>"; 
                }

                if($proslaUtrka !== $value["utrka"]) 
                {
                    $proslaUtrka = $value["utrka"];  
                    echo " 
                    <fieldset class='dokumentacija-fieldset'>
                    <legend class='legenda'>{$value["naziv"]}</legend>    
                    <div>
                    <img src='data:image/png;base64,".base64_encode($value["slika"])."'width='200' height='200'/>
                    <p>{$value["ime"]} {$value["prezime"]}</p>
                    <p> Prvo mjesto u utrci {$value["utrka"]}</p>
                    <p> Ostvareni bodovi: {$value["bodovi"]}</p>
                    </div>
                    </fieldset>"; 
                }
            }
        }; 

    ?>
 <?php
 ispisiPodnozje(); 
 ?>