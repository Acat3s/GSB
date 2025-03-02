<?php
// admin_liste_visiteurs.php
session_start();

// Activer l'affichage des erreurs pour d�boguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// V�rifier si l'utilisateur est administrateur
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Connexion � la base de donn�es
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

// R�cup�rer tous les visiteurs tri�s par nom, puis pr�nom
$sql = "SELECT * FROM Visiteur ORDER BY nom, prenom";
$stmt = $pdo->query($sql);
$visiteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gestion de la suppression d'un visiteur
if (isset($_GET['supprimer'])) {
    $idVisiteur = $_GET['supprimer'];
    $sql = "DELETE FROM Visiteur WHERE idVisiteur = :idVisiteur";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idVisiteur' => $idVisiteur]);

    header('Location: admin_liste_visiteurs.php');
    exit;
}

// Gestion de la cl�ture des fiches de frais
if (isset($_GET['cloturer'])) {
    $idVisiteur = $_GET['cloturer'];
    try {
        $sql = "UPDATE FicheFrais SET etat = 'Cl�tur�e' WHERE idVisiteur = :idVisiteur AND etat = 'En cours'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['idVisiteur' => $idVisiteur]);
    } catch (PDOException $e) {
        die("Erreur lors de la mise � jour des fiches de frais : " . $e->getMessage());
    }

    header('Location: admin_liste_visiteurs.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des visiteurs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Liste des visiteurs</h1>
    <a href="admin_gestion_visiteurs.php" class="add-button">Ajouter un visiteur</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Pr�nom</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code postal</th>
                <th>Date d'embauche</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($visiteurs)) : ?>
                <tr>
                    <td colspan="8">Aucun visiteur trouv�.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($visiteurs as $visiteur) : ?>
                    <tr>
                        <td><?= htmlspecialchars($visiteur['idVisiteur'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['prenom'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['adresse'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['ville'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['codePostal'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($visiteur['dateEmbauche'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="admin_gestion_visiteurs.php?idVisiteur=<?= $visiteur['idVisiteur'] ?>">Modifier</a> |
                            <a href="?supprimer=<?= $visiteur['idVisiteur'] ?>" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a> |
                            <a href="?cloturer=<?= $visiteur['idVisiteur'] ?>" onclick="return confirm('Cl�turer toutes les fiches de frais en cours ?');">Cl�turer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
