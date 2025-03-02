<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

session_start();

//Recuperation des variables de session
$idvis = $_SESSION['username'];
$idFicheFrais = $_SESSION['idFicheFrais'];

//Connexion a la base de donnee
$cnxBDD = connexion();

//Recuperation des montants des forfaits
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

//Recuperation des nouvelles valeurs dans les variables
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

//Finir le script de modification de valeur dans la base
//Calcul du nouveau montant de remboursement a renregistrer
$remb = $montantETP + $montantKM + $montantNUI + $montantREP;

//Test si la variable qui compte le nombre de justificatifs est nulle, si le test echoue, insertion des valeurs dans la base de donnees
if($nbJustificat == 0){
    echo "Erreur de saisie, aucune valeur enregistrée. Veuillez recommencer.";
} else {
    //Connexion a la base de donnees
    $cnxBDD = connexion();

    //Insertion des valeurs dans la table FicheFrais
    $sql6 = "UPDATE FicheFrais SET nbJustificatifs=$nbJustificat, montantValide=$remb, dateModif='$datemodif' WHERE id=$idFicheFrais";

    if ($cnxBDD->query($sql6) == TRUE) {
        echo "Insertion dans la table Fiche Frais validée.<br>";
    } else {
        echo "Erreur lors de l'insertion dans la table FicheFrais. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Mise à jour des frais REP dans la table LigneFraisForfait
    $sql8 = "UPDATE LigneFraisForfait SET quantite=$nbREP WHERE idFicheFrais='$idFicheFrais' AND idForfait='REP';";

    if ($cnxBDD->query($sql8) == TRUE) {
        echo "Insertion des frais REP dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais REP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais NUI dans la tableau LigneFraisForfait
    $sql9 = "UPDATE LigneFraisForfait SET quantite=$nbNUI WHERE idFicheFrais='$idFicheFrais' AND idForfait='NUI';";

    if ($cnxBDD->query($sql9) == TRUE) {
        echo "Insertion des frais NUI dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais NUI dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais ETP dans la tableau LigneFraisForfait
    $sql10 = "UPDATE LigneFraisForfait SET quantite=$nbETP WHERE idFicheFrais='$idFicheFrais' AND idForfait='ETP';";

    if ($cnxBDD->query($sql10) == TRUE) {
        echo "Insertion des frais ETP dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais ETP dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Insertion des frais KM dans la tableau LigneFraisForfait
    $sql11 = "UPDATE LigneFraisForfait SET quantite=$nbKM WHERE idFicheFrais='$idFicheFrais' AND idForfait='KM';";

    if ($cnxBDD->query($sql11) == TRUE) {
        echo "Insertion des frais KM dans la table LigneFraisForfait validée.<br>";
    } else {
        echo "Erreur lors de l'insertion des frais KM dans la table LigneFraisForfait. Veuillez vérifier les informations saisies puis essayez à nouveau.". $cnxBDD->error . "<br>";
    }

    //Deconnexion de la base de donnee
    $cnxBDD->close();
}

?>