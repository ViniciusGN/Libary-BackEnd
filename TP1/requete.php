<?php
// Paramètres de connexion à PostgreSQL
$host = 'localhost';
$dbname = 'livres';
$user = 'postgres';
$password = 'postgres'; 

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement de la requête
$nom = $_GET['nom'] ?? '';

$sql = "SELECT * FROM auteurs WHERE nom ILIKE :nom";
$stmt = $pdo->prepare($sql);
$stmt->execute(['nom' => "%$nom%"]);
$auteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px; }
        table { border-collapse: collapse; margin: auto; width: 60%; }
        th, td { border: 1px solid #333; padding: 10px; }
        th { background-color: #003147; color: white; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Résultats pour: <?= htmlspecialchars($nom) ?></h2>

    <?php if ($auteurs): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prenom</th>
            </tr>
            <?php foreach ($auteurs as $auteur): ?>
                <tr>
                <td><?= htmlspecialchars($auteur['code']) ?></td>
                <td><?= htmlspecialchars($auteur['nom']) ?></td>
                <td><?= htmlspecialchars($auteur['prenom']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">Aucun auteur trouvé.</p>
    <?php endif; ?>
</body>
</html>
