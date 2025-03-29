<?php
session_start();
require_once "../Requests/config.php";

header("Content-Type: text/plain; charset=UTF-8");

if (!isset($_SESSION['code_client'])) {
    echo "Erreur : utilisateur non connecté.";
    exit();
}

$code_client = $_SESSION['code_client'];

try {
    // 1. Récupérer les articles du panier
    $stmt = $pdo->prepare("SELECT code_exemplaire, quantite, prix FROM panier 
                          JOIN exemplaire ON panier.code_exemplaire = exemplaire.code
                          WHERE code_client = :client");
    $stmt->execute(['client' => $code_client]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($articles) {
        // 2. Insérer dans la table commande
        $insert = $pdo->prepare("INSERT INTO commande (code_client, code_exemplaire, quantite, prix, date)
                                 VALUES (:client, :ex, :qte, :prix, CURRENT_DATE)");

        foreach ($articles as $a) {
            $insert->execute([
                'client' => $code_client,
                'ex' => $a['code_exemplaire'],
                'qte' => $a['quantite'],
                'prix' => $a['prix']
            ]);
        }

        // 3. Vider le panier
        $pdo->prepare("DELETE FROM panier WHERE code_client = :client")
            ->execute(['client' => $code_client]);

        echo "OK";
    } else {
        echo "Aucun article à commander.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}