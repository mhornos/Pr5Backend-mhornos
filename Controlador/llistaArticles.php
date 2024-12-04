<?php
//Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// inclourem el model
require_once dirname(__DIR__) . '/Model/llistaArticles.php';


// definir resultats per pàgina
$resultatsPerPagina = 5;

// definir la pàgina actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($paginaActual < 1) {
    $paginaActual = 1;
}

// comprovar si l'usuari està loguejat
$usuariLoguejat = $_SESSION['usuari'] ?? null;

// obtenir el total d'articles
$totalArticles = obtenirTotalArticles($usuariLoguejat);

// calcular el nombre total de pàgines
$totalPags = ceil($totalArticles / $resultatsPerPagina);

// obtenir els articles per a la pàgina actual
$articles = obtenirArticles($paginaActual, $resultatsPerPagina, $usuariLoguejat);

echo "<div class='paginacio'>";

// botó de pàgina anterior
if ($paginaActual > 1) {
    echo '<a href="?pagina=' . ($paginaActual - 1) . '">Anterior</a>';
}

// enllaços a totes les pàgines
for ($i = 1; $i <= $totalPags; $i++) {
    if ($i == $paginaActual) {
        echo '<strong>' . $i . '</strong>'; 
    } else {
        echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
    }
}

// botó de pàgina següent
if ($paginaActual < $totalPags) {
    echo '<a href="?pagina=' . ($paginaActual + 1) . '">Següent</a>';
}

echo "</div><br>";

echo "<div class='articles-container'>";

// mostrar els articles si existeixen
if (count($articles) > 0) {
    foreach ($articles as $article) {
        echo "<div class='article-box'>";
        echo "<td>" . htmlspecialchars($article['ID']) . "</td>";
        echo "<h3>" . htmlspecialchars($article['marca']) . " " . $article['model'] .  "</h3>";
        echo "<p><strong>Any:</strong> " . htmlspecialchars($article['any']) . "</p>";
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

?>
