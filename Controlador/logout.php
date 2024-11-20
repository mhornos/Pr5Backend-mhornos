<!-- Miguel Angel Hornos -->

<?php
require_once "cookies.php";

//destruim la sessió y redirigim a inici
session_start();
session_unset();
session_destroy();
eliminarCookie("usuari");
header("Location: ../Index.php");
exit;
?>
