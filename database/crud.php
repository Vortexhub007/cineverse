<?php
require_once 'config.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();

    // Récupérer les résultats
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultats as $row) {
        // Traiter chaque ligne de résultat
    }
} catch(PDOException $e) {
    echo "Erreur de lecture : " . $e->getMessage();
}

?>