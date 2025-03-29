<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Client</title>
    <link rel="stylesheet" href="../Assets/styles.css">
</head>
<body>
    <script src="./register.js" defer></script>
    <div class="log-container">
        <h2>Créer un compte client</h2>
        
        <?php if ($message): ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form onsubmit="return false;" id="register-form">
            <nav class="nav-log">
                <label style="color: white">Nom* :</label><br>
                <input type="text" name="nom" id="nom" required><br><br>

                <label style="color: white">Prénom* :</label><br>
                <input type="text" name="prenom" id="prenom" required><br><br>

                <label style="color: white">Adresse :</label><br>
                <input type="text" name="adresse" id="adresse"><br><br>

                <label style="color: white">Code postal :</label><br>
                <input type="text" name="cp" id="cp"><br><br>

                <label style="color: white">Ville :</label><br>
                <input type="text" name="ville" id="ville"><br><br>

                <label style="color: white">Pays :</label><br>
                <input type="text" name="pays" id="pays"><br><br>

                <input type="button" class="generic-btn" value="S'inscrire" onclick="enregistrement()">
                <div id="msg-erreur" style="color:red; margin-top:10px;"></div>

                <p style="color: white">Déjà inscrit ? 
                    <a href="login.php" class="generic-btn">Se connecter</a>
                </p>
            </nav>
        </form>
    </div>
</body>
</html>
