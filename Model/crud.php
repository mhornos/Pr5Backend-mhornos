<!-- Miguel Angel Hornos -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// assignem la variable '$enviar' amb el valor que es troba al formulari al camp "Enviar"
$enviar = $_POST["Enviar"] ?? null;

try{
    // ens connectem amb la base de dades
    $connexio = new PDO('mysql:host=localhost;dbname=pt05_miguel_hornos', 'root', '');  
    
    // iniciem el switch per detectar l'acció a realitzar segons el valor de '$enviar'
    switch ($enviar) {
        case "Inserir":
            // obtenim les dades del formulari
            $marca = $_POST["marca"] ?? null;
            $model = $_POST["model"] ?? null;
            $color = $_POST["color"] ?? null;
            $matricula = $_POST["matricula"] ?? null;
            $imatge = $_POST["imatge"] ?? null;
        
            // obtenim el usuari mediant la sessió
            $usuari = $_SESSION["usuari"] ?? null;
        
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // verifiquem si la matrícula ja existeix a la base de dades
                $consultaMatricula = $connexio->prepare("SELECT COUNT(*) FROM article WHERE matricula = :matricula");
                $consultaMatricula->bindParam(':matricula', $matricula);
                $consultaMatricula->execute();
                $matriculaExisteix = $consultaMatricula->fetchColumn();
        
                // si algun dels camps és buit mostrem un missatge d'error
                if (empty($marca) || empty($model) || empty($color) || empty($matricula)) {
                    echo "marca, model, color i matricula són obligatoris ❌";
                // comprovem si la matrícula ja existeix
                } else if ($matriculaExisteix > 0) {
                    echo "la matrícula '" . htmlspecialchars($matricula) . "' ja existeix ❌";
                // comprovem si la matrícula té més de 12 dígits
                } else if (strlen($matricula) > 12) {
                    echo "la matrícula no pot tenir més de 12 caràcters ❌";
                } else {    
                    // preparem la consulta per inserir l'article a la base de dades
                    $consultaInsert = $connexio->prepare("INSERT INTO article (marca, model, color, matricula, nom_usuari, imatge) 
                                                            VALUES (:marca, :model, :color, :matricula, :nom_usuari, :imatge)");
                    $consultaInsert->bindParam(':marca', $marca);
                    $consultaInsert->bindParam(':model', $model);
                    $consultaInsert->bindParam(':color', $color);
                    $consultaInsert->bindParam(':matricula', $matricula);
                    $consultaInsert->bindParam(':nom_usuari', $usuari);
                    $consultaInsert->bindParam(':imatge', $imatge);
        
                    // si tot està correcte executem la consulta i mostrem un missatge d'èxit
                    if ($consultaInsert->execute()) {
                        $ultimId = $connexio->lastInsertId();
                        echo "article amb ID " . $ultimId . " inserit correctament ✅";
                    } else {
                        echo "error al inserir article ❌";
                    }
                }
            }
            break;
    
        case "Modificar":
            // obtenim la informacio del formulari
            $id = $_POST["id"] ?? null;
            $marca = $_POST["marca"] ?? null;
            $model = $_POST["model"] ?? null;
            $color = $_POST["color"] ?? null;
            $matricula = $_POST["matricula"] ?? null;
            $imatge = $_POST["imatge"] ?? null;
        
            // obtenim el nom de l'usuari de la sessió
            $usuari = $_SESSION["usuari"] ?? null;
        
            // si falta l'id mostrem un missatge d'error
            if (empty($id)) {
                echo "falta l'ID ❌";
                break;
            // si la matrícula té més de 12 dígits mostrem missatge d'error
            } else if (strlen($matricula) > 12) {
                echo "la matrícula no pot tenir més de 12 caràcters ❌";
                break;
            }
        
            // verifiquem si la nova matrícula ja existeix en un altre article
            $consultaMatricula = $connexio->prepare("SELECT COUNT(*) FROM article WHERE matricula = :matricula AND id != :id");
            $consultaMatricula->bindParam(':matricula', $matricula);
            $consultaMatricula->bindParam(':id', $id);
            $consultaMatricula->execute();
            $matriculaExisteix = $consultaMatricula->fetchColumn();
        
            // si la matrícula ja existeix en un altre article mostrem error
            if ($matriculaExisteix > 0) {
                echo "la matrícula '" . htmlspecialchars($matricula) . "' ja existeix en un altre article ❌";
                break;
            }
        
            // comprovem si existeix un article amb aquest id a la base de dades
            $consultaExistencia = $connexio->prepare("SELECT nom_usuari FROM article WHERE id = :id");
            $consultaExistencia->bindParam(':id', $id);
            $consultaExistencia->execute();
        
            // si no hi ha cap article amb aquest id mostrem un error
            if ($consultaExistencia->rowCount() == 0) {
                echo "no s'ha trobat cap article amb aquest ID ❌";
                break;
            }
        
            // Obtenim l'usuari creador de l'article
            $article = $consultaExistencia->fetch(PDO::FETCH_ASSOC);
            $usuariCreador = $article['nom_usuari'];
        
            // comprovem si l'usuari de la sessió és el mateix que el creador de l'article
            if ($usuari !== $usuariCreador) {
                echo "no tens permís per modificar aquest article ❌";
                break;
            }
        
            // comencem a construir la consulta per modificar l'article
            $modificarDades = "UPDATE article SET ";
            $primeraModificacio = true;
        
            // si s'omple la marca l'afegim a la consulta
            if (!empty($marca)) {
                if (!$primeraModificacio) {
                    $modificarDades .= ", ";
                }
                $modificarDades .= "marca = :marca";
                $primeraModificacio = false;
            }
        
            // si s'omple el model l'afegim a la consulta
            if (!empty($model)) {
                if (!$primeraModificacio) {
                    $modificarDades .= ", ";
                }
                $modificarDades .= "model = :model";
                $primeraModificacio = false;
            }
            // si s'omple el color l'afegim a la consulta
            if (!empty($color)) {
                if (!$primeraModificacio) {
                    $modificarDades .= ", ";
                }
                $modificarDades .= "color = :color";
                $primeraModificacio = false;
            }
            // si s'omple la matricula l'afegim a la consulta
            if (!empty($matricula)) {
                if (!$primeraModificacio) {
                    $modificarDades .= ", ";
                }
                $modificarDades .= "matricula = :matricula";
                $primeraModificacio = false;
            }
            // si s'omple la imatge l'afegim a la consulta
            if (!empty($imatge)) {
                if (!$primeraModificacio) {
                    $modificarDades .= ", ";
                }
                $modificarDades .= "imatge = :imatge";
                $primeraModificacio = false;
            }
        
            // si no hi ha dades per modificar mostrem un missatge d'error
            if ($primeraModificacio) {
                echo "no s'han proporcionat dades per modificar ❌";
                break;
            }
        
            // finalitzem la consulta afegint la condició where per seleccionar l'id
            $modificarDades .= " WHERE id = :id";
            $consultaModif = $connexio->prepare($modificarDades);
            $consultaModif->bindParam(':id', $id);
        
            // assignem els nous valors als seus corresponents paràmetres
            if (!empty($marca)) {
                $consultaModif->bindParam(':marca', $marca);
            }
        
            if (!empty($model)) {
                $consultaModif->bindParam(':model', $model);
            }
        
            if (!empty($color)) {
                $consultaModif->bindParam(':color', $color);
            }
        
            if (!empty($matricula)) {
                $consultaModif->bindParam(':matricula', $matricula);
            }
            if (!empty($imatge)) {
                $consultaModif->bindParam(':imatge', $imatge);
            }
            
            // executem la consulta de modificació i mostrem missatge d'èxit o error
            if ($consultaModif->execute()) {
                echo "article amb ID " . $id . " modificat correctament ✅";
            } else {
                echo "error al modificar article ❌";
            }
            break;
    
        case "Eliminar":
            // vinculem l'id del formulario a una variable
            $id = $_POST["id"] ?? null;

            // obtenim el nom de l'usuari de la sessió
            $usuari = $_SESSION["usuari"] ?? null;

            // si falta l'ID salta un error
            if (empty($id)) {
                echo "falta l'ID ❌";
                break;
            }

            // verifiquem que l'article amb aquest id existeix
            $consultaExistencia = $connexio->prepare("SELECT * FROM article WHERE id = :id");
            $consultaExistencia->bindParam(':id', $id);
            $consultaExistencia->execute();

            if ($consultaExistencia->rowCount() == 0) {
                echo "no s'ha trobat cap article amb aquest ID ❌";
                break;
            }

            // Obtenim l'usuari creador de l'article
            $article = $consultaExistencia->fetch(PDO::FETCH_ASSOC);
            $usuariCreador = $article['nom_usuari'];

            // comprovem si l'usuari de la sessió és el mateix que el creador de l'article
            if ($usuari !== $usuariCreador) {
                echo "no tens permís per eliminar aquest article ❌";
                break;
            }

            // mostrem el formulari de confirmacio d'eliminacio
            if (!isset($_POST['confirmar'])) {
                ?>
                <h2>Estàs segur que vols eliminar l'article amb ID <?php echo htmlspecialchars($id); ?>?</h2>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="hidden" name="Enviar" value="Eliminar">
                    <input type="submit" name="confirmar" value="Si">
                    <input type="submit" name="confirmar" value="No">
                </form>
                <?php
                break;
            }

            // si el usuari ha confirmat la eliminació s'elimina
            if ($_POST['confirmar'] === 'Si') {
                $consultaEliminar = $connexio->prepare("DELETE FROM article WHERE id = :id");
                $consultaEliminar->bindParam(':id', $id);

                if ($consultaEliminar->execute()) {
                    echo "Article amb ID " . htmlspecialchars($id) . " eliminat correctament ✅";
                } else {
                    echo "Error al eliminar article ❌";
                }
            } else {
                // si no, es cancela l'eliminacio
                echo "Eliminació cancel·lada ✅";
            }
            break;
    }   
} catch (PDOException $e) {
    // en cas d'error de connexió mostrem el missatge d'error
    echo "Error de connexió: " . $e->getMessage() . " ❌";
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
<br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a><br>
</body>
</html>

<!-- mostra la llista d'articles a sota de tot -->
<?php
include "mostrarLlista.php";

?>