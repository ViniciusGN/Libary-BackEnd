<?php
header("Content-Type: text/plain; charset=UTF-8");
require_once "config.php";

$nom     = $_POST['nom']     ?? '';
$prenom  = $_POST['prenom']  ?? '';
$adresse = $_POST['adresse'] ?? '';
$cp      = $_POST['cp']      ?? '';
$ville   = $_POST['ville']   ?? '';
$pays    = $_POST['pays']    ?? '';

if ($nom && $prenom && $adresse && $cp && $ville && $pays) {
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT inscription(:nom, :prenom, :adresse, :cp, :ville, :pays) AS code_client");
        $stmt->execute([
            'nom'     => $nom,
            'prenom'  => $prenom,
            'adresse' => $adresse,
            'cp'      => $cp,
            'ville'   => $ville,
            'pays'    => $pays
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $result['code_client'];

    } catch (PDOException $e) {
        echo "error";
    }

} else {
    echo "missing";
}