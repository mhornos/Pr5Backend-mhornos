<?php
// Miguel Angel Hornos Granda

function obtenirTotalArticles($usuariLoguejat = null, $cercaCriteri = '') {
    try {
        require "connexio.php";
        
        $query = "SELECT COUNT(*) as total FROM article WHERE 1=1";
        
        // Si se pasa un término de búsqueda, ajusta la consulta para buscar en varios campos
        if ($cercaCriteri) {
            $query .= " AND (marca LIKE :criteri OR model LIKE :criteri OR any LIKE :criteri OR color LIKE :criteri OR matricula LIKE :criteri OR nom_usuari LIKE :criteri)";
        }

        if ($usuariLoguejat) {
            $query .= " AND nom_usuari = :nom_usuari";
        }

        $consultaTotal = $connexio->prepare($query);
        
        if ($cercaCriteri) {
            $consultaTotal->bindValue(':criteri', '%' . $cercaCriteri . '%', PDO::PARAM_STR);
        }
        if ($usuariLoguejat) {
            $consultaTotal->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
        }

        $consultaTotal->execute();
        return $consultaTotal->fetchColumn();
    } catch (PDOException $e) {
        echo "Error de connexió: " . $e->getMessage() . " ❌";
    }
}

function obtenirArticles($paginaActual, $resultatsPerPagina, $criteriOrdenacio, $usuariLoguejat = null, $cercaCriteri = '') {
    try {
        require "connexio.php";
        
        $offset = ($paginaActual - 1) * $resultatsPerPagina;
        
        $mapaOrdenacio = [
            'any_asc' => 'any ASC',
            'any_desc' => 'any DESC',
            'marca_asc' => 'marca ASC',
            'marca_desc' => 'marca DESC',
            'model_asc' => 'model ASC',
            'model_desc' => 'model DESC',
        ];
        $ordenacio = $mapaOrdenacio[$criteriOrdenacio] ?? 'any ASC';
        
        // Modificación en la consulta SQL
        $query = "SELECT a.*, u.ciutat FROM article a LEFT JOIN usuaris u ON a.nom_usuari = u.nombreUsuario WHERE 1=1";
        
        if ($cercaCriteri) {
            $query .= " AND (a.marca LIKE :criteri OR a.model LIKE :criteri OR a.any LIKE :criteri OR a.color LIKE :criteri OR a.matricula LIKE :criteri OR a.nom_usuari LIKE :criteri)";
        }
        if ($usuariLoguejat) {
            $query .= " AND a.nom_usuari = :nom_usuari";
        }

        $query .= " ORDER BY $ordenacio LIMIT :offset, :limit";

        $consulta = $connexio->prepare($query);
        
        if ($cercaCriteri) {
            $consulta->bindValue(':criteri', '%' . $cercaCriteri . '%', PDO::PARAM_STR);
        }
        if ($usuariLoguejat) {
            $consulta->bindValue(':nom_usuari', $usuariLoguejat, PDO::PARAM_STR);
        }

        $consulta->bindValue(':offset', $offset, PDO::PARAM_INT);
        $consulta->bindValue(':limit', $resultatsPerPagina, PDO::PARAM_INT);
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error de connexió: " . $e->getMessage() . " ❌";
    }
}
?>
