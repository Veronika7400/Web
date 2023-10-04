<?php
$naslov = "Registracija"; 
require_once "osnovno.php"; 

$neispravnosti=""; 
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['registrirajSe']))
{
    $name = $_POST['korsnickoime'];
    $recaptcha = $_POST['g-recaptcha-response'];
  
    $secret_key = '6LcDjWwgAAAAALBedSaWo0bq-7MwFVrP7vTLFXlI';
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;
 
    $response = file_get_contents($url);
    $response = json_decode($response);
 
    if ($response->success != true) 
    {
        $neispravnosti .= "Google reCAPTACHA error";
    } 

    if(!isset($_POST['ime']) || !isset($_POST['prezime']) || !isset($_POST['email']) || !isset($_POST['korsnickoime']) || !isset($_POST['lozinka1']) || !isset($_POST['lozinka2']))
    {
        $neispravnosti .="Svi elementi moraju biti uneseni"; 
    }
    else 
    {
        foreach($_POST as $key => $value)
        {
            switch($key)
            {
                case 'ime':
                {
                    if($value[0] !== strtoupper($value[0]))
                    {
                        $neispravnosti .="Prvo slovo imena mora biti veliko slovo. <br>"; 
                    }
                    break; 
                }
                case 'prezime':
                {
                    if($value[0] !== strtoupper($value[0]))
                    {
                        $neispravnosti .="Prvo slovo prezimena mora biti veliko slovo. <br>"; 
                    }
                    break; 
                }
                case 'email':
                {
                    if (strpos($value,"@") === false || strpos($value,".") === false )
                    $neispravnosti .="Neispravan format email adrese. <br>";
                    break; 
                }
                case 'korsnickoime':
                {
                    if (strlen($value) < 5 || strlen($value)>45)
                    {
                        $neispravnosti .="Korisničko ime nije ispravne dužine. <br>"; 
                    }
                    break; 
                }
                case 'lozinka1':
                {
                    if(str_contains($value,"!"))
                        $neispravnosti .="Lozinka ne smije sadržavati znak !. <br>";
                    if(str_contains($value,"?"))
                        $neispravnosti .="Lozinka ne smije sadržavati znak ?. <br>";
                    if(str_contains($value,"<"))
                        $neispravnosti .="Lozinka ne smije sadržavati znak <. <br>";
                    if(str_contains($value,">"))
                        $neispravnosti .="Lozinka ne smije sadržavati znak >. <br>";
                    if(str_contains($value,"%"))
                        $neispravnosti .="Lozinka ne smije sadržavati znak %. <br>";
                    if(str_contains($value,"#"))
                        $neispravnosti .="Lozinka ne smije sadržavati znak #. <br>";
                    if(str_contains($value,"&"))
                        $neispravnosti .="Lozinka ne smije sadržavati znak &. <br>";
                    $upisanaLozinka = $value; 
                    break; 
                }
                case 'lozinka2':
                {
                    if($value !== $_POST["lozinka1"])
                    {
                        $neispravnosti .="Lozinke nisu identične. <br>";
                    }
                    break; 
                }
            }
        } 
    }
    function GenerirajAktivacijskiKod()
    {
        $mogucnosti = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $kod = '';
    
        for ($i = 0; $i < 6; $i++) 
        {
            $jedan = rand(0, strlen($mogucnosti) - 1);
            $kod .= $mogucnosti[$jedan];
        }
        return $kod;
    }

    if (empty($neispravnosti))
    {
        require_once "baza.php"; 
        $baza = new Baza(); 
        $sol = hash("sha256", random_bytes(25)); 
        $lozinka_sha256 = hash( "sha256", @$_POST["lozinka1"]. $sol); 

        $aktivacijski_kod = GenerirajAktivacijskiKod(); 
        $tip = 3; 
        $baza->IzvrsiUpit("INSERT INTO korisnik(ime, prezime, korisnicko_ime, lozinka, lozinka_sha256, aktivacijski_kod, email, broj_neuspjesnih_prijava, uvjeti_koristenja, status_korisnika, bodovi, tip_korisnika) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)", ("sssssssisiii"), [$_POST["ime"], $_POST["prezime"],$_POST["korsnickoime"], $_POST["lozinka1"], $lozinka_sha256, $aktivacijski_kod, $_POST[ "email"], 0, null, 1, 0, 3]); 
    }
}
?>
<?php

    echo"   
    <main id = 'sredina'>          
            <form id = 'form1' action = 'registracija.php' method ='POST'>
                <fieldset class='registracija-prijava'>
                <legend class='legenda'>Registracija</legend> 
                    <label for='ime'>Ime: </label><br> 
                    <input type='text' id='ime' name='ime' size='20' maxlength='50' autofocus='autofocus' required='required'><br><br> 
                    
                    <label for='prezime'>Prezime: </label><br> 
                    <input type='text' id='prezime' name='prezime' size='20' maxlength='50' autofocus='autofocus' required='required'><br><br> 
                    
                    <label for='email'>E-mail adresa: </label><br> 
                    <input type='email' id='email' name='email' size='20' maxlength='40' placeholder='ldap@foi.hr' required='required'><br> <br>
                    <span id='message' style='color:red'></span>
                     
                    <label for='korsnickoime'>Korisničko ime: </label><br> 
                    <input type='text' id='korsnickoime' name='korsnickoime' size='20' maxlength='25' required='required'><br><br> 
                    <span id='message' style='color:red'></span>
                    
                    <label for='lozinka1'>Lozinka: </label><br> 
                    <input type='password' id='lozinka1' name='lozinka1' size='20' maxlength='50' required='required'><br><br> 
                    
                    <label for='lozinka2'>Potvrda lozinke: </label><br> 
                    <input type='password' id='lozinka2' name='lozinka2' size='20' maxlength='50' ><br><br>          

                    <label>Dozvole korištenja kolačića: </label><br>
                    <input type='checkbox' id='kolacici1' name='kolacici1' checked required='required'>    
                    <label for='kolacici1'>Nužni </label><br>  
                    <input type='checkbox' id='kolacici2' name='kolacici2'>     
                    <label for='kolacici2'>Marketinški </label><br>   
                    <input type='checkbox' id='kolacici3' name='kolacici3'>        
                    <label for='kolacici3'>Analitički </label><br><br>  

                    <div class='g-recaptcha' style = 'text-align: center;' data-sitekey='6LcDjWwgAAAAADjzTbjDDOb-KwnoUX0mfHSaZS4r'></div>
                    <input class='gumb' type='submit' name='registrirajSe' value='Registriraj se'>
                </fieldset>
            </form> ";

                    if (!empty($neispravnosti))
                    {
                        echo "<p style = 'grid-column: 1 / span 2; color:red'>{$neispravnosti}</p>"; 
                    }

 ispisiPodnozje(); 
 ?>