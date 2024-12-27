Gestion des Activités

Ce projet est une application de gestion des activités permettant d'ajouter, modifier, supprimer et afficher des activités depuis une base de données MySQL. Elle est développée en PHP avec l'utilisation de PDO pour la gestion des interactions avec la base de données.

Fonctionnalités

    + Affichage des Activités : Liste toutes les activités disponibles.
    + Ajout d'Activités : Permet d'ajouter de nouvelles activités avec leurs détails.
    + Modification des Activités : Permet de modifier les informations d'une activité existante.
    + Suppression des Activités : Permet de supprimer une activité de la base de données.

Prérequis

    + Serveur Web : Apache, Nginx ou tout autre serveur compatible PHP.
    + PHP : Version 7.4 ou supérieure.
    + Base de données : MySQL.
    + Bibliothèque : PDO activé dans PHP.

Installation
    Clonez ce dépôt sur votre serveur local :
        + git clone <URL_DU_DEPOT>
        + Importez le fichier database.sql dans votre base de données MySQL pour créer les tables nécessaires.
        + Configurez le fichier Config.php avec vos informations de connexion à la base de données .


Placez tous les fichiers dans le répertoire racine de votre serveur web.

Accédez à l'application via votre navigateur.

Utilisation

    + Affichage : Les activités sont affichées sur la page principale.
    + Ajout : Remplissez le formulaire d'ajout pour créer une nouvelle activité.
    + Modification : Cliquez sur "Modifier" pour changer les détails d'une activité.
    + Suppression : Cliquez sur "Supprimer" pour retirer une activité de la base de données.

Structure des fichiers

    + index.php : Point d'entrée principal de l'application.
    + Activite.php : Classe de gestion des activités.
    + Config.php : Configuration de la base de données.
    + styles/ : Contient les fichiers CSS.
    + scripts/ : Contient les fichiers JavaScript (si nécessaire).

Contribution
Les contributions sont les bienvenues. Si vous souhaitez améliorer ce projet, créez une branche, apportez vos modifications, et soumettez une pull request.

Licence
Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, de le modifier et de le distribuer sous les termes de cette licence.

Auteur
Développé par BAHSI Ilyas et ZEMMARI Azzedin.