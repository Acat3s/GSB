<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Validation des frais</title>
        <script>
            // Fonction qui est appelée chaque fois que l'utilisateur sélectionne un nom
            function updateAnnee() {
                var idvis = document.getElementById('nom').value;  // Récupérer la valeur sélectionnée du nom

                // Si aucune valeur n'est sélectionnée, ne rien faire
                if (idvis === "") {
                    return;
                }

                // Créer un objet XMLHttpRequest pour faire une requête AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'GF6-chargement_annee.php?idvis=' + encodeURIComponent(idvis), true);

                // Fonction pour gérer la réponse du serveur
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Mettre à jour les options de l'année avec la réponse du serveur
                        document.getElementById('annee').innerHTML = xhr.responseText;
                    }
                };

                // Envoyer la requête avec le paramètre idvis
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('idvis=' + encodeURIComponent(idvis));
            }
        </script>
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

        //Demarrage de la session
        session_start();

        //Connexion a la base de donnee
        $cnxBDD = connexion();

        //Requete pour recuperer les noms des visiteurs
        $sql = "SELECT Nom FROM Visiteur WHERE id IN (SELECT idVisiteur From FicheFrais);";
        $result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));
        ?>
        <form method="POST" action="">
            <label for="nom">Choisissez un nom :</label>
            <select id="nom" name="nom" onchange="updateAnnee()">
                <option value="" hidden></option>
                <?php
                //On verifie si des noms ont ete trouve
                if ($result->num_rows > 0) {
                    //On parcourt les resultats et on cree une option pour chaque nom
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['Nom']; ?>"> <?php echo $row['Nom']; ?> </option>
                    <?php
                    }
                } else {
                    ?>
                    <option value="">Aucun nom disponible</option>;
                <?php
                }
                ?>
            </select>

            <h1>Validation des frais par visiteur</h1>

            <!-- Menu déroulant pour sélectionner une année -->
            <label for="annee">Année : </label>
            <select id="annee" name="annee">
                <option value="" hidden></option>
            </select>
            <!-- Menu déroulant pour sélectionner un mois (plage de Janvier à Décembre) -->
            <label for="mois">Mois : </label>
            <select id="mois" name="mois">
                <option value="" hidden></option>
                <?php
                    //Boucle pour afficher le mois
                    for($i=1; $i<=12; $i++){
                ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php
                    }
                ?>
            </select>
            <br>
            <br>
            <button type="submit">Sélectionner la fiche de frais</button>
        </form>
    </body>
</html>