<?php
header("Content-Type: application/json; charset=UTF-8");

// Connexion à la BDD
$host = 'localhost';
$dbname = 'livres';
$user = 'postgres';
$password = 'postgres';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $debtitre = $_GET['debtitre'] ?? '';

    if ($debtitre !== '') {
        // 1. Récupérer les ouvrages correspondants
        $stmt = $pdo->prepare("SELECT code, nom FROM ouvrage WHERE nom ILIKE :titre");
        $stmt->execute(['titre' => '%' . $debtitre . '%']);
        $ouvrages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $resultat = [];

        foreach ($ouvrages as $ouvrage) {
            // 2. Pour chaque ouvrage, récupérer les exemplaires + nom éditeur
            $stmt2 = $pdo->prepare("
                SELECT e.code, ed.nom AS nom, e.prix
                FROM exemplaire e
                JOIN editeurs ed ON e.code_editeur = ed.code
                WHERE e.code_ouvrage = :code
            ");
            $stmt2->execute(['code' => $ouvrage['code']]);
            $exemplaires = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            // 3. Ajouter à la réponse
            $resultat[] = [
                'code' => $ouvrage['code'],
                'nom' => $ouvrage['nom'],
                'exemplaires' => $exemplaires
            ];
        }

        echo json_encode($resultat, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([]);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
