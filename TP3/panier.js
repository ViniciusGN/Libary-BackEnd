function consulter_panier() {
    const req = new XMLHttpRequest();
    req.open("GET", "Cart/consulter_panier.php", true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            const contenu = document.getElementById("contenu-panier");
            contenu.innerHTML = req.responseText;
            contenu.style.display = "block";
        }
    };

    req.send();
}

function fermer_panier() {
    const contenu = document.getElementById("contenu-panier");
    contenu.innerHTML = "";
    contenu.style.display = "none";
}

function commander_panier() {
    const req = new XMLHttpRequest();
    req.open("POST", "Cart/commander_panier.php", true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            alert("Commande effectuée !");
            fermer_panier();
        }
    };

    req.send();
}
