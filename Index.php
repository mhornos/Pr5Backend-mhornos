<!-- Miguel Ángel Hornos -->
 
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "Controlador/gestioSessio.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>mhornos</title>
        <link rel="stylesheet" href="Estils\estils.css">
    </head>
    <body>
        <h1>MECÀNIC ADMIN DE GARATGES</h1><br>
    </body>
</html>

<?php
include_once "Controlador/cookies.php";
include_once "Vistes/navbar.php";
include_once "Model/mostrarLlista.php";
?>