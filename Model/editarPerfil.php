
<?php
// Miguel Angel Hornos Granda

//editar les dades del usuari a la bd
function editarUsuari($usuari, $correu, $ciutat, $imatge){
    try {
        require "connexio.php";

        $usuariOriginal = $_SESSION['usuari'];

        // comprovem si el nom d'usuari ja existeix excloent l'actual
        $consultaExistenciaUsuari = $connexio->prepare("SELECT * FROM usuaris WHERE nombreUsuario = :usuari AND nombreUsuario != :usuariOriginal");
        $consultaExistenciaUsuari->bindParam(':usuari', $usuari);
        $consultaExistenciaUsuari->bindParam(':usuariOriginal', $usuariOriginal);
        $consultaExistenciaUsuari->execute();
        if ($consultaExistenciaUsuari->rowCount() > 0) {
            $errors[] = "el nom d'usuari ja existeix ❌";
        }

        // comprovem si el correu ja existeix excloent l'actual
        $consultaExistenciaCorreu = $connexio->prepare("SELECT * FROM usuaris WHERE correo = :correu AND nombreUsuario != :usuariOriginal");
        $consultaExistenciaCorreu->bindParam(':correu', $correu);
        $consultaExistenciaCorreu->bindParam(':usuariOriginal', $usuariOriginal);
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

        //si no hi ha errors editem l'usuari
        $consulta = $connexio->prepare("UPDATE usuaris SET correo = :correu, ciutat = :ciutat, imatge = :imatge WHERE nombreUsuario = :usuari");
        $consulta->bindParam(':usuari', $usuari);
        $consulta->bindParam(':correu', $correu);
        $consulta->bindParam(':ciutat', $ciutat);
        $consulta->bindParam(':imatge', $imatge);

        if ($consulta->execute()) {
            echo "usuario editat correctament ✅";
        } else {
            echo "no s'ha pogut editar l'usuari ❌";
        }
    } catch (PDOException $e) {
        echo "error al editar l'usuari: " . $e->getMessage() . " ❌";
    }
}

//retorna el correu del usuari actual
function obtenirCorreu($usuari){
    try {
        require "connexio.php";

        $consulta = $connexio->prepare("SELECT correo FROM usuaris WHERE nombreUsuario = :usuari");
        $consulta->bindParam(':usuari', $usuari);
        $consulta->execute();
        $correu = $consulta->fetchColumn();

        if ($correu) {
            return $correu;
        } else {
            return "el usuari no existeix ❌";
        }
    } catch (PDOException $e) {
        return "error al obtenir el correu: " . $e->getMessage() . " ❌";
    }
}

//retorna la ciutat del usuari actual
function obtenirCiutat($usuari){
    try {
        require "connexio.php";

        $consulta = $connexio->prepare("SELECT ciutat FROM usuaris WHERE nombreUsuario = :usuari");
        $consulta->bindParam(':usuari', $usuari);
        $consulta->execute();
        $ciutat = $consulta->fetchColumn();

        if ($ciutat) {
            return $ciutat;
        } else {
            return "el usuari no existeix ❌";
        }
    } catch (PDOException $e) {
        return "error al obtenir la ciutat: " . $e->getMessage() . " ❌";
    }
}

//retorna la imatge del usuari actual
function obtenirImatge($usuari){
    try {
        require "connexio.php";

        $consulta = $connexio->prepare("SELECT imatge FROM usuaris WHERE nombreUsuario = :usuari");
        $consulta->bindParam(':usuari', $usuari);
        $consulta->execute();
        $imatge = $consulta->fetchColumn();

        if ($imatge) {
            return $imatge;
        }if($imatge == "") {
            return "imgs/senseFoto.png"; 
        }
    } catch (PDOException $e) {
        return "imgs/senseFoto.png"; 
        }
}

?>