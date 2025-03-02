<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';

//Debut de la session
session_start();

//Enregistrement des identifiants de connexion de l'admin
$id_admin = "admin";
$pwd_admin = "MedInov";

//Recuperation des variables de connexion
$id = $_POST['login'];
$mdp = $_POST['motDePasse'];

//Test si l'id et le mot de passe correspondent a ceux de l'admin
if($id === $id_admin and $mdp === $pwd_admin){
    echo "Connexion reussie avec succes !";
    $_SESSION['username'] = $id_admin;
    //Si la connexion reussie, on redirige vers la page d'accueil de l'admin
    header('Location: (page d accueil de l admin)');
} else {
    header('Location: erreur_login.php');
}

$cnxBDD->close();