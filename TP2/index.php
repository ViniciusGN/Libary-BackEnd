<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque Virtuelle</title>
    <link rel="stylesheet" href="../Assets/styles.css">
</head>
<script src="./script.js"></script>
<body>
<?php
    session_start();

    $cookie_lname = "Doe";
    $cookie_fname = "John";

    // 2. Création du compteur (fichier)
    $file_path = "../Assets/counter.txt";
    setcookie("user", "$cookie_fname $cookie_lname", time() + 3600, "/");

    if (!file_exists($file_path)) {
        file_put_contents($file_path, "0");
    }
    $visitor = (int) file_get_contents($file_path);

    // 3. Utilisation des compteurs (cookie)
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
            <div>Bienvenue<br><?php echo "$cookie_fname $cookie_lname"; ?></div>
            <form action="logout.php" method="post">
                <button class="logout-btn">Quitter</button>
            </form>
        </div>
    </header>

    <main>
        <nav>
            <label for="search_author">Auteur :</label>
            <input type="text" id="search_author" placeholder="Nom de l'auteur">

            <label for="search_title">Titre :</label>
            <input type="text" id="search_title" placeholder="Titre du livre">

            <label for="search_code">Code :</label>
            <input type="text" id="search_code" placeholder="Code du livre">
        </nav>

        <section id="principal">
            <div id="resultats-auteurs">
                <p>Bienvenue sur le site de la Bibliothèque Virtuelle.</p>
            </div>

            <div id="resultats-ouvrages">
            <p><strong>Auteurs :</strong></p>
                <ol>
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
