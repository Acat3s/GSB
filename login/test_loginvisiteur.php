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
$sql = "SELECT vis_mdp FROM Visiteur WHERE id='$login'";
$result = $cnxBDD->query($sql) or die (afficheErreur($sql, $cnxBDD->error_list[0]['error']));

$row = mysqli_fetch_assoc($result);
$pwd_vis = $row['vis_mdp'];

if($motDePasse == $pwd_vis){
    echo "Connexion reussie avec succes !";
    $_SESSION['username'] = $login;
    //Si la connexion reussie, on redirige vers la page d'accueil
    header('Location: ../GF4/GF4-formulaire_nouvelle_fiche_de_frais.php');
} else {
    echo "Connexion echouee. Veuillez reessayer.";
}

$cnxBDD->close();