<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Suivi d'une fiche de frais</title>
        <style>
            table {
                border: 1px solid black; /* Définir la bordure du tableau */
                border-collapse: collapse; /* Fusionne les bordures pour éviter les espaces */
            }
            td {
                border: 1px solid black; /* Bordure autour des cellules */
                padding: 2px; /* Espace à l'intérieur de la cellule */
                text-align: center; /* Centre le texte horizontalement */
            }
            h1 {
            display: inline; /* Empêche le saut de ligne */
            margin: 0; /* Supprime les marges par défaut */
            }
        </style>
    </head>
    <body>
        <?php
            ini_set('display_errors', 1);

            //Début de la session
            session_start();

            //Déclaration des variables
            $idvis="GUEZENOC";
            $mois=12;
            $annee=2024;
            $repas=2;
            $nuitee=1;
            $etape=1;
            $km=80;
            $situation="Remboursé";
            $dateope="2024-12-10";
            $remb=638.12;
        ?>
        <p>Fiche de frais de : <?php echo $idvis; ?></p>
        <p><h1>Période</h1> | Mois/Année : <?php echo $mois."/".$annee; ?></p>
        <p>Frais au Forfait</p>

        <!-- Affichage des informations de la fiche de frais -->
        <table>
            <tr>
                <td>Repas Midi</td>
                <td>Nuitée</td>
                <td>Étape</td>
                <td>Km</td>
                <td>Situation</td>
                <td>Date Opération</td>
                <td>Remboursement</td>
            </tr>
            <tr>
                <td><?php echo $repas; ?></td>
                <td><?php echo $nuitee; ?></td>
                <td><?php echo $etape; ?></td>
                <td><?php echo $km; ?></td>
                <td><?php echo $situation; ?></td>
                <td><?php echo $dateope; ?></td>
                <td><?php echo $remb; ?></td>
            </tr>
        </table>

        <!-- Bouton pour retourner à la page précédente -->
        <button onclick="window.history.back();">Retour</button>
    </body>
</html>