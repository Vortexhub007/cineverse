# 🎬 CineVerse - Backend PHP/MySQL

## 📋 Description du projet

**CineVerse** est une application web full-stack permettant aux utilisateurs de gérer leur expérience cinématographique : inscription, connexion, gestion des favoris, watchlist et commentaires. Ce backend a été développé dans le cadre de l'évaluation ECF du titre professionnel Développeur Web et Web Mobile (DWWM).

L'application repose sur une architecture **PHP procédural** avec une base de données **MySQL**, une connexion via **PDO** et des pages d'authentification sécurisées.

🔗 **Frontend déployé** : [https://cineverse-valentinmartin.vercel.app/](https://cineverse-valentinmartin.vercel.app/)

---

## 🎯 Compétences visées

Ce projet démontre la maîtrise des compétences suivantes :

### 1. Concevoir et mettre en place une base de données relationnelle
- ✅ Rédaction du dictionnaire de données
- ✅ Modélisation MCD avec l'outil Looping
- ✅ Dérivation du MLD (Modèle Logique de Données)
- ✅ Script SQL complet avec `DROP TABLE IF EXISTS` et données `INSERT`
- ✅ Respect des contraintes d'intégrité (clés primaires, clés étrangères)

### 2. Développer des composants d'accès aux données
- ✅ Connexion PDO sécurisée avec variables d'environnement
- ✅ Fonctions CRUD procédurales avec requêtes préparées (`bindParam`)
- ✅ Hachage des mots de passe avec `password_hash()` / `password_verify()`
- ✅ Gestion des sessions PHP (`$_SESSION`)
- ✅ Protection contre les injections SQL

---

## 🗂️ Structure du projet

```
cineverse-php/
│
├── index.php                  # Redirection vers connexion ou accueil
│
├── auth/
│   ├── inscription.php        # Page d'inscription utilisateur
│   └── connexion.php          # Page de connexion utilisateur
│
├── includes/
│   ├── db.php                 # Connexion PDO (variables d'environnement)
│   └── functions.php          # Fonctions CRUD procédurales
│
├── sql/
│   └── cineverse_db.sql       # Script SQL (DROP, CREATE, INSERT)
│
├── merise/
│   ├── dictionnaire_donnees.md  # Dictionnaire de données
│   ├── mcd.loo                  # Fichier Looping (MCD)
│   └── mld.md                   # Modèle Logique de Données
│
├── css/
│   └── style.css              # Styles partagés (thème CineVerse)
│
├── .env.example               # Exemple de configuration des variables d'env
├── .gitignore                 # Fichiers exclus de Git
└── README-PHP.md              # Documentation (ce fichier)
```

---

## 🛠️ Technologies utilisées

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)
![PDO](https://img.shields.io/badge/PDO-777BB4?style=flat&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)
![Font Awesome](https://img.shields.io/badge/Font_Awesome-339AF0?style=flat&logo=fontawesome&logoColor=white)
![Google Fonts](https://img.shields.io/badge/Google_Fonts-4285F4?style=flat&logo=google&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=flat&logo=git&logoColor=white)

---

## 🗃️ Base de données — `cineverse_db`

### Schéma des tables

| Table        | Description                                      |
|--------------|--------------------------------------------------|
| `users`      | Comptes utilisateurs (email, password_hash, etc.)|
| `movies`     | Films référencés via l'API TMDB (`api_id`)       |
| `favorites`  | Films favoris par utilisateur                    |
| `watchlist`  | Films à regarder par utilisateur                 |
| `comments`   | Commentaires utilisateurs sur les films          |

### Relations principales
- Un **utilisateur** peut avoir plusieurs **favoris**, **watchlist** et **commentaires**
- Un **film** peut être commenté, mis en favori ou en watchlist par plusieurs utilisateurs
- Les tables `favorites`, `watchlist` et `comments` sont liées à `users` et `movies` via des clés étrangères

---

## 🔐 Authentification

### Page d'inscription — `inscription.php`
- Formulaire avec champs : nom, email, mot de passe
- Hachage sécurisé avec `password_hash()` (algorithme `PASSWORD_DEFAULT`)
- Vérification de l'unicité de l'email avant insertion
- Messages d'erreur et de succès affichés inline

### Page de connexion — `connexion.php`
- Vérification des identifiants avec `password_verify()`
- Démarrage de session PHP avec `session_start()`
- Stockage de l'ID utilisateur en session (`$_SESSION['user_id']`)
- Redirection automatique après connexion réussie

---

## ⚙️ Configuration de l'environnement

### Variables d'environnement (`.env`)

```env
DB_HOST=your_host
DB_NAME=your_dbname
DB_USER=your_username
DB_PASS=your_password
```

### Connexion PDO — `includes/db.php`

```php
<?php
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
```

---

## 🔧 Fonctions CRUD — `includes/functions.php`

Les fonctions sont organisées de manière **procédurale**, utilisant PDO avec `bindParam()`.

### Exemple — Créer un utilisateur

```php
function createUser($pdo, $nom, $email, $password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        "INSERT INTO users (nom, email, password_hash) VALUES (:nom, :email, :password_hash)"
    );
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password_hash);
    return $stmt->execute();
}
```

### Exemple — Ajouter un favori

```php
function addFavorite($pdo, $user_id, $movie_id) {
    $stmt = $pdo->prepare(
        "INSERT INTO favorites (user_id, movie_id) VALUES (:user_id, :movie_id)"
    );
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':movie_id', $movie_id);
    return $stmt->execute();
}
```

### Exemple — Ajouter un commentaire

```php
function addComment($pdo, $user_id, $movie_id, $content) {
    $stmt = $pdo->prepare(
        "INSERT INTO comments (user_id, movie_id, content) VALUES (:user_id, :movie_id, :content)"
    );
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':movie_id', $movie_id);
    $stmt->bindParam(':content', $content);
    return $stmt->execute();
}
```

---

## 🎨 Charte graphique

Les pages PHP respectent le design system de CineVerse :

- **Thème** : Sombre, inspiré de Netflix
- **Couleur primaire** : Rouge `#e50914` (boutons, accents)
- **Typographie** : `Poppins` (titres) et `Roboto` (corps de texte) via Google Fonts
- **Icônes** : Font Awesome 6
- **Responsive** : Formulaires adaptés mobile/tablette/desktop

---

## 🚀 Installation et utilisation

### Prérequis
- Docker avec service `mysql-server`
- PHP 8.x
- MySQL 8.x

### Installation

1. **Cloner le repository**
```bash
git clone https://github.com/Vortexhub007/cineverse.git
cd cineverse
```

2. **Configurer les variables d'environnement**
```bash
# Renseigner vos valeurs dans .env
```

3. **Lancer les conteneurs Docker**
```bash
Débrouiller vous
```

4. **Importer la base de données**
```
Débrouiller vous
```

5. **Accéder à l'application**
```
Débrouiller vous
```

---

## 🗄️ Script SQL

Le fichier `sql/cineverse_db.sql` contient :
- `DROP TABLE IF EXISTS` pour chaque table (ordre respectant les FK)
- `CREATE TABLE` avec types, contraintes et clés étrangères
- `INSERT INTO` avec des données de test représentatives

```sql
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS watchlist;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    api_id INT NOT NULL UNIQUE,
    titre VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ... (favorites, watchlist, comments)
```

---

## 📊 Tests effectués

- ✅ **Inscription** : Création de compte avec hachage du mot de passe
- ✅ **Connexion** : Vérification des identifiants et démarrage de session
- ✅ **CRUD** : Ajout/suppression de favoris, watchlist et commentaires
- ✅ **Sécurité** : Requêtes préparées, protection XSS sur les sorties
- ✅ **Docker** : Connexion PDO validée avec le service `mysql-server`

---

## 🚧 Axes d'amélioration

Avec plus de temps, j'aimerais ajouter :

1. **Sécurité renforcée**
   - Tokens CSRF sur tous les formulaires
   - Validation et sanitisation systématiques des entrées
   - Limitation du nombre de tentatives de connexion

2. **Fonctionnalités utilisateur**
   - Page profil avec modification des informations
   - Déconnexion sécurisée avec destruction de session
   - Réinitialisation du mot de passe par email

3. **Architecture**
   - Séparation en couches MVC
   - Gestion des erreurs centralisée
   - Logs applicatifs

4. **Tests**
   - Tests unitaires PHPUnit
   - Tests d'intégration sur les fonctions CRUD

---

## 👨‍💻 Auteur

**Valentin MARTIN**
Formation : Développeur Web et Web Mobile (DWWM)
Promotion : 2025-2026
Date de création : Mars 2026

📧 Email : [contact.valentin69400@gmail.com](mailto:contact.valentin69400@gmail.com)
🔗 GitHub : [@Vortexhub007](https://github.com/Vortexhub007)
💼 LinkedIn : [Valentin MARTIN](https://www.linkedin.com/in/valentin-martin-web/)

---

## 📄 Licence

Ce projet a été créé dans un cadre pédagogique pour l'obtention du titre DWWM.

---

## 🙏 Remerciements

- **Mes formateurs** pour leur accompagnement tout au long de la formation
- **La communauté PHP** pour la documentation officielle
- **Docker** pour la simplicité de l'environnement de développement

---

**⭐ N'oubliez pas de laisser une étoile si ce projet vous a plu !**