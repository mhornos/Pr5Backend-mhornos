<!-- Miguel Angel Hornosa -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// conectar a la bd amb PDO
try {
    //ens conectem a la bd
    require_once "connexio.php";
    
    // definir el el nombre de resultats per página
    $resultatsPerPagina = 5;
    
    // definir la página actual
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($paginaActual < 1) {
        $paginaActual = 1;
    }
    
    // calcular l'offset
    $offset = ($paginaActual - 1) * $resultatsPerPagina;
    
    // verificar si l'usuari está loguejat
    $usuariLoguejat = isset($_SESSION['usuari']) ? $_SESSION['usuari'] : null;

    if ($usuariLoguejat) {
        // si l'usuari está loguejat, mostrar nomes els seus articles
        $consultaTotal = $connexio->prepare("SELECT COUNT(*) as total FROM article WHERE nom_usuari = :nom_usuari");
        $consultaTotal->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);

        $consulta = $connexio->prepare("
            SELECT a.*, u.ciutat 
            FROM article a 
            LEFT JOIN usuaris u ON a.nom_usuari = u.nombreUsuario 
            WHERE a.nom_usuari = :nom_usuari
            LIMIT :offset, :limit
        ");
        $consulta->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
    } else {
        // si no está loguejat, mostrar tots els articles
        $consultaTotal = $connexio->prepare("SELECT COUNT(*) as total FROM article");
        $consulta = $connexio->prepare("
            SELECT a.*, u.ciutat 
            FROM article a 
            LEFT JOIN usuaris u ON a.nom_usuari = u.nombreUsuario 
            LIMIT :offset, :limit
        ");
    }

    // executar la consulta
    $consultaTotal->execute();
    $totalArticles = $consultaTotal->fetchColumn();

    // calcular el nombre total de pagines
    $totalPags = ceil($totalArticles / $resultatsPerPagina);

    $consulta->bindValue(':offset', $offset, PDO::PARAM_INT);
    $consulta->bindValue(':limit', $resultatsPerPagina, PDO::PARAM_INT);
    $consulta->execute();
    
    // obtenir articles
    $articles = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='paginacio'>";
    if ($paginaActual > 1) {
        echo '<a href="?pagina=' . ($paginaActual - 1) . '">Anterior</a>';
    }
    
    // enllaç a totes les pagines
    for ($i = 1; $i <= $totalPags; $i++) {
        if ($i == $paginaActual) {
            echo '<strong>' . $i . '</strong>'; // destacar la pagina actual
        } else {
            echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
        }
    }
    
    // Botó de pagina seguent
    if ($paginaActual < $totalPags) {
        echo '<a href="?pagina=' . ($paginaActual + 1) . '">Següent</a>';
    }
    echo "</div> <br>";
    
    echo "<div class='articles-container'>";
    // mostrar els articles si existeixen
    if (count($articles) > 0) {
        foreach ($articles as $article) {
            echo "<div class='article-box'>";
            echo "<td>" . htmlspecialchars($article['ID']) . "</td>";
            echo "<h3>" . htmlspecialchars($article['marca']) . "</h3>";
            echo "<p><strong>Model:</strong> " . htmlspecialchars($article['model']) . "</p>";
            echo "<p><strong>Color:</strong> " . htmlspecialchars($article['color']) . "</p>";
            echo "<p><strong>Matrícula:</strong> " . htmlspecialchars($article['matricula']) . "</p>";
            echo "<p><strong>Mecànic:</strong> " . htmlspecialchars($article['nom_usuari']) . "</p>";
            echo "<p><strong>Ciutat:</strong> " . htmlspecialchars($article['ciutat']) . "</p>";
            
            // mostrar la imatge si existeix
            if (!empty($article['imatge'])) {
                echo "<img src='" . htmlspecialchars($article['imatge']) . "' width='150'>";
            } else {
                // si no hi ha imatge
                echo "<p><br>No hi ha imatge</p>";
            }
            echo "</div>";
        }
    } else {
        // si no hi ha articles
        echo "<p>No s'han trobat vehicles.</p>";
    }
    echo "</div>";
    
} catch (PDOException $e) {
    echo "Error de connexió: " . htmlspecialchars($e->getMessage()) . " ❌";
}
?>
