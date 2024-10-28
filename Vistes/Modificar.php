<!-- Miguel Angel Hornos -->

<!-- pagina per començar a modificar articles a la bd -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>

    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <!-- formulario per omplir l'id i modificar el titol i el cos -->
    <h2>Modificar vechicle de la BD</h2><br>

    <form action="../Model/crud.php" method="post">
        <table>
        <label for="id">ID:  </label>    
        <input type="text" id="id" name="id" placeholder="Introdueix ID del vehicle a editar*">
        
            <label for="marca">Editar marca:  </label>    
            <input type="text" id="marca" name="marca" placeholder="Edita la marca">

            <label for="model">Editar model: </label>    
            <input type="text" id="model" name="model" placeholder="Edita el model">

            <label for="color">Editar color: </label>    
            <input type="text" id="color" name="color" placeholder="Edita el color">

            <label for="matricula">Editar matricula:  </label>    
            <input type="text" id="matricula" name="matricula" placeholder="Edita la matricula">

            <label for="imatge">Imatge del vehicle: </label>
            <input type="text" id="imatge" name="imatge" placeholder="Introdueix l'enllaç de la imatge">

            <input type="submit" value="Modificar" name="Enviar">
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