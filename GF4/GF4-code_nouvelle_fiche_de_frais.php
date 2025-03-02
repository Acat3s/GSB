<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

session_start();

//Recuperation de l'id du visiteur dans la variable
$idvis = $_SESSION['username'];

//Recuperation des montants des forfaits
//Connexion a la base de donnees
$cnxBDD = connexion();

//Execution de la requete pour recuperer le montant du forfait de ETP
$sql2 = "SELECT montant FROM Forfait WHERE id='ETP';";
$result = $cnxBDD->query($sql2) or die (afficheErreur($sql2, $cnxBDD->error_list[0]['error']));

//Recuperation du resultat dans la variable row
$row = mysqli_fetch_assoc($result);
$forfaitETP = $row['montant'];

//Execution de la requete pour recuperer le montant du forfait de KM
$sql3 = "SELECT montant FROM Forfait WHERE id='KM';";
$result = $cnxBDD->query($sql3) or die (afficheErreur($sql3, $cnxBDD->error_list[0]['error']));

//Recuperation du resultat dans la variable row
$row = mysqli_fetch_assoc($result);
$forfaitKM = $row['montant'];


//Execution de la requete pour recuperer le montant du forfait de NUI
$sql4 = "SELECT montant FROM Forfait WHERE id='NUI';";
$result = $cnxBDD->query($sql4) or die (afficheErreur($sql4, $cnxBDD->error_list[0]['error']));

//Recuperation du resultat dans la variable row
$row = mysqli_fetch_assoc($result);
$forfaitNUI = $row['montant'];


//Execution de la requete pour recuperer le montant du forfait de REP
$sql5 = "SELECT montant FROM Forfait WHERE id='REP';";
$result = $cnxBDD->query($sql5) or die (afficheErreur($sql5, $cnxBDD->error_list[0]['error']));

//Recuperation du resultat dans la variable row
$row = mysqli_fetch_assoc($result);
$forfaitREP = $row['montant'];

//Deconnexion de la base de donnee
$cnxBDD->close();

//Recuperation des valeurs du formulaire dans les variables
$annee = date("Y");
$mois = date("m");
$nbREP = $_GET['Txtrepas'];
$nbNUI = $_GET['Txtnuitee'];
$nbETP = $_GET['Txtetape'];
$nbKM = $_GET['TxtKm'];

//Recuperation de la date du jour pour l'enregistrer en tant que derniere date de modification
$datemodif = date('Y-m-d');

//Calcul du nombre de justificatifs enregistres
//Initialiation de la variable
$nbJustificat = 0;

if($nbREP != 0){
    $nbJustificat += 1;
}
if($nbNUI != 0){
    $nbJustificat += 1;
}
if($nbETP != 0){
    $nbJustificat += 1;
}
if($nbKM != 0){
    $nbJustificat += 1;
}

//Calcul du montant de chaque justificatif individuellement
$montantREP = $nbREP * $forfaitREP;
$montantNUI = $nbNUI * $forfaitNUI;
$montantETP = $nbETP + $forfaitETP;
$montantKM = $nbKM * $forfaitKM;

//Calcul des remboursements
$remb = $montantETP + $montantKM + $montantNUI + $montantREP;

//Test si la variable qui compte le nombre de justificatifs est nulle, si le test echoue, insertion des valeurs dans la base de donnees
if($nbJustificat == 0){
    echo "Erreur de saisie, aucune valeur enregistrée. Veuillez recommencer.";
} else {
    //Connexion a la base de donnees
    $cnxBDD = connexion();

    //Insertion des valeurs dans la table FicheFrais
    $sql6 = "INSERT INTO FicheFrais(idVisiteur, mois, annee, nbJustificatifs, montantValide, dateModif, idEtat) VALUES ('$idvis', $mois, $annee, $nbJustificat, $remb, '$datemodif', 'CR');";

    if ($cnxBDD->query($sql6) == TRUE) {
        echo "Insertion dans la table Fiche Frais validée.<br>";
    } else {
        echo "Erreur lors de l'insertion dans la table FicheFrais. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Recuperation de l'id de la nouvelle fiche creee
    $sql7 = "SELECT id FROM FicheFrais WHERE idVisiteur='$idvis' AND mois=$mois AND annee=$annee;";
    $lignes = $cnxBDD->query($sql7) or die (afficheErreur($sql7, $cnxBDD->error_list[0]['error']));

    foreach ($lignes as $maligne)
    {
        //Recuperation du montant du forfait ETP dans la variable
        $idNouvelleFiche=$maligne['id'];
    }

    //Insertion des frais REP dans la table LigneFraisForfait
    $sql8 = "INSERT INTO LigneFraisForfait VALUES ($idNouvelleFiche, 'REP', $nbREP);";

    if ($cnxBDD->query($sql8) == TRUE) {
        echo "Insertion des frais REP dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais REP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais NUI dans la tableau LigneFraisForfait
    $sql9 = "INSERT INTO LigneFraisForfait VALUES ($idNouvelleFiche, 'NUI', $nbNUI);";

    if ($cnxBDD->query($sql9) == TRUE) {
        echo "Insertion des frais NUI dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais NUI dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais ETP dans la tableau LigneFraisForfait
    $sql10 = "INSERT INTO LigneFraisForfait VALUES ($idNouvelleFiche, 'ETP', $nbETP);";

    if ($cnxBDD->query($sql10) == TRUE) {
        echo "Insertion des frais ETP dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais ETP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais KM dans la tableau LigneFraisForfait
    $sql11 = "INSERT INTO LigneFraisForfait VALUES ($idNouvelleFiche, 'KM', $nbKM);";

    if ($cnxBDD->query($sql11) == TRUE) {
        echo "Insertion des frais KM dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais KM dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Deconnexion de la base de donnee
    $cnxBDD->close();
}

?>