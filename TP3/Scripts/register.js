function enregistrement() {
    const nom = document.getElementById("nom").value.trim();
    const prenom = document.getElementById("prenom").value.trim();
    const adresse = document.getElementById("adresse").value.trim();
    const cp = document.getElementById("cp").value.trim();
    const ville = document.getElementById("ville").value.trim();
    const pays = document.getElementById("pays").value.trim();
    const messageDiv = document.getElementById("msg-erreur");

    messageDiv.innerHTML = "";

    if (!nom || !prenom) {
        messageDiv.innerHTML = "Les champs Nom et Prénom sont obligatoires.";
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "Requests/inscription.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const response = xhr.responseText.trim();

            if (!isNaN(response) && parseInt(response) > 0) {
                document.cookie = `code_client=${response}; path=/; expires=Fri, 31 Dec 2050 23:59:59 GMT`;

                window.location.href = "index.php";
            } else if (response === "0") {
                messageDiv.innerHTML = "Ce client existe déjà. Veuillez vous connecter.";
            } else if (response === "missing") {
                messageDiv.innerHTML = "Veuillez remplir tous les champs.";
            } else {
                messageDiv.innerHTML = "Erreur d'enregistrement. Veuillez réessayer.";
            }
        }
    };

    const params = `nom=${encodeURIComponent(nom)}&prenom=${encodeURIComponent(prenom)}&adresse=${encodeURIComponent(adresse)}&cp=${encodeURIComponent(cp)}&ville=${encodeURIComponent(ville)}&pays=${encodeURIComponent(pays)}`;

    xhr.send(params);
}
