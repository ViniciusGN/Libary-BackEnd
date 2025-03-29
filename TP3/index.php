<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque Virtuelle</title>
    <link rel="stylesheet" href="../Assets/styles.css">
    <script src="script.js" defer></script>
    <script src="panier.js" defer></script>
</head>
<body>
<?php
    session_start();
    require_once "Requests/config.php";

    if (!isset($_SESSION['code_client']) && isset($_COOKIE['code_client'])) {
        $code = intval($_COOKIE['code_client']);
        $stmt = $pdo->prepare("SELECT nom, prenom FROM clients WHERE code = :code");
        $stmt->execute(['code' => $code]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($client) {
            $_SESSION['code_client'] = $code;
            $_SESSION['nom'] = $client['nom'];
            $_SESSION['prenom'] = $client['prenom'];
        }
    }

    $file_path = "../Assets/counter.txt";
    if (!file_exists($file_path)) {
        file_put_contents($file_path, "0");
    }
    $visitor = (int) file_get_contents($file_path);

    if (!isset($_COOKIE['visited'])) {
        $visitor++;
        file_put_contents($file_path, $visitor);
        setcookie("visited", "true", time() + 3600);
    }
?>
    <header>
        <div class="header-left"><?php echo "$visitor visiteurs"; ?>
            <form action="logout.php" method="post">
                <button class="logout-btn" type="submit">Quitter</button>
            </form>
        </div>

        <div class="header-center">Vente de Livres</div>

        <div class="header-right">
            <?php if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])): ?>
                <div>Bienvenue<br><?php echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']); ?></div>
                <button class="logout-btn" onclick="consulter_panier()">Consulter le panier</button>
            <?php else: ?>
                <a href="register.php" class="logout-btn">Inscription</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <nav>
            <label style="color:white;" for="search_author">Auteur :</label>
            <input type="text" id="search_author" placeholder="Nom de l'auteur">

            <label style="color:white;" for="search_title">Titre :</label>
            <input type="text" id="search_title" placeholder="Titre du livre">

            <label style="color:white;" for="search_code">Code :</label>
            <input type="text" id="search_code" placeholder="Code du livre">
        </nav>
        
        <div id="contenu-panier" class="right_Side" style="display: none;"></div>

        <section id="principal">
            <div id="resultats-auteurs">
                <p style="text-align: center;">Bienvenue sur le site de la Bibliothèque Virtuelle.</p>
            </div>

            <div id="resultats-ouvrages">
                <p><strong>Auteurs :</strong></p>
                <ol style="padding-left: 25px;">
                    <li>Cabanel</li>
                    <li>Chabrol</li>
                    <li>Haber</li>
                    <li>Stableford</li>
                </ol>
            </div>
        </section>
    </main>
</body>
</html>