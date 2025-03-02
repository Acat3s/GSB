<?php
/*
// ajouterFicheFrais.php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=TestMedinov;charset=utf8mb4';
$username = 'root';
$password = 'Iroise29';
try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
    ]);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Ajouter une fiche de frais
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mois = $_POST['mois'] ?? '';
    $annee = $_POST['annee'] ?? '';
    $montantTotal = $_POST['montantValide'] ?? '';
    $etat = 'En cours';

    if ($mois && $annee && $montantTotal) {
        $sql = "INSERT INTO FicheFrais (idVisiteur, mois, annee, montantValide, idEtat) VALUES (:idVisiteur, :mois, :annee, :montantValide, :idEtat)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $_SESSION['id'],
            'mois' => $mois,
            'annee' => $annee,
            'montantTotal' => $montantTotal,
            'idEtat' => $etat
        ]);

        header('Location: affichageFichesFrais.php');
        exit;
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une fiche de frais</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Ajouter une fiche de frais</h1>
    <?php if (isset($erreur)) : ?>
        <p class="error-message"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="mois">Mois :</label>
        <input type="number" id="mois" name="mois" min="1" max="12" required><br>

        <label for="annee">Année :</label>
        <input type="number" id="annee" name="annee" min="2000" max="2100" required><br>

        <label for="montantTotal">Montant Total :</label>
        <input type="number" id="montantTotal" name="montantTotal" step="0.01" required><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
