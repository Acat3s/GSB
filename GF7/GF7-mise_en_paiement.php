<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

session_start();

//Connexion a la base de donnee
$cnxBDD = connexion();

$sql = "UPDATE FicheFrais SET idEtat = 'RB' WHERE idEtat = 'VA';";
$result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

if ($result == true){
    echo "Mise en paiement effectué avec succès !";
} else {
    echo "Échec de la mise en paiement, veuillez réessayer.";
}

$cnxBDD->close();