<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion visiteur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Connexion VISITEUR</h1>
    <form method="post" action="test_loginvisiteur.php">
        <label for="login">Login :</label>
        <input type="text" id="login" name="login" required><br>

        <label for="motDePasse">Mot de passe :</label>
        <input type="password" id="motDePasse" name="motDePasse" required><br>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
