document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("search_author");

    input.addEventListener("keyup", function () {
        const debnom = this.value.trim();
        if (debnom === "") {
            document.getElementById("resultats-auteurs").innerHTML = "";
            return;
        }

        recherche_auteurs(debnom);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const inputTitle = document.getElementById("search_title");

    inputTitle.addEventListener("keyup", function () {
        const titre = this.value.trim();
        if (titre === "") {
            document.getElementById("resultats-ouvrages").innerHTML = "";
            return;
        }
        recherche_ouvrages_titre(titre);
    });
});

function recherche_auteurs(debnom) {
    const req = new XMLHttpRequest();
    req.open('GET', 'recherche_auteurs.php?debnom=' + encodeURIComponent(debnom), true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            const auteurs = JSON.parse(req.responseText);
            affiche_auteurs(auteurs);
        }
    };

    req.send();
}

function recherche_ouvrages_titre(titre) {
    const req = new XMLHttpRequest();
    req.open("GET", "recherche_ouvrages_titre.php?debtitre=" + encodeURIComponent(titre), true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            const ouvrages = JSON.parse(req.responseText);
            affiche_ouvrages(ouvrages);
        }
    };

    req.send();
}

function recherche_ouvrages_auteur(code) {
    const req = new XMLHttpRequest();
    req.open("GET", "recherche_ouvrages_auteur.php?code=" + encodeURIComponent(code), true);

    req.onreadystatechange = function () {
        if (req.readyState === 4 && req.status === 200) {
            const ouvrages = JSON.parse(req.responseText);
            affiche_ouvrages(ouvrages);
        }
    };

    req.send();
}

function affiche_auteurs(auteurs) {
    const div = document.getElementById('resultats-auteurs');
    let html = '<ol style="padding-left: 25px;">';

    auteurs.forEach(auteur => {
        const nomComplet = auteur.nom + ' ' + auteur.prenom;
        html += `<li><a href="#" onclick="recherche_ouvrages_auteur(${auteur.code})">${nomComplet}</a></li>`;

    });

    html += '</ol>';
    div.innerHTML = html;
}

function affiche_ouvrages(ouvrages) {
    const div = document.getElementById("resultats-ouvrages");
    div.innerHTML = ""; // Clear previous results
    let html = '<ol style="padding-left: 25px;">';

    ouvrages.forEach(ouvrage => {
        html += `<li>${ouvrage.nom}</li>`;
    });

    html += "</ol>";
    div.innerHTML = html;
}