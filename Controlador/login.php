<!-- Miguel Angel Hornos -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../Model/login.php";
require "cookies.php";


// procesem el formulari de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuari = $_POST["usuari"] ?? null;
    $contrasenya = $_POST["contrasenya"] ?? null;

    $errors = [];

    if (empty($usuari)){
        $errors[] = "falta el nom d'usuari ❌";
    }
    if (empty($contrasenya)){
        $errors[] = "falta la contrasenya ❌";
    }

    // si no hi ha errors intentem iniciar sessió
    if(empty($errors)){
        if (iniciarSesio($usuari, $contrasenya)){
            $_SESSION["usuari"] = $usuari;  
            establirCookie("usuari", $usuari); 
            header("Location: ../Index.php");
            exit;
        } else {
            $errors[] = "nom d'usuari o contrasenya incorrectes ❌";
        }
    }

    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>

    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <br><h2>Inicia sessió:</h2>
    <br><form method="POST">
        <input type="text" name="usuari" placeholder="Usuari" value="<?php echo htmlspecialchars($usuari ?? ''); ?>">
        <input type="password" name="contrasenya" placeholder="Contrasenya" value="">
        <input type="submit" name="Login" value="Login">
        No tinc compte: <a href="Register.php"> Crea un compte </a>
    </form>

    <br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
        <button>Tornar a inici</button>
    </a><br>
</body>
</html>
