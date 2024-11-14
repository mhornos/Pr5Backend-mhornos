<!-- Miguel Angel Hornos Granda -->

<?php

function obtenirUsuariContrasenya($usuari){
        //ens conectem a la bd
        require "connexio.php";

        //fem la consulta sql
        $consulta = $connexio->prepare("SELECT contrasenya FROM usuaris WHERE nombreUsuario = :usuari");
        $consulta->bindParam(":usuari", $usuari);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC); 
}

function canviarContrasenya($usuari, $novaContrasenya){
    try{
        //ens conectem a la bd
        require "connexio.php";

        //fem la consulta sql
        $novaContrasenyaEncriptada = password_hash($novaContrasenya, PASSWORD_DEFAULT);

        $consulta = $connexio->prepare("UPDATE usuaris SET contrasenya = :novaContrasenya WHERE nombreUsuario = :usuari");
        $consulta->bindParam(":novaContrasenya", $novaContrasenyaEncriptada);
        $consulta->bindParam(":usuari", $usuari);
        return $consulta->execute();    
    }catch (PDOException $e) {
        // en cas d'error de connexió mostrem el missatge d'error
        echo "Error de connexió: " . $e->getMessage() . " ❌";
        
    }
} 

?>