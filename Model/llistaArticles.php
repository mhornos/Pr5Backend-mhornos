<!-- modelo.php -->
<?php

function obtenirTotalArticles($usuariLoguejat = null) {
    require_once "connexio.php";
    
    if ($usuariLoguejat) {
        // Si l'usuari està loguejat, obtenir només els seus articles
        $consultaTotal = $connexio->prepare("SELECT COUNT(*) as total FROM article WHERE nom_usuari = :nom_usuari");
        $consultaTotal->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
    } else {
        // Si no està loguejat, obtenir tots els articles
        $consultaTotal = $connexio->prepare("SELECT COUNT(*) as total FROM article");
    }

    $consultaTotal->execute();
    return $consultaTotal->fetchColumn();
}

function obtenirArticles($paginaActual, $resultatsPerPagina, $usuariLoguejat = null) {
    require_once "connexio.php";
    
    // Calcular l'offset
    $offset = ($paginaActual - 1) * $resultatsPerPagina;

    if ($usuariLoguejat) {
        // Si l'usuari està loguejat, obtenir només els seus articles
        $consulta = $connexio->prepare("
            SELECT a.*, u.ciutat 
            FROM article a 
            LEFT JOIN usuaris u ON a.nom_usuari = u.nombreUsuario 
            WHERE a.nom_usuari = :nom_usuari
            LIMIT :offset, :limit
        ");
        $consulta->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
    } else {
        // Si no està loguejat, obtenir tots els articles
        $consulta = $connexio->prepare("
            SELECT a.*, u.ciutat 
            FROM article a 
            LEFT JOIN usuaris u ON a.nom_usuari = u.nombreUsuario 
            LIMIT :offset, :limit
        ");
    }

    $consulta->bindValue(':offset', $offset, PDO::PARAM_INT);
    $consulta->bindValue(':limit', $resultatsPerPagina, PDO::PARAM_INT);
    $consulta->execute();
    
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}
?>
