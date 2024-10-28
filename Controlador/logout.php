<!-- Miguel Angel Hornos -->

<?php
require "cookies.php";

//destruim la sessió y redirigim a inici
session_start();
session_destroy();
eliminarCookie("usuari");
header("Location: ../Index.php");
exit;
?>
