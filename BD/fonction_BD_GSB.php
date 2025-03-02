<?php
ini_set('display_errors', 1);

//Fonction qui permet de se connecter a la base de donnees
function connexion(){
  $host = "localhost";
  $user = "root";
  $password = "Iroise29";
  $dbname = "TestMedinov";

  $mysqli = new mysqli($host, $user, $password, $dbname);
  if ($mysqli->connect_errno) {
      echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      return($mysqli->connect_errno);
  }
  return $mysqli;
}

//Fonction qui permet de creer la table Visiteur
function sql1(){
  $sql1="CREATE TABLE IF NOT EXISTS Visiteur (
    id varchar(60) NOT NULL,
    nom varchar(60),
    prenom varchar(60),
    adresse varchar(250),
    cp char(5),
    ville char(50),
    dateEmbauche date,
    vis_mdp varchar(60),
    PRIMARY KEY (id)
  ) ENGINE=InnoDB;";

  return $sql1;
}

//Fonction qui permet de creer la table Etat
function sql2(){
  $sql2="CREATE TABLE IF NOT EXISTS Etat (
    id char(2) NOT NULL,
    libelle varchar(30) DEFAULT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB;";

  return $sql2;
}

//Fonction qui permet de creer la table FicheFrais
function sql3(){
  $sql3="CREATE TABLE IF NOT EXISTS FicheFrais (
    id int(11) NOT NULL AUTO_INCREMENT,
    idVisiteur varchar(60) DEFAULT NULL,
    mois tinyint(2) unsigned DEFAULT NULL,
    annee int(4) unsigned DEFAULT NULL,
    nbJustificatifs int(11) DEFAULT NULL,
    montantValide decimal(10,2) DEFAULT NULL,
    dateModif date DEFAULT NULL,
    idEtat char(2) DEFAULT NULL,
    PRIMARY KEY (idVisiteur, mois, annee),
    UNIQUE (id),
    CONSTRAINT fk_Visiteur FOREIGN KEY (idVisiteur) REFERENCES Visiteur(id),
    CONSTRAINT fk_Etat FOREIGN KEY (idEtat) REFERENCES Etat(id)
  ) ENGINE=InnoDB;";

  return $sql3;
}

//Fonction qui permet de creer la table Forfait
function sql4(){
  $sql4="CREATE TABLE IF NOT EXISTS Forfait (
    id varchar(3) NOT NULL,
    libelle varchar(20) DEFAULT NULL,
    montant decimal(5,2) DEFAULT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB;";

  return $sql4;
}

//Fonction qui permet de creer la table LigneFraisForfait
function sql5(){
  $sql5="CREATE TABLE IF NOT EXISTS LigneFraisForfait (
    idFicheFrais int(11) NOT NULL,
    idForfait varchar(3) DEFAULT NULL,
    quantite int(11) DEFAULT NULL,
    PRIMARY KEY (idFicheFrais, idForfait),
    CONSTRAINT fk_Forfait FOREIGN KEY (idForfait) REFERENCES Forfait(id),
    CONSTRAINT fk_FicheFrais FOREIGN KEY (idFicheFrais) REFERENCES FicheFrais(id)
  ) ENGINE=InnoDB;";

  return $sql5;
}

//Fonction qui permet de creer la table Comptable
function sql6(){
  $sql6="CREATE TABLE Comptable (
   id int(11) AUTO_INCREMENT,
   nom varchar(30) NOT NULL,
   prenom varchar(30) NOT NULL,
   comptable_id varchar(30) NOT NULL,
   comptable_mdp varchar(60) NOT NULL,
   PRIMARY KEY (id)
  ) ENGINE=InnoDB;";

  return $sql6;
}

//Fonction qui permet de remplir la table Etat
function sql7(){
  $sql7="INSERT INTO Etat (id, libelle) VALUES
    ('RB', 'Remboursee'),
    ('CL', 'Saisie Cloturee'),
    ('CR', 'Fiche creee, saisie en cours'),
    ('VA', 'Validee et mise en paiement');";

  return $sql7;
}

//Fonction qui permet de remplir la table Forfait
function sql8(){
  $sql8="INSERT INTO Forfait (id, libelle, montant) VALUES
    ('ETP', 'Forfait Etape', 110.00),
    ('KM', 'Frais Kilometrique', 0.62),
    ('NUI', 'Nuitee Hotel', 80.00),
    ('REP', 'Repas Restaurant', 25.00);";

  return $sql8;
}