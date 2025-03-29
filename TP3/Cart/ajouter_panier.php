<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');
require_once "../Requests/config.php";

if (!isset($_SESSION['code_client'])) {
    echo json_encode(["success" => false, "message" => "Non connecté"]);
    exit();
}

$code_client = $_SESSION['code_client'];
$code_exemplaire = isset($_GET['code_exemplaire']) ? intval($_GET['code_exemplaire']) : 0;

if ($code_exemplaire <= 0) {
    echo json_encode(["success" => false, "message" => "Exemplaire invalide"]);
    exit();
}

try {
    // Verify if the exemplaire exists
    $check = $pdo->prepare("SELECT quantite FROM panier WHERE code_client = :client AND code_exemplaire = :ex");
    $check->execute(['client' => $code_client, 'ex' => $code_exemplaire]);
    $row = $check->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Update quantity if it exists
        $update = $pdo->prepare("UPDATE panier SET quantite = quantite + 1 WHERE code_client = :client AND code_exemplaire = :ex");
        $update->execute(['client' => $code_client, 'ex' => $code_exemplaire]);
    } else {
        // Insert new entry if it doesn't exist
        $insert = $pdo->prepare("INSERT INTO panier (code_client, code_exemplaire, quantite) VALUES (:client, :ex, 1)");
        $insert->execute(['client' => $code_client, 'ex' => $code_exemplaire]);
    }

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
