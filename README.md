# cyber_games_arras-symfony-version

Projet étudiant pour le BTS SIO

## Description

Ce projet est une application Symfony conçue pour gérer un cyber centre de jeux. Il gère l'administration des ordinateurs, la liste des jeux, les réservations des utilisateurs et les tâches administratives. L'application fournit une interface conviviale pour les clients et les administrateurs.

## Fonctionnalités

L'application offre les fonctionnalités clés suivantes :

*   **Authentification et Autorisation des Utilisateurs :**
    *   Les utilisateurs peuvent s'inscrire et se connecter au système.
    *   Les administrateurs disposent de privilèges spéciaux pour gérer les ordinateurs, les jeux et les calendriers de maintenance.
    *   Une fonctionnalité de réinitialisation du mot de passe est implémentée.
*   **Gestion des Ordinateurs :**
    *   Les administrateurs peuvent ajouter, modifier et supprimer des ordinateurs.
    *   Chaque ordinateur possède des attributs tels que le nom, le processeur, la mémoire et la carte graphique.
*   **Gestion des Jeux :**
    *   Les administrateurs peuvent ajouter, modifier et supprimer des jeux.
    *   Les jeux ont des attributs tels que le titre, la description et l'image.
*   **Système de Réservation :**
    *   Les utilisateurs enregistrés peuvent réserver des ordinateurs pour des créneaux horaires spécifiques.
    *   Le système vérifie la disponibilité des ordinateurs et empêche les doubles réservations.
    *   Les réservations ont une heure de début, une heure de fin, et un utilisateur et un ordinateur associés.
*   **Planification de la Maintenance :**
    *   Les administrateurs peuvent planifier des tâches de maintenance pour les ordinateurs.
    *   Les enregistrements de maintenance comprennent l'ordinateur, la date et la description.
    *   Le système suit si une tâche de maintenance est terminée.
*   **Tournois :**
    *   Les administrateurs peuvent créer des tournois, en spécifiant le jeu, la date et le nombre maximum de participants.
    *   Les utilisateurs peuvent s'inscrire aux tournois.

## Flux de Travail

1.  **Inscription et Connexion de l'Utilisateur :** Les nouveaux utilisateurs peuvent créer des comptes via la page d'inscription. Les utilisateurs existants peuvent se connecter en utilisant leurs informations d'identification. Le système utilise le composant de sécurité de Symfony pour l'authentification et l'autorisation.
2.  **Navigation dans les Jeux :** Les utilisateurs peuvent consulter une liste des jeux disponibles.
3.  **Réservation d'un Ordinateur :**
    *   Les utilisateurs accèdent à la section de réservation.
    *   Ils sélectionnent un ordinateur et un créneau horaire.
    *   Le système vérifie la disponibilité de l'ordinateur.
    *   Si disponible, la réservation est confirmée et enregistrée.
4.  **Planification de la Maintenance (Admin) :**
    *   Les administrateurs accèdent à la section de maintenance.
    *   Ils sélectionnent un ordinateur, une date de maintenance et une description.
    *   La tâche de maintenance est planifiée et enregistrée.
5.  **Inscription au Tournoi :**
    *   Les utilisateurs peuvent consulter une liste des tournois à venir.
    *   Ils peuvent s'inscrire à un tournoi s'il y a des places disponibles.
6.  **Utilisation de l'API :**
    *   L'application fournit des points de terminaison API pour l'authentification et la gestion des réservations, potentiellement pour une utilisation par une application mobile.

## Flux de Données

1.  **Interaction de l'Utilisateur :** Les utilisateurs interagissent avec l'application via des pages web (templates Twig) rendues par les contrôleurs Symfony.
2.  **Logique du Contrôleur :** Les contrôleurs gèrent les requêtes des utilisateurs, traitent les données et interagissent avec la base de données.
3.  **Interaction avec la Base de Données :** Doctrine ORM est utilisé pour mapper les entités PHP aux tables de la base de données. Les contrôleurs utilisent des répertoires pour interroger et persister les données.
4.  **Persistance des Données :** Les données sont stockées dans une base de données MySQL. Le schéma de la base de données est géré à l'aide des migrations Doctrine.
5.  **Rendu :** Les templates Twig sont utilisés pour afficher les données à l'utilisateur.

## Considérations de Sécurité

*   **Authentification :** Le composant de sécurité de Symfony est utilisé pour gérer l'authentification et l'autorisation des utilisateurs.
*   **Autorisation :** Les listes de contrôle d'accès (ACL) sont utilisées pour restreindre l'accès à certaines fonctionnalités en fonction des rôles des utilisateurs (par exemple, ROLE\_ADMIN).
*   **Hachage des Mots de Passe :** Les mots de passe des utilisateurs sont hachés de manière sécurisée à l'aide de bcrypt.
*   **Protection CSRF :** Les jetons CSRF sont utilisés pour se protéger contre les attaques de falsification de requêtes intersites.
*   **Validation des Entrées :** Les formulaires sont validés pour empêcher les entrées malveillantes.

## Notes Additionnelles

*   L'application utilise Webpack pour gérer les assets (CSS, JavaScript).
*   Le fichier `.env` contient les paramètres de configuration spécifiques à l'environnement.
*   La commande `symfony server:start` peut être utilisée pour exécuter l'application localement.
*   Adminer ([`public/adminer.php`](public/adminer.php)) est inclus pour la gestion de la base de données.

## Tutoriel d'Installation

Suivez ces étapes pour installer et configurer le projet :

1.  **Prérequis :**
    *   PHP 8.1 ou supérieur
    *   Composer
    *   MySQL
    *   Node.js et npm

2.  **Cloner le dépôt :**

    ```bash
    git clone <repository_url>
    cd cyber_games_arras-symfony-version
    ```

3.  **Installer les dépendances Composer :**

    ```bash
    composer install
    ```

4.  **Configurer la base de données :**

    *   Créez une base de données nommée `cyber_games_arras` dans MySQL.
    *   Mettez à jour le fichier `.env` avec vos informations d'identification de base de données :

        ```properties
        DATABASE_URL="mysql://localhost:Doliprane8%@127.0.0.1:3306/cyber_games_arras?serverVersion=8.0.40&charset=utf8mb4"
        ```

5.  **Exécuter les migrations de la base de données :**

    ```bash
    php bin/console doctrine:migrations:migrate
    ```

6.  **Installer et compiler les assets :**

    ```bash
    npm install
    npm run build
    ```

7.  **Démarrer le serveur Symfony :**

    ```bash
    symfony server:start
    ```

    Ou en utilisant le serveur web intégré de PHP :

    ```bash
    php -S localhost:8000 -t public
    ```

8.  **Accéder à l'application :**

    Ouvrez votre navigateur web et accédez à `http://localhost:8000`.

9.  **Configurer l'utilisateur administrateur (optionnel) :**

    Vous devrez peut-être créer un utilisateur administrateur via la ligne de commande :

    ```bash
    php bin/console app:create-admin
    ```

    (Implémentez cette commande dans votre application si elle n'existe pas déjà).

10. **Accéder à Adminer (optionnel) :**

    Vous pouvez accéder à Adminer pour gérer votre base de données via `http://localhost:8000/adminer.php`.