<?php

@session_start();

echo "
<!DOCTYPE html>
<html lang='hr'>
<head>
    <title>$naslov</title>
    <meta charset='UTF-8'>
    <meta name='header' content ='$naslov'> 
    <meta name='author' content='Veronika Tvrdy'/>
    <meta name='date' content='lipanj 2022.'/>
    <meta name='description' content='Trčanje'/>
    <meta name='keywords' content='Trčanje, Utrka, Etapa' />   
    ".(($naslov == "Registracija") ? " 
    </script> <script src='vtvrdy_javascript.js'></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>" : "")."

    <link rel='stylesheet' href='vtvrdy.css'>
</head>
<body>
    <header>
        <ul>
"; 

 echo"  
    <li><a href='index.php'><img src='materijali/logo.jpg' alt='logo' id ='slika_loga'></a></li>
    <li><a id = 'odabir_stranice' ". (($naslov == "Početna stranica") ? "class='active'" : "") . " href='index.php'>Početna stranica</a></li>
    <li><a id = 'odabir_stranice' href='o_autoru.html'>O autoru</a></li>
    <li><a id = 'odabir_stranice' href='dokumentacija.html'>Dokumentacija</a></li>
    <li><a id = 'odabir_stranice' ".(($naslov == "Prijava") ? "class='active'" : "")." href='prijava.php'>Prijava</a></li>
    <li><a id = 'odabir_stranice' ".(($naslov == "Registracija") ? "class='active'" : "")." href='registracija.php'>Registracija</a></li>
    ".
    ((isset($_SESSION["uloga"]) && $_SESSION["uloga"] == '1') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Države") ? "class='active'" : "")."href='drzave.php'>Države</a></li>" : "")
    ."   
    ".
    ((isset($_SESSION["uloga"]) && $_SESSION["uloga"] == '1') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Utrke trčanja") ? "class='active'" : "")."href='utrkeTrcanja.php'>Utrke trčanja</a></li>" : "")
    ."  
    ".
    ((isset($_SESSION["uloga"] )&& $_SESSION["uloga"] == '1') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Korisnički računi") ? "class='active'" : "")."href='korisnickiRacuni.php'>Korisnički računi</a></li>" : "")
    ."
    ".
    ((isset($_SESSION["uloga"]) && $_SESSION["uloga"] <= '3') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Prijava na utrku") ? "class='active'" : "")."href='prijavaNaUtrku.php'>Prijava na utrku</a></li>" : "")
    ."   
    ".
    ((isset($_SESSION["uloga"]) && $_SESSION["uloga"] <= '3') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Buduce utrke") ? "class='active'" : "")."href='buduceUtrke.php'>Buduce utrke</a></li>" : "")
    ." 
    ".
    ((isset($_SESSION["uloga"] )&& $_SESSION["uloga"] <= '2') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Statistika završenosti utrka") ? "class='active'" : "")."href='statistikaZavrsenostiUtrke.php'>Statistika završenosti utrka</a></li>" : "")
    ." 
    ".
    ((isset($_SESSION["uloga"] )&& $_SESSION["uloga"] <= '2') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Kreiranje etapa") ? "class='active'" : "")."href='crudEtapa.php'>Kreiranje etapa</a></li>" : "")
    ." 
    ".
    ((isset($_SESSION["uloga"]) && $_SESSION["uloga"] <= '2') ? "<li><a id = 'odabir_stranice' ".(($naslov == "Popis korisnika po etapi") ? "class='active'" : "")."href='korisniciPoEtapi.php'>Korisnici po etapi</a></li>" : "")
    ." 
    ".
    ((isset($_SESSION["uloga"]) && $_SESSION["uloga"] <= '3') ? "<li><a id = 'odabir_stranice' ".(($naslov == " Statistika završenosti mojih etapa") ? "class='active'" : "")."href='statistikaSvojihEtapa.php'> Statistika završenosti mojih etapa</a></li>" : "")
    ." 
    <li><a id = 'odabir_stranice' ".(($naslov == " Korisnici privatno") ? "class='active'" : "")." href='privatno/korisnici.php'>Korisnici</a></li>
    <li><a id = 'odabir_stranice' ".(($naslov == "Rang lista") ? "class='active'" : "")." href='rangLista.php'>Rang lista</a></li>
    <li><a id = 'odabir_stranice' ".(($naslov == "Galerija pobjednika") ? "class='active'" : "")." href='galerijaPobjednika.php'>Galerija pobjednika</a></li>
    ".
    (isset($_SESSION["korsnickoime"]) ? "<li><a id = 'odabir_stranice' href='odjava.php'>Odjava</a></li>" : "")
    ."    
    </ul>
    </header>"; 

function ispisiPodnozje()
{
  echo " 
  </main>
    <footer>
        <address style='padding-top: 7px; '>Kontakt: <a href='mailto:vtvrdy@foi.hr'>Veronika Tvrdy</a></address>
        <p>2022  &copy; </p>
    </footer>
    </body>
    </html>"; 
}
?>
