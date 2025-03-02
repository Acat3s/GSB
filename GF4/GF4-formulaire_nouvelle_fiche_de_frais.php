<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Saisir une nouvelle fiche de frais</title>
    </head>
    <body>
        <form action="GF4-code_nouvelle_fiche_de_frais.php" method="get">
            <h1>Saisie</h1>
            <label for="annee">Année : </label>
            <input type="text" id="annee" name="annee" value=<?php echo date("Y");?> disabled="disabled" size="2" />
            <label for="mois">Mois : </label>
            <input type="text" id="mois" name="mois" value=<?php echo date("m");?> disabled="disabled" size="2" /><br>
            <br>
            <br>
            <h3>Frais au Forfait</h3>
            <label for="Txtrepas">Repas midi : </label>
            <input type="number" id="Txtrepas" name="Txtrepas" size="3" required="required" /><br>
            <label for="Txtnuitee">Nuitée : </label>
            <input type="number" id="Txtnuitee" name="Txtnuitee" size="3" required="required" /><br>
            <label for="TxtEtape">Étape : </label>
            <input type="number" id="Txtetape" name="Txtetape" size="3" required="required" /><br>
            <label for="TxtKm">Km : </label>
            <input type="number" id="TxtKm" name="TxtKm" size="3" required="required" /><br>
            <br>
            <input type="submit" id="soumettre" name="soumettre" value="Soumettre la requête" />
    </body>
</html>