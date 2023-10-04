<?php

    include_once "baza.php";
    $baza = new Baza(); 

    // Check username is already exists in database

    $korime = $_POST['korisnickoime'];
    $email = $_POST['email'];
    $rezultat = ""; 
    $rezultat = $baza->IzvrsiUpit("SELECT * FROM korisnik WHERE username = ? || email = ?", "ss", [$korime, $email]);
    
    if (!empty($rezultat)) 
    {
        echo 1;
    }
    else
    {
      echo 0;
    } 

?>