<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier une nouvelle fiche de frais</title>
</head>
<body>
    <?php
    ini_set('display_errors', 1);
    include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

    session_start();
        
    //Recuperation de l'id du visiteur, du mois et de l'annee de la fiche a modifier
    $idvis = $_SESSION['username'];
    $mois = 11;
    $annee = 2024;

    //Connexion a la base de donnees
    $cnxBDD = connexion();

    //Recherche de l'identifiant de la fiche de frais
    $sql1 = "SELECT id FROM FicheFrais WHERE idVisiteur='$idvis' AND mois=$mois AND annee=$annee";
    $result = $cnxBDD->query($sql1) or die (afficheErreur($sql1, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row = mysqli_fetch_assoc($result);
    $idFicheFrais = $row['id'];

    //Recherche des frais enregistrees sur la fiche
    //Recuperation de la quantite de frais de repas
    $sql2 = "SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='REP'";
    $result = $cnxBDD->query($sql2) or die (afficheErreur($sql2, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row = mysqli_fetch_assoc($result);
    $nbREP = $row['quantite'];

    //Recuperation de la quantite de frais de nuit
    $sql3 = "SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='NUI'";
    $result = $cnxBDD->query($sql3) or die (afficheErreur($sql3, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row = mysqli_fetch_assoc($result);
    $nbNUI = $row['quantite'];

    //Recuperation de la quantite de frais d'etape
    $sql4 = "SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='ETP'";
    $result = $cnxBDD->query($sql4) or die (afficheErreur($sql4, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row = mysqli_fetch_assoc($result);
    $nbETP = $row['quantite'];

    //Recuperation de la quantite de frais de kilometrage
    $sql5 = "SELECT quantite FROM LigneFraisForfait WHERE idFicheFrais=$idFicheFrais AND idForfait='KM'";
    $result = $cnxBDD->query($sql5) or die (afficheErreur($sql5, $cnxBDD->error_list[0]['error']));

    //Recuperation du resultat dans la variable row
    $row = mysqli_fetch_assoc($result);
    $nbKM = $row['quantite'];

    //Deconnexion de la base de donnee
    $cnxBDD->close();

    //Recuperation de la variable $idFicheFrais dans une variable de session
    $_SESSION['idFicheFrais']=$idFicheFrais;
?>
    <form action="GF4-code_modifier_une_fiche_de_frais.php" method="get">
        <label for="annee">Année : </label>
        <input type="text" id="annee" name="annee" value=<?php echo $annee; ?> disabled="disabled" size="2" />
        <label for="mois">Mois : </label>
        <input type="text" id="mois" name="mois" value=<?php echo $mois; ?> disabled="disabled" size="2" /><br>
        <br>
        <br>
        <label for="Txtrepas">Repas midi : </label>
        <input type="number" id="Txtrepas" name="Txtrepas" value=<?php echo $nbREP;?> /><br>
        <label for="Txtnuitee">Nuitée : </label>
        <input type="number" id="Txtnuitee" name="Txtnuitee" value=<?php echo $nbNUI;?> /><br>
        <label for="TxtEtape">Étape : </label>
        <input type="number" id="Txtetape" name="Txtetape" value=<?php echo $nbETP;?> /><br>
        <label for="TxtKm">Km : </label>
        <input type="number" id="TxtKm" name="TxtKm" value=<?php echo $nbKM;?> /><br>
        <br>
        <input type="submit" id="soumettre" name="soumettre" value="Soumettre la requête" />
    </form>
</body>
</html>
