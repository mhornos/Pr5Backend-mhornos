<!-- Miguel Angel Hornos -->

<?php
//destruim la sessió y redirigim a inici
session_start();
session_unset();
session_destroy();
header("Location: ../Index.php");
exit;
?>
