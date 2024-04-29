# CROPSWAP

## Description
Cropswap est un projet modeste de partage de ressources de potagers entre utilisateurs. Ce projet me sert avant tout à continuer de m'améliorer en développement web, et à me familiariser avec les technologies actuelles.

## Technologies

- **Frontend**: VueJS, Vite, TailwindCSS
- **Backend**: Laravel, PHP, MySQL

## Installation

### Prérequis

- PHP 8.0
- Composer
- NodeJS
- MySQL

### Installation

1. Cloner le projet
2. Installer les dépendances PHP
    ```bash
    composer install
    ```
3. Installer les dépendances JS
    ```bash
    npm install
    ```
4. Créer un fichier `.env` à partir du fichier `.env.example`
5. Générer une clé d'application
    ```bash
    php artisan key:generate
    ```
6. Créer une base de données MySQL
7. Mettre à jour les informations de connexion à la base de données dans le fichier `.env`
8. Exécuter les migrations
    ```bash
    php artisan migrate
    ```
9. Exécuter les seeders
    ```bash
    php artisan db:seed
    ```
   
### Fin installation et Environnement de développement

10. Lancer le serveur
    ```bash
    php artisan serve
    ```
11. Lancer le serveur websocket
    ```bash
    php artisan reverb:start
    ```
12. Lancer le gestionnaire de jobs
    ```bash
    php artisan queue:work
    ```
13. Lancer le compilateur JS Vite
    ```bash
    npm run dev
    ```
    
