<?php
ini_set('display_errors', 1);
include 'fonction_BD_GSB.php';

//Connexion a la base de donnees
$cnxBDD = connexion();

//Recuperation des requetes dans les variables
$sql1 = sql1();
$sql2 = sql2();
$sql3 = sql3();
$sql4 = sql4();
$sql5 = sql5();
$sql6 = sql6();
$sql7 = sql7();
$sql8 = sql8();

//Execution des requetes SQL
//Requete de creation de la table Forfait
if ($cnxBDD->query($sql1) === TRUE) {
    echo "Table 'Forfait' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'Forfait': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table Etat
if ($cnxBDD->query($sql2) === TRUE) {
    echo "Table 'Etat' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'Etat': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table LigneFraisForfait
if ($cnxBDD->query($sql3) === TRUE) {
    echo "Table 'LigneFraisForfait' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'LigneFraisForfait': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table FicheFrais
if ($cnxBDD->query($sql4) === TRUE) {
    echo "Table 'FicheFrais' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'FicheFrais': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table Visiteur
if ($cnxBDD->query($sql5) === TRUE) {
    echo "Table 'Visiteur' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'Visiteur': " . $cnxBDD->error . "<br>";
}

//Requete de creation de la table Visiteur
if ($cnxBDD->query($sql6) === TRUE) {
    echo "Table 'Comptable' créée avec succès.<br>";
} else {
    echo "Erreur lors de la création de la table 'Comptable': " . $cnxBDD->error . "<br>";
}

//Requete de remplissage de la table Etat (a n'utiliser que pour l'initialisation de la BDD)
/*
if ($cnxBDD->query($sql7) === TRUE) {
    echo "Table 'Etat' remplie avec succès.<br>";
} else {
    echo "Erreur lors du remplissage de la table 'Etat': " . $cnxBDD->error . "<br>";
}
*/

//Requete de remplissage de la table Forfait (a n'utiliser que pour l'initialisation de la BDD)
/*
if ($cnxBDD->query($sql8) === TRUE) {
    echo "Table 'Forfait' remplie avec succès.<br>";
} else {
    echo "Erreur lors du remplissage de la table 'Forfait': " . $cnxBDD->error . "<br>";
}
*/

//Deconnexion de la base de donnee
$cnxBDD->close();

?>