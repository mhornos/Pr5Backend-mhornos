<!-- Miguel Angel Hornos -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// incloem el fitxer de inserir que conté la funció insertArticle
require "../Model/inserir.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // obtenim les dades del formulari
    $marca = $_POST["marca"] ?? null;
    $model = $_POST["model"] ?? null;
    $color = $_POST["color"] ?? null;
    $matricula = $_POST["matricula"] ?? null;
    $imatge = $_POST["imatge"] ?? null;
    // obtenim el usuari mediant la sessió
    $usuari = $_SESSION["usuari"] ?? null;

    // array per guardar els errors que es puguin produir durant la validació
    $errors = [];

    // si algun dels camps és buit mostrem un missatge d'error
    if (empty($marca) || empty($model) || empty($color) || empty($matricula)) {
        $errors[] = "marca, model, color i matricula són obligatoris ❌";
    // comprovem si la matrícula té més de 12 dígits
    } else if (strlen($matricula) > 12) {
        $errors[] = "la matrícula no pot tenir més de 12 caràcters ❌";
    }

    // si no hi ha errors, creem l'article cridant la funció insertArticle
    if (empty($errors)) {
        insertArticle($marca, $model, $color, $matricula, $imatge, $usuari);
    }

    // mostrem tots els errors trobats en el procés de validació
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}
?>

<!-- tornem a mostrar el formulari amb les dades ja introduides per agilitzar el proces de repetir l'accio -->
<?php
include "../Vistes/Inserir.php";
?>