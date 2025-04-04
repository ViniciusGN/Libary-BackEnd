<?php
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$dbname = 'livres';
$user = 'postgres';
$password = 'postgres';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $codeAuteur = $_GET['code'] ?? '';

    if ($codeAuteur !== '') {
        // Buscar os ouvrages do autor
        $stmt = $pdo->prepare("
            SELECT o.code, o.nom
            FROM ouvrage o
            JOIN ecrit_par ep ON ep.code_ouvrage = o.code
            WHERE ep.code_auteur = :code
        ");
        $stmt->execute(['code' => $codeAuteur]);
        $ouvrages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $resultat = [];

        foreach ($ouvrages as $ouvrage) {
            $stmt2 = $pdo->prepare("
                SELECT e.code, ed.nom AS nom, e.prix
                FROM exemplaire e
                JOIN editeurs ed ON e.code_editeur = ed.code
                WHERE e.code_ouvrage = :code
            ");
            $stmt2->execute(['code' => $ouvrage['code']]);
            $exemplaires = $stmt2->fetchAll(PDO::FETCH_ASSOC);

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
