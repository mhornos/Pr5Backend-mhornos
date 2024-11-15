<!-- Miguel Angel Hornos Granda -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Eliminación</title>
    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <div class="overlay"></div> 
    <div class="contenidor-formulari">
        <h2>Estàs segur que vols eliminar l'article amb ID <?php echo htmlspecialchars($id); ?>?</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="hidden" name="Enviar" value="Eliminar">
            <div class="buttons-container">
                <input type="submit" name="confirmar" value="Si" class="confirm-btn">
                <input type="submit" name="confirmar" value="No" class="cancel-btn">
            </div>
        </form>
        <br>
        <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button class="back-btn">Tornar a inici</button>
        </a>
    </div>
</body> 
</html>
