<!-- Miguel Ángel Hornos -->

<!-- pagina per començar a inserir articles a la bd -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>

    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <!-- formulari que demana les dades del vehicle per generar un article a la bd -->
    <h2>Inserir vehicle a la BD</h2><br>

    <form action="../Model/crud.php" method="post">
        <table>
            <label for="marca">Marca:  </label>    
            <input type="text" id="marca" name="marca" placeholder="Introdueix la marca del vehicle*">

            <label for="model">Model: </label>    
            <input type="text" id="model" name="model" placeholder="Introdueix el model del vehicle*">
            
            <label for="color">Color: </label>    
            <input type="text" id="color" name="color" placeholder="Introdueix el color del vehicle*">

            <label for="matricula">Matricula: </label>    
            <input type="text" id="matricula" name="matricula" placeholder="Introdueix la matricula del vehicle*">

            <label for="imatge">Imatge del vehicle: </label>
            <input type="text" id="imatge" name="imatge" placeholder="Introdueix l'enllaç de la imatge (opcional)">

            <input type="submit" value="Inserir" name="Enviar">
            <input type="reset" value="Buidar">
        </table>     

    </form>
<!-- botó per tornar a començar amb l'ultima pagina de la llista escollida-->
    <br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
        <button>Tornar a inici</button>
    </a><br>
</body>
</html>

<!-- mostra la llista d'articles a sota de tot -->
<?php
include "../Model/mostrarLlista.php";
?>