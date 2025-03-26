[![forthebadge](https://forthebadge.com/images/badges/powered-by-coffee.svg)](https://forthebadge.com)

# Mission - Créez une plateforme de gestion de projet avec Symfony

## Contenu:

Développeur PHP au sein de l’entreprise BeWize, vous avez récemment travaillé sur la conception d’un outil de gestion de projet interne : TaskLinker. Dans ce cadre, vous avez conçu un modèle physique de données en préparation du développement du projet.

### Fonctionnalités principales

-   Gestion des projets et des employés.
-   Création et suivi des tâches avec des statuts et des tags.
-   Gestion des créneaux horaires pour les tâches.

## Technologies utilisées

-   **PHP** : v8.3.14
-   **Symfony** : v5.11.0
-   **MySQL** : v5.7 ou supérieur
-   **Composer** : v2 ou supérieur
-   **Faker** : Génération de données fictives pour les tests

## Installation et utilisation

### Récupérez le projet :

Clonez le dépôt :

```bash
git clone https://github.com/LB-Squishy/P8-TaskLinker.git
cd P8-TaskLinker
```

### Installation :

Installez les dépendances avec Composer:

```bash
composer install
```

Configurez les variables d'environnement:

```bash
cp .env .env.local
```

-> DATABASE_URL="mysql://username:password@127.0.0.1:3306/tasklinker"

### Création de la base de donnée :

Créez la base de données:

```bash
php bin/console doctrine:database:create
```

Executez les migrations pour créer les tables:

```bash
php bin/console doctrine:migrations:migrate
```

Alimentez la base de donnée:

```bash
php bin/console doctrine:fixtures:load
```

### Lancement serveur :

Démarrez le serveur Symfony pour accéder à l'application en local :

```bash
symfony server:start
```
