<?php
// affichageFichesFrais.php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idVisiteur'])) {
    header('Location: login.php');
    exit;
}

// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=Dieu;charset=utf8mb4';
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

// Récupérer les fiches de frais du visiteur connecté
$idVisiteur = $_SESSION['idVisiteur'];
$sql = "SELECT * FROM FicheFrais WHERE idVisiteur = :idVisiteur ORDER BY annee DESC, mois DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['idVisiteur' => $idVisiteur]);
$fiches = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gestion de la déconnexion
if (isset($_GET['deconnexion'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vos fiches de frais</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['prenom'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($_SESSION['nom'], ENT_QUOTES, 'UTF-8') ?> !</h1>
    <a href="?deconnexion=true" class="logout-button">Se déconnecter</a>
    <h2>Vos fiches de frais</h2>
    <a href="ajouterFicheFrais.php" class="add-button">Ajouter une fiche de frais</a>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Montant Total</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($fiches)) : ?>
                <tr>
                    <td colspan="4">Aucune fiche de frais trouvée.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($fiches as $fiche) : ?>
                    <tr>
                        <td><?= htmlspecialchars($fiche['mois'] . '/' . $fiche['annee'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= number_format($fiche['montantTotal'], 2, ',', ' ') ?> €</td>
                        <td><?= htmlspecialchars($fiche['etat'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="voir.php?id=<?= $fiche['idFicheFrais'] ?>">Voir</a>
                            <?php if ($fiche['etat'] === 'En cours' || $fiche['etat'] === 'Non valide') : ?>
                                | <a href="modifier.php?id=<?= $fiche['idFicheFrais'] ?>">Modifier</a>
                                | <a href="supprimer.php?id=<?= $fiche['idFicheFrais'] ?>" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
