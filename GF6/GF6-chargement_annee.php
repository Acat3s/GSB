<?php
ini_set('display_errors', 1);
include '/var/www/html/MEDINOV/depot/BD/fonction_BD_GSB.php';
// Vérifier si le paramètre idvis est passé via la requête GET
if (isset($_POST['idvis'])) {
    $idvis = $_POST['idvis'];  // Récupérer la valeur de idvis passée par AJAX

    //Connexion à la base de données
    $cnxBDD = connexion();

    // Exécuter une requête pour récupérer les années des fiches de frais associées à ce visiteur
    $sql = "SELECT annee FROM FicheFrais WHERE idVisiteur LIKE '%$idvis'";
    $result = $cnxBDD->query($sql) or die("Erreur de requête : " . $cnxBDD->error);

    // Initialiser les variables pour les années minimales et maximales
    $anneemin = 3000;
    $anneemax = 0;

    // Parcourir les années récupérées pour établir les plages
    while($row = $result->fetch_assoc()) {
        $annee = $row['annee'];
        if ($annee < $anneemin) {
            $anneemin = $annee;
        }
        if ($annee > $anneemax) {
            $anneemax = $annee;
        }
    }

    // Générer dynamiquement les options d'années dans la plage définie
    for ($i = $anneemin; $i <= $anneemax; $i++) {
        echo "<option value='$i'>$i</option>";
    }
}
?>