<?php
require_once "../Requests/config.php";
session_start();

$code_client = $_SESSION['code_client'] ?? 0;

if (!$code_client) {
    echo "<p>Erreur : utilisateur non connecté.</p>";
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT o.nom AS titre, ed.nom AS editeur, p.quantite, e.prix
        FROM panier p
        JOIN exemplaire e ON p.code_exemplaire = e.code
        JOIN ouvrage o ON e.code_ouvrage = o.code
        JOIN editeurs ed ON e.code_editeur = ed.code
        WHERE p.code_client = :code
    ");
    $stmt->execute(['code' => $code_client]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="panier-box">';
    echo '<h3>Contenu du Panier</h3>';

    if (count($articles) === 0) {
        echo "<p>Votre panier est vide.</p>";
    } else {
        echo '<ul>';
        $total = 0;
        foreach ($articles as $a) {
            $sous_total = $a['prix'] * $a['quantite'];
            $total += $sous_total;

            echo "<li><strong>{$a['titre']}</strong> - {$a['editeur']}, quantité: {$a['quantite']} - prix: {$a['prix']} €</li>";
        }
        echo '</ul>';
        echo "<p><strong>Total: {$total} €</strong></p>";
    }

    if (count($articles) > 0) {
        echo '<button class="logout-btn" onclick="commander()">Commander</button>';
    }

    echo '<button class="logout-btn" onclick="fermer_panier()">Fermer</button>';
    echo '</div>';

} catch (PDOException $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}