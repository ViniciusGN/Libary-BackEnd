<?php
session_start();
require_once "Requests/config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);

    if ($nom && $prenom) {
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE nom = :nom AND prenom = :prenom");
        $stmt->execute(['nom' => $nom, 'prenom' => $prenom]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($client) {
            // Login ok
            $_SESSION['code_client'] = $client['code'];
            $_SESSION['nom'] = $client['nom'];
            $_SESSION['prenom'] = $client['prenom'];

            header("Location: index.php");
            exit();
        } else {
            $message = "Client introuvable. Veuillez vous inscrire.";
        }
    } else {
        $message = "Veuillez remplir les champs Nom et Prénom.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Client</title>
    <link rel="stylesheet" href="../Assets/styles.css">
</head>
<body>
    <div class="log-container">
        <h2>Connexion au compte client</h2>

        <?php if ($message): ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="post" action="login.php">
            <nav class="nav-log">
            <label>Nom :</label><br>
            <input type="text" name="nom" required><br><br>

            <label>Prénom :</label><br>
            <input type="text" name="prenom" required><br><br>

            <input type="submit" class="generic-btn" value="Se connecter">
            </nav>
        </form>

        <p style="color: white">Pas encore inscrit ?     
            <a href="register.php">
                <input type="button" class="generic-btn" value="Créer un compte">
            </a>
        </p>
    </div>
</body>
</html>
