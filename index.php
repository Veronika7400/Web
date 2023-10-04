<?php
$naslov = "Početna stranica"; 
require_once "osnovno.php"; 

?>
   <main id="sadrzaj">

    <div id="animacijaOkvir">

      <fieldset id="animacije-fieldset">      
          
        <figure>
            <img src="materijali/Animacija4.jpg" alt="Running racetrack"/>
            <figcaption>Running racetrack</figcaption>
        </figure> 

        <figure>
            <img src="materijali/Animacija1.jpg" alt="Are you ready?"/>
            <figcaption>Are you ready?</figcaption>
        </figure>
        
        <figure>
            <img src="materijali/Animacija2.jpg" alt="Starting position"/>
            <figcaption>Starting position </figcaption>
        </figure>

        <figure>
            <img src="materijali/Animacija3.jpg" alt="Running race"/>
            <figcaption>Running race</figcaption>
        </figure> 
        
    </div>
 </fieldset>    
 <style>
        footer{
            position: fixed;
        }
    </style>   
 <?php
 ispisiPodnozje(); 
 ?>