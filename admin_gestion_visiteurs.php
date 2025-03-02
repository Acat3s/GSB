<?php
// admin_gestion_visiteurs.php
session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
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

// Initialisation des variables
$idVisiteur = $nom = $prenom = $adresse = $ville = $codePostal = $dateEmbauche = $login = $motDePasse = '';
$mode = 'ajouter'; // Par défaut, on est en mode ajout

// Si on modifie un visiteur, charger les données
if (isset($_GET['idVisiteur'])) {
    $idVisiteur = $_GET['idVisiteur'];
    $sql = "SELECT * FROM Visiteur WHERE idVisiteur = :idVisiteur";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idVisiteur' => $idVisiteur]);
    $visiteur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($visiteur) {
        $nom = $visiteur['nom'];
        $prenom = $visiteur['prenom'];
        $adresse = $visiteur['adresse'];
        $ville = $visiteur['ville'];
        $codePostal = $visiteur['codePostal'];
        $dateEmbauche = $visiteur['dateEmbauche'];
        $login = $visiteur['login'];
        $motDePasse = $visiteur['motDePasse'];
        $mode = 'modifier';
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idVisiteur = $_POST['idVisiteur'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $ville = $_POST['ville'] ?? '';
    $codePostal = $_POST['codePostal'] ?? '';
    $dateEmbauche = $_POST['dateEmbauche'] ?? '';
    $login = $_POST['login'] ?? '';
    $motDePasse = $_POST['motDePasse'] ?? '';

    if ($mode === 'ajouter') {
        $sql = "INSERT INTO Visiteur (nom, prenom, adresse, ville, codePostal, dateEmbauche, login, motDePasse) VALUES (:nom, :prenom, :adresse, :ville, :codePostal, :dateEmbauche, :login, MD5(:motDePasse))";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => $ville,
            'codePostal' => $codePostal,
            'dateEmbauche' => $dateEmbauche,
            'login' => $login,
            'motDePasse' => $motDePasse
        ]);
    } elseif ($mode === 'modifier') {
        $sql = "UPDATE Visiteur SET nom = :nom, prenom = :prenom, adresse = :adresse, ville = :ville, codePostal = :codePostal, dateEmbauche = :dateEmbauche, login = :login, motDePasse = MD5(:motDePasse) WHERE idVisiteur = :idVisiteur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,
            'ville' => $ville,
            'codePostal' => $codePostal,
            'dateEmbauche' => $dateEmbauche,
            'login' => $login,
            'motDePasse' => $motDePasse,
            'idVisiteur' => $idVisiteur
        ]);
    }

    header('Location: admin_liste_visiteurs.php');
    exit;
}

// Réinitialisation des champs
if (isset($_POST['reset'])) {
    $idVisiteur = $nom = $prenom = $adresse = $ville = $codePostal = $dateEmbauche = $login = $motDePasse = '';
    $mode = 'ajouter';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des visiteurs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Gestion des visiteurs</h1>
    <form method="post" action="">
        <input type="hidden" name="idVisiteur" value="<?= htmlspecialchars($idVisiteur, ENT_QUOTES, 'UTF-8') ?>">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($adresse, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($ville, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="codePostal">Code postal :</label>
        <input type="text" id="codePostal" name="codePostal" value="<?= htmlspecialchars($codePostal, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="dateEmbauche">Date d'embauche :</label>
        <input type="date" id="dateEmbauche" name="dateEmbauche" value="<?= htmlspecialchars($dateEmbauche, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="login">Login :</label>
        <input type="text" id="login" name="login" value="<?= htmlspecialchars($login, ENT_QUOTES, 'UTF-8') ?>" required><br>

        <label for="motDePasse">Mot de passe :</label>
        <input type="password" id="motDePasse" name="motDePasse" value="" required><br>

        <?php if ($mode === 'ajouter') : ?>
            <button type="submit">Ajouter</button>
        <?php else : ?>
            <button type="submit">Modifier</button>
        <?php endif; ?>
        <button type="submit" name="reset">Réinitialiser</button>
    </form>
</body>
</html>
