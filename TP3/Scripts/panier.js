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

function vider_panier() {
    const req = new XMLHttpRequest();
    req.open("POST", "Cart/vider_panier.php", true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            alert("Le panier a été vidé.");
            document.getElementById("resultats-panier").innerHTML = `
                <p style="text-align:center;">Votre panier est vide.</p>
                <button onclick="fermer_panier()" class="generic-btn">Fermer</button>
            `;
        }
    };

    req.send();
}


function ajouter_panier(code_exemplaire) {
    const req = new XMLHttpRequest();
    req.open("GET", "Cart/ajouter_panier.php?code_exemplaire=" + encodeURIComponent(code_exemplaire), true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            const reponse = JSON.parse(req.responseText);
            
            if (reponse.success) {
                alert("L'article a été ajouté au panier.");
            } else {
                alert("Erreur lors de l'ajout au panier.");
            }
        }
    };

    req.send();
}

function commander_panier() {
    const req = new XMLHttpRequest();
    req.open("POST", "Cart/commander_panier.php", true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            if (req.responseText.trim() === "OK") {
                alert("Commande effectuée !");
                vider_panier();
                fermer_panier();
            } else {
                alert("Erreur : " + req.responseText);
            }
        }
    };

    req.send();
}