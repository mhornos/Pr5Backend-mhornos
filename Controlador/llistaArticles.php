<!-- controlador.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclourem el model
require_once dirname(__DIR__) . '/Model/llistaArticles.php';


// Definir resultats per pàgina
$resultatsPerPagina = 5;

// Definir la pàgina actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($paginaActual < 1) {
    $paginaActual = 1;
}

// Comprovar si l'usuari està loguejat
$usuariLoguejat = $_SESSION['usuari'] ?? null;

// Obtenir el total d'articles
$totalArticles = obtenirTotalArticles($usuariLoguejat);

// Calcular el nombre total de pàgines
$totalPags = ceil($totalArticles / $resultatsPerPagina);

// Obtenir els articles per a la pàgina actual
$articles = obtenirArticles($paginaActual, $resultatsPerPagina, $usuariLoguejat);

echo "<div class='paginacio'>";

// Botó de pàgina anterior
if ($paginaActual > 1) {
    echo '<a href="?pagina=' . ($paginaActual - 1) . '">Anterior</a>';
}

// Enllaços a totes les pàgines
for ($i = 1; $i <= $totalPags; $i++) {
    if ($i == $paginaActual) {
        echo '<strong>' . $i . '</strong>'; // Destacar la pàgina actual
    } else {
        echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
    }
}

// Botó de pàgina següent
if ($paginaActual < $totalPags) {
    echo '<a href="?pagina=' . ($paginaActual + 1) . '">Següent</a>';
}

echo "</div><br>";

echo "<div class='articles-container'>";

// Mostrar els articles si existeixen
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
        
        // Mostrar la imatge si existeix
        if (!empty($article['imatge'])) {
            echo "<img src='" . htmlspecialchars($article['imatge']) . "' width='150'>";
        } else {
            // Si no hi ha imatge
            echo "<p><br>No hi ha imatge</p>";
        }
        echo "</div>";
    }
} else {
    // Si no hi ha articles
    echo "<p>No s'han trobat vehicles.</p>";
}

echo "</div>";

?>
