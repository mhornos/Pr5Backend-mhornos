<?php
// Miguel Angel Hornos Granda

// Aquesta funció obté el total d'articles que compleixen els criteris de cerca i l'usuari loguejat (si s'escau).
function obtenirTotalArticles($usuariLoguejat = null, $cercaCriteri = '') {
    try {
        require "connexio.php";
        
        // Consulta SQL per obtenir el total d'articles
        $consulta = "SELECT COUNT(*) as total FROM article WHERE 1=1";
        
        // Si s'ha especificat un criteri de cerca, s'afegeix a la consulta
        if ($cercaCriteri) {
            $consulta .= " AND (marca LIKE :criteri OR model LIKE :criteri OR any LIKE :criteri OR color LIKE :criteri OR matricula LIKE :criteri OR nom_usuari LIKE :criteri)";
        }

        // Si l'usuari està loguejat, es filtra per nom_usuari
        if ($usuariLoguejat) {
            $consulta .= " AND nom_usuari = :nom_usuari";
        }

        // Preparar la consulta
        $consultaTotal = $connexio->prepare($consulta);
        
        // Vincula els valors dels paràmetres de cerca i usuari loguejat (si existeixen)
        if ($cercaCriteri) {
            $consultaTotal->bindValue(':criteri', '%' . $cercaCriteri . '%', PDO::PARAM_STR);
        }
        if ($usuariLoguejat) {
            $consultaTotal->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
        }

        // Executar la consulta
        $consultaTotal->execute();
        return $consultaTotal->fetchColumn();
    } catch (PDOException $e) {
        echo "Error de connexió: " . $e->getMessage() . " ❌";
    }
}

// Aquesta funció obté els articles amb els criteris de cerca, l'usuari loguejat i la pàgina actual.
function obtenirArticles($paginaActual, $resultatsPerPagina, $criteriOrdenacio, $usuariLoguejat = null, $cercaCriteri = '') {
    try {
        require "connexio.php";
        
        // Calcular el desplaçament per la paginació
        $offset = ($paginaActual - 1) * $resultatsPerPagina;
        
        // Mapa d'ordenació segons els criteris especificats
        $mapaOrdenacio = [
            'any_asc' => 'any ASC',
            'any_desc' => 'any DESC',
            'marca_asc' => 'marca ASC',
            'marca_desc' => 'marca DESC',
            'model_asc' => 'model ASC',
            'model_desc' => 'model DESC',
        ];
        // Assignar l'ordre de la consulta
        $ordenacio = $mapaOrdenacio[$criteriOrdenacio] ?? 'any ASC';
        
        // Consulta SQL per obtenir els articles amb les relacions corresponents a usuaris
        $consulta = "SELECT a.ID AS articleID, a.*, u.ID AS userID, u.ciutat FROM article a LEFT JOIN usuaris u ON a.nom_usuari = u.nombreUsuario WHERE 1=1";
        
        // Afegir criteris de cerca
        if ($cercaCriteri) {
            $consulta .= " AND (a.marca LIKE :criteri OR a.model LIKE :criteri OR a.any LIKE :criteri OR a.color LIKE :criteri OR a.matricula LIKE :criteri OR a.nom_usuari LIKE :criteri)";
        }
        // Filtrar per l'usuari loguejat
        if ($usuariLoguejat) {
            $consulta .= " AND a.nom_usuari = :nom_usuari";
        }

        // Afegir ordenació i límit de resultats
        $consulta .= " ORDER BY $ordenacio LIMIT :offset, :limit";

        // Preparar la consulta
        $consulta = $connexio->prepare($consulta);
        
        // Vincula els valors dels paràmetres de cerca i usuari loguejat (si existeixen)
        if ($cercaCriteri) {
            $consulta->bindValue(':criteri', '%' . $cercaCriteri . '%', PDO::PARAM_STR);
        }
        if ($usuariLoguejat) {
            $consulta->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
        }

        // Vincula els valors de desplaçament i límit per la paginació
        $consulta->bindValue(':offset', $offset, PDO::PARAM_INT);
        $consulta->bindValue(':limit', $resultatsPerPagina, PDO::PARAM_INT);
        // Executar la consulta
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error de connexió: " . $e->getMessage() . " ❌";
    }
}
?>
