<?php
session_start(); 

session_unset(); 
session_destroy(); 
header('Location: https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x114/index.php');
exit; 
?>