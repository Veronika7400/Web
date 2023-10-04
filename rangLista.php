<?php
$naslov = "Rang lista"; 
require_once "osnovno.php"; 

include_once "baza.php";
$baza = new Baza(); 

?>
<main id = "sredina">     
    <h3>Filtriranje po datumu</h3>
    <form action = "rangLista.php" method = "post">
        <label for="datumOd">Datum od:</label>
        <input type="date" id="datumOd" name="datumOd"><br>
        <label for="datumDo">Datum do:</label>
        <input type="date" id="datumDo" name="datumDo"><br>
        <input  class="gumb"  type="submit" name="filtriraj"  value="Filtriraj">
    </form>
<?php

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['filtriraj']))
    {
        filtriranje_po_datumu();
    }
    else 
    {
        $sve = $baza->IzvrsiUpit("SELECT k.ime, k.prezime, COUNT(*) as zavrseno from korisnik as k join prijava_etape as pe on pe.korisnik = k.id_korisnik where pe.odustao = 0 GROUP BY pe.korisnik ORDER BY zavrseno DESC "); 
            echo "
            <main id = 'sredina'>  
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz liste korisnika prema broju završenih etapa </legend>  
            <table>
            <tr>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Broj završenih etapa</th>
             </tr>"; 
             
                foreach($sve as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["ime"]}</td>   
                        <td>{$value["prezime"]}</td>
                        <td>{$value["zavrseno"]}</td>                                                            
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>" ; 
    }

    function filtriranje_po_datumu()
    {
        if(isset($_POST["datumOd"]) && isset($_POST["datumDo"]))
        {
            $baza = new Baza(); 
            $filtrirano = $baza->IzvrsiUpit("SELECT k.ime, k.prezime, COUNT(*) as zavrseno from korisnik as k join prijava_etape as pe on pe.korisnik = k.id_korisnik join etapa as e on pe.etapa = e.id_etapa where pe.odustao = 0 and e.datum >= ? and e.datum <= ? GROUP BY pe.korisnik ORDER BY zavrseno DESC", ("ss"), [$_POST["datumOd"] , $_POST["datumDo"]]);
            echo "
            <main id = 'sredina'>  
            <fieldset class='registracija-prijava'>
            <legend class='legenda'>Prikaz liste korisnika prema broju završenih etapa </legend>  
            <table>
            <tr>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Broj završenih etapa</th>
             </tr>"; 
             
                foreach($filtrirano as $key => $value)
                {
                    echo "
                    <tr>
                        <td>{$value["ime"]}</td>   
                        <td>{$value["prezime"]}</td>
                        <td>{$value["zavrseno"]}</td>                                                            
                    </tr> 
                    "; 
                }
            echo "
            </table>
            </fieldset>" ; 
        }
    }
?>
 
 <?php
 ispisiPodnozje(); 
 ?>