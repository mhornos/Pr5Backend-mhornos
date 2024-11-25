<!-- Miguel Angel Hornos  -->

<?php
// funció per registrar usuaris
function crearUsuari($usuari, $contrasenya, $correu, $ciutat) {
    try {
        $errors = [];

        // ens connectem amb la base de dades
        require "connexio.php";

        // comprovem si el nom d'usuari ja existeix
        $consultaExistenciaUsuari = $connexio->prepare("SELECT * FROM usuaris WHERE nombreUsuario = :usuari");
        $consultaExistenciaUsuari->bindParam(':usuari', $usuari);
        $consultaExistenciaUsuari->execute();
        if ($consultaExistenciaUsuari->rowCount() > 0) {
            $errors[] = "el nom d'usuari ja existeix ❌";
        }

        // comprovem si el correu ja existeix
        $consultaExistenciaCorreu = $connexio->prepare("SELECT * FROM usuaris WHERE correo = :correu");
        $consultaExistenciaCorreu->bindParam(':correu', $correu);
        $consultaExistenciaCorreu->execute();
        if ($consultaExistenciaCorreu->rowCount() > 0) {
            $errors[] = "ja hi ha un usuari vinculat a aquest correu ❌";
        }

        // si hi ha errors, els mostrem
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            return;
        }

        // si no existeix, creem el nou usuari
        $contrasenyaEncriptada = password_hash($contrasenya, PASSWORD_DEFAULT); 

        $insert = $connexio->prepare("INSERT INTO usuaris (nombreUsuario, contrasenya, correo, ciutat) VALUES (:usuari, :contrasenya, :correu, :ciutat)");
        $insert->bindParam(':usuari', $usuari);
        $insert->bindParam(':contrasenya', $contrasenyaEncriptada); 
        $insert->bindParam(':ciutat', $ciutat);
        $insert->bindParam(':correu', $correu);

        $insert->execute();

        echo "usuari creat correctament! ✅";
    } catch (PDOException $e) {
        echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}
?>
