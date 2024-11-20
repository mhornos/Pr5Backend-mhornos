<!-- Miguel Angel Hornos  -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// incloem el fitxer de esborrar que conté la funció esborrarArticle
require_once "../Model/esborrar.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // vinculem l'id del formulari a una variable
    $id = $_POST["id"] ?? null;

    // obtenim el usuari mediant la sessió
    $usuari = $_SESSION["usuari"] ?? null;

    // array per guardar els errors que es puguin produir durant la validació
    $errors = [];

    // si falta l'ID salta un error
    if (empty($id)) {
        $errors[] = "falta l'ID ❌";
    }

    // si no hi ha errors, modifiquem l'article cridant la funció modificarArticle
    if (empty($errors)) {
        esborrarArticle($id,$usuari);
    }

    // mostrem tots els errors trobats en el procés de validació
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }

}
?>

<?php
include_once "../Vistes/Esborrar.php";
?>