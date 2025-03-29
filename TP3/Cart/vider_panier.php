<?php
session_start();
require_once "../Requests/config.php";

if (!isset($_SESSION['code_client'])) {
    http_response_code(403);
    echo "Non autorisé.";
    exit();
}

$code_client = $_SESSION['code_client'];

try {
    $stmt = $pdo->prepare("DELETE FROM panier WHERE code_client = :code_client");
    $stmt->execute(['code_client' => $code_client]);

    echo "Le panier a été vidé.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
