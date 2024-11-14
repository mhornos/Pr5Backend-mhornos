<?php

try{
    $connexio = new PDO('mysql:host=localhost;dbname=pt05_miguel_hornos', 'root', ''); 
    $connexio->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
    // en cas d'error de connexió mostrem el missatge d'error
    echo "error de connexió: " . $e->getMessage() . " ❌";    
}  


?>