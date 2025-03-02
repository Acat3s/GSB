<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'entente.html'; ?>
    <div>
        <?php
            echo "Erreur de connexion. Vérifiez les informations saisies puis réessayez.";
            $maPage = $_REQUEST['page'];
		        switch($maPage) {
                    case '1':{ include "loginadmin.php"; break; }
                    case '2':{ include "logincomptable.php"; break; }
                    case '3':{ include "loginvisiteur.php"; break; }
                    default :{ include "loginvisiteur.php"; break; }
			    }
        ?>
    </div>
</body>
</html>