<!-- Miguel Angel Hornos -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// definir el limit de inactivitat (40 minuts)
$limitInactiu = 40*60;

if (isset($_SESSION['usuari'])) {
    if (isset($_SESSION['last_activity'])) {
        $tempsInactiu = time() - $_SESSION['last_activity']; // temps d'inactivitat
        if ($tempsInactiu > $limitInactiu) {
            session_unset(); // netejar variables de sessió
            session_destroy(); // destruir la sessió
            require "cookies.php";
            eliminarCookie("usuari");

            // missatge que la sessió ha caducat
            echo "<script>
                alert('La sessió s\'ha tancat per inactivitat.');
                window.location.href = './Index.php'; // Redirigir a Index.php fora de Controlador
            </script>";
            
            exit();
        }
    }
}

// actualitzar el temps d'activitat
$_SESSION['last_activity'] = time();
?>
