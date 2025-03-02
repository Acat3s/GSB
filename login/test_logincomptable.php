<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

session_start();

//Recuperation des variables de connexion
$login = $_POST['login'];
$motDePasse = $_POST['motDePasse'];

//Connexion a la base de donnees
$cnxBDD = connexion();

//Requete pour verifier les identifiants
$sql = "SELECT comptable_mdp FROM Comptable WHERE comptable_id='$login'";
$result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

$row = mysqli_fetch_assoc($result);
$pwd_comptable = $row['comptable_mdp'];

if($motDePasse === $pwd_comptable){
    echo "Connexion reussie avec succes !";
    $_SESSION['idcomptable'] = $login;
    //Si la connexion reussie, on redirige vers la page d'accueil
    header('Location: ../GF6/GF6-validation_fiche_de_frais.php');
} else {
    header('Location: erreur_login.php');
}

$cnxBDD->close();