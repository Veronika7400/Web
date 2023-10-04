<?php

class Baza {
    const server = "localhost";
    const korisnik = "WebDiP2021x114";
    const lozinka = "admin_phHV";
    const baza = "WebDiP2021x114";

    private $veza = null;
    private $greska = '';


    public function __construct()
    {
        $this->veza =new mysqli(self::server, self::korisnik, self::lozinka, self::baza);;
    }

    public function __destruct()
    {
        $this->veza->close(); 
    }
    
    public function IzvrsiUpit($upit, string $vrsteArfumenta = '', array $argumenti = [], bool $naredba = false)
    {
        $pripremljeniUpit = $this->veza->prepare($upit); 
        if(!empty($vrsteArfumenta))
        {
            $pripremljeniUpit->bind_param($vrsteArfumenta, ...$argumenti); 
        }

        $pripremljeniUpit->execute(); 

        if($naredba == false)
        {
            return $pripremljeniUpit->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        else 
        {
            return $this->veza->insert_id; 
        }
    }
}
?>