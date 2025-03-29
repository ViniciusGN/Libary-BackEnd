<?php
// Configuration de la connexion à PostgreSQL
$host = 'localhost';
$dbname = 'livres';
$user = 'postgres';
$password = 'postgres'; 

// En-tête JSON
header("Content-Type: application/json; charset=UTF-8");

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération du paramètre GET
    $debnom = $_GET['debnom'] ?? '';

    if ($debnom !== '') {
        $stmt = $pdo->prepare("
            SELECT code, nom, prenom 
            FROM auteurs 
            WHERE nom ILIKE :search OR prenom ILIKE :search
        ");
        $stmt->execute(['search' => '%' . $debnom . '%']);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultats, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
