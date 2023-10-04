<?php

require_once "baza.php"; 

if (isset($_POST["prijaviSe"])) 
{
    if (empty($_SERVER['HTTPS'])) 
    {
       header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/prijava.php');
       exit;
    }
    else
    {
    $neispravnosti = "";
    
    foreach ($_POST as $key => $value) 
   {
       if ($key == "korsnickoime" && empty($value)) 
       {
           $neispravnosti.= "Morate upisati krisničko ime. <br>";
       }
       
       if ($key == "lozinka" && empty($value)) 
       {
           $neispravnosti.= "Morate upisati lozinku. <br>";
       }
   }
   
   if (empty($neispravnosti)) 
   {
       $uloga=""; 
       $baza = new Baza();
               
       $rezultat = $baza->IzvrsiUpit("SELECT * FROM korisnik WHERE korisnicko_ime = ?", "s", [$_POST["korsnickoime"]])[0];

       if ($rezultat["status_korisnika"] === 0)
       {
            echo "Vaš račun je blokiran! ";
            exit; 
       }

        if( $rezultat["lozinka"] !== $_POST["lozinka"] )
        { 
            $neuspjelo = $rezultat["broj_neuspjesnih_prijava"]+1; 
            if(($rezultat["broj_neuspjesnih_prijava"]+1) === 3 )
            {     
                echo " Neuspješna prijava, vaš račun je blokiran!"; 
                $updateStatusa = $baza->IzvrsiUpit("UPDATE korisnik SET status_korisnika = ? , broj_neuspjesnih_prijava = ? WHERE id_korisnik = ?", ("iii"), [0, $neuspjelo, $rezultat["id_korisnik"]],true); 
                exit; 
                header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/prijava.php');
            }
            else 
            {
                echo " Neuspješna prijava!"; 
                $updateStatusa = $baza->IzvrsiUpit("UPDATE korisnik SET broj_neuspjesnih_prijava = ? WHERE id_korisnik = ?", ("ii"), [$neuspjelo, $rezultat["id_korisnik"]], true); 
                exit; 
                header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/prijava.php');
            }
            exit; 
        }

        if ($rezultat != null) 
        {
            $uloga = $rezultat["tip_korisnika"]; 
        }
        if(!empty($uloga) && $_POST["upamti"] == "DA")
        {
            setcookie("zapamtiMe", $_POST["korsnickoime"], false, "/", false);
        }
        else
        {
            unset($_COOKIE['zapamtiMe']);
            setcookie("zapamtiMe", "", time() - 300,"/");
        }
        
        if (!empty($uloga)) 
        {
            session_start(); 
            session_regenerate_id(); 
            $_SESSION["korsnickoime"] = $_POST["korsnickoime"];
            $_SESSION["uloga"] = $uloga;
            $_SESSION["email"] = $rezultat["email"];
            $_SESSION["id_korisnik"] = $rezultat["id_korisnik"]; 

            header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/index.php');
            $updateNeuspjesnihPrijava = $baza->IzvrsiUpit("UPDATE korisnik SET broj_neuspjesnih_prijava = ? WHERE id_korisnik = ?", ("ii"), [0, $rezultat["id_korisnik"]]);
            exit;
        }
        else 
        {
            echo "<p style = 'color: red'>$neispravnosti</p>"; 
        }
    }
    }
}

$naslov = "Prijava"; 
require_once "osnovno.php"; 

?>
    <main id = "sredina">           
        <form novalidate id="form1" method="POST" name="form2" action="prijava.php">
            <fieldset class="registracija-prijava">
            <legend class="legenda">Prijava</legend>    
            <div>
                <label for="korisnickoime">Korisničko ime: </label><br> 
                <input  type="text" id="korisnickoime" name="korsnickoime" size="20" maxlength="30" required="required" value = "<?php echo htmlspecialchars(@$_COOKIE["zapamtiMe"])?>"><br><br> 
                
                <label for="lozinka">Lozinka: </label><br> 
                <input type="password" id="lozinka" name="lozinka" size="20" maxlength="30" required="required"><br>

                <input id="chbox" type="checkbox" name="upamti" value="DA"> 
                <label for="chbox">Zapamti me</label><br>
                
                <input  class="gumb" name="prijaviSe" type="submit" value="Prijavi se" >
                <input  class="gumb" name="zaboravljenaLozinka" type="submit" value="Zaboravljena lozinka" >
            </div>
            </fieldset>
        </form>
        <style>
        footer{
            position: fixed;
        }
    </style> 
<?php
 ispisiPodnozje(); 



 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['zaboravljenaLozinka']))
 {
    $baza = new Baza();  
    if (isset($_POST["korsnickoime"]))    
    {    
    $rezultat = $baza->IzvrsiUpit("SELECT * FROM korisnik WHERE korisnik.korisnicko_ime = ?", "s", [$_POST["korsnickoime"]])[0];
     $korisnikovMail =  $rezultat["email"]; 
     var_dump($rezultat);
      function GenerirajNovuLozinku()
     {
         $mogucnosti = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $novaLozinka= '';
         $duzinaLozinke = rand(8,20); 
     
         for ($i = 0; $i < $duzinaLozinke; $i++) 
         {
             $jedan = rand(0, strlen($mogucnosti) - 1);
             $novaLozinka .= $mogucnosti[$jedan];
         }
         return $novaLozinka;
     }

       $novaLozinka = GenerirajNovuLozinku(); 
       $mail_to = "$korisnikovMail"; 
       $mail_from = "From: noreplay@barka.foi.hr";
       $mail_subject = 'Dodjela nove lozinke';
       $mail_body = "$novaLozinka";

       $sol = hash("sha256", random_bytes(25)); 
       $lozinkaSHA256 = hash( "sha256", $novaLozinka. $sol); 
       if (mail($mail_to, $mail_subject, $mail_body, $mail_from ) === true )
       {
         $baza = new Baza();
         $updateLozinke = $baza->IzvrsiUpit("UPDATE korisnik SET lozinka = ? , lozinka_sha256 = ? WHERE id_korisnik = ?", "ssi", [$novaLozinka, $lozinkaSHA256 ,$rezultat["id_korisnik"]], true); 
         header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/prijava.php');
            exit; 
        } 
       else 
       {
            header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/index.php');
            exit; 
        }
    }
 }
 ?>