<?php
session_start();
require_once "../Requests/config.php";

if (!isset($_SESSION['code_client'])) {
    echo "<p>Erreur : utilisateur non connecté.</p>";
    exit();
}

$code_client = $_SESSION['code_client'];

$stmt = $pdo->prepare("SELECT o.nom AS titre, ed.nom AS editeur, p.quantite, e.prix, e.code
                        FROM panier p
                        JOIN exemplaire e ON p.code_exemplaire = e.code
                        JOIN ouvrage o ON e.code_ouvrage = o.code
                        JOIN editeurs ed ON e.code_editeur = ed.code
                        WHERE p.code_client = :client");
$stmt->execute(['client' => $code_client]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$articles) {
    echo "<p>Votre panier est vide.</p>";
    exit();
}

$total = 0;
echo "<h3>Votre panier</h3>";
echo "<ul>";
foreach ($articles as $a) {
    $total += $a['prix'] * $a['quantite'];
    echo "<li><strong>{$a['titre']}</strong> - {$a['editeur']} - Qté: {$a['quantite']} - Prix: ".number_format($a['prix'], 2, ',', ' ')." €</li>";
}
echo "</ul>";
echo "<p><strong>Total :</strong> " . number_format($total, 2, ',', ' ') . " €</p>";

// Boutons
echo '<button class="logout-btn" onclick="commander_panier()">Commander</button> ';
echo '<button class="logout-btn" onclick="fermer_panier()">Fermer</button>';
