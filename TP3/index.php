<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque Virtuelle</title>
    <link rel="stylesheet" href="../Assets/styles.css">
    <script src="script.js" defer></script>
</head>
<body>
<?php
    session_start();
    if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
        header("Location: login.php");
        exit();
    }

    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];

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
        <div class="header-left"><?php echo "$visitor visiteurs"; ?></div>
        <div class="header-center">Vente de Livres</div>
        <div class="header-right">
            <div>Bienvenue<br><?php echo htmlspecialchars("$prenom $nom"); ?></div>
            <form action="logout.php" method="post">
                <button class="logout-btn" type="submit">Quitter</button>
            </form>
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
