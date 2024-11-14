<!-- Miguel Angel Hornos  -->

<?php

function esborrarArticle($id,$usuari){
    try {
        // ens connectem amb la base de dades
        require "connexio.php";

        // array per guardar els errors que es puguin produir durant la validació
        $errors = [];

        // verifiquem que l'article amb aquest id existeix
        $consultaExistencia = $connexio->prepare("SELECT * FROM article WHERE id = :id");
        $consultaExistencia->bindParam(':id', $id);
        $consultaExistencia->execute();

        if ($consultaExistencia->rowCount() == 0) {
            $errors[] =  "no s'ha trobat cap article amb aquest ID ❌";
        } else {
            // obtenim l'usuari creador de l'article
            $article = $consultaExistencia->fetch(PDO::FETCH_ASSOC);
            $usuariCreador = $article['nom_usuari'];

            // comprovem si l'usuari de la sessió és el mateix que el creador de l'article
            if ($usuari !== $usuariCreador) {
                $errors[] = "no tens permís per eliminar aquest article ❌";
            }
        }

        
        // si hi ha errors, els mostrem
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            return; // finalitzem l'execució si hi ha errors
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
        }

        // si el usuari ha confirmat la eliminació s'elimina
        if ($_POST['confirmar'] === 'Si') {
            $consultaEliminar = $connexio->prepare("DELETE FROM article WHERE id = :id");
            $consultaEliminar->bindParam(':id', $id);

            if ($consultaEliminar->execute()) {
                echo "article amb ID " . htmlspecialchars($id) . " eliminat correctament ✅";
            } else {
                echo "error al eliminar article ❌";
            }
        } else {
            // si no, es cancela l'eliminacio
            echo "eliminació cancel·lada ✅";
        }
    
        }catch (PDOException $e) {
        // en cas d'error de connexió mostrem el missatge d'error
        echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}
    