# 🎬 CineVerse - PHP/MySQL Backend

## 📋 Project Description

**CineVerse** is a full-stack web application allowing users to manage their movie experience: registration, login, favorites management, watchlist and comments. This backend was developed as part of the ECF assessment for the DWWM (Web and Mobile Web Developer) professional certification.

The application is built on a **procedural PHP** architecture with a **MySQL** database, a **PDO** connection and secure authentication pages.

🔗 **Deployed Frontend**: [https://cineverse-valentinmartin.vercel.app/](https://cineverse-valentinmartin.vercel.app/)

---

## 🎯 Target Skills

This project demonstrates mastery of the following skills:

### 1. Design and implement a relational database
- ✅ Writing the data dictionary
- ✅ ERD modeling using the Looping tool
- ✅ Derivation of the Logical Data Model (LDM)
- ✅ Complete SQL script with `DROP TABLE IF EXISTS` and `INSERT` data
- ✅ Compliance with integrity constraints (primary keys, foreign keys)

### 2. Develop data access components
- ✅ Secure PDO connection using environment variables
- ✅ Procedural CRUD functions with prepared statements (`bindParam`)
- ✅ Password hashing with `password_hash()` / `password_verify()`
- ✅ PHP session management (`$_SESSION`)
- ✅ Protection against SQL injection

---

## 🗂️ Project Structure

```
cineverse-php/
│
├── index.php                  # Redirects to login or home page
│
├── auth/
│   ├── inscription.php        # User registration page
│   └── connexion.php          # User login page
│
├── includes/
│   ├── db.php                 # PDO connection (environment variables)
│   └── functions.php          # Procedural CRUD functions
│
├── sql/
│   └── cineverse_db.sql       # SQL script (DROP, CREATE, INSERT)
│
├── merise/
│   ├── dictionnaire_donnees.md  # Data dictionary
│   ├── mcd.loo                  # Looping file (ERD)
│   └── mld.md                   # Logical Data Model
│
├── css/
│   └── style.css              # Shared styles (CineVerse theme)
│
├── .env.example               # Environment variables configuration example
├── .gitignore                 # Files excluded from Git
└── README-PHP.md              # Documentation (this file)
```

---

## 🛠️ Technologies Used

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

## 🗃️ Database — `cineverse_db`

### Table Schema

| Table        | Description                                          |
|--------------|------------------------------------------------------|
| `users`      | User accounts (email, password_hash, etc.)           |
| `movies`     | Movies referenced via the TMDB API (`api_id`)        |
| `favorites`  | User favorite movies                                 |
| `watchlist`  | Movies to watch per user                             |
| `comments`   | User comments on movies                              |

### Main Relationships
- A **user** can have multiple **favorites**, **watchlist** entries and **comments**
- A **movie** can be commented on, favorited or added to the watchlist by multiple users
- The `favorites`, `watchlist` and `comments` tables are linked to `users` and `movies` via foreign keys

---

## 🔐 Authentication

### Registration Page — `inscription.php`
- Form with fields: name, email, password
- Secure hashing with `password_hash()` (`PASSWORD_DEFAULT` algorithm)
- Email uniqueness check before insertion
- Inline error and success messages

### Login Page — `connexion.php`
- Credentials verification with `password_verify()`
- PHP session start with `session_start()`
- User ID stored in session (`$_SESSION['user_id']`)
- Automatic redirect after successful login

---

## ⚙️ Environment Configuration

### Environment Variables (`.env`)

```env
DB_HOST=your_host
DB_NAME=your_dbname
DB_USER=your_username
DB_PASS=your_password
```

### PDO Connection — `includes/db.php`

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
    die("Connection error: " . $e->getMessage());
}
```

---

## 🔧 CRUD Functions — `includes/functions.php`

Functions are organized in a **procedural** manner, using PDO with `bindParam()`.

### Example — Create a user

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

### Example — Add a favorite

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

### Example — Add a comment

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

## 🎨 Design System

PHP pages follow the CineVerse design system:

- **Theme**: Dark, Netflix-inspired
- **Primary color**: Red `#e50914` (buttons, accents)
- **Typography**: `Poppins` (headings) and `Roboto` (body text) via Google Fonts
- **Icons**: Font Awesome 6
- **Responsive**: Forms adapted for mobile/tablet/desktop

---

## 🚀 Installation & Usage

### Prerequisites
- Docker with `mysql-server` service
- PHP 8.x
- MySQL 8.x

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/Vortexhub007/cineverse.git
cd cineverse
```

2. **Configure environment variables**
```bash
# Fill in your values in .env
```

3. **Start Docker containers**
```bash
Find the solution
```

4. **Import the database**
```bash
Find the solution
```

5. **Access the application**
```
Find the solution
```

---

## 🗄️ SQL Script

The `sql/cineverse_db.sql` file contains:
- `DROP TABLE IF EXISTS` for each table (in foreign key-safe order)
- `CREATE TABLE` with types, constraints and foreign keys
- `INSERT INTO` with representative test data

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

## 📊 Tests Performed

- ✅ **Registration**: Account creation with password hashing
- ✅ **Login**: Credentials verification and session start
- ✅ **CRUD**: Adding/removing favorites, watchlist entries and comments
- ✅ **Security**: Prepared statements, XSS protection on outputs
- ✅ **Docker**: PDO connection validated with the `mysql-server` service

---

## 🚧 Areas for Improvement

Given more time, I would like to add:

1. **Enhanced security**
   - CSRF tokens on all forms
   - Systematic input validation and sanitization
   - Login attempt rate limiting

2. **User features**
   - Profile page with editable information
   - Secure logout with session destruction
   - Password reset via email

3. **Architecture**
   - MVC layer separation
   - Centralized error handling
   - Application logging

4. **Testing**
   - PHPUnit unit tests
   - Integration tests on CRUD functions

---

## 👨‍💻 Author

**Valentin MARTIN**
Training: Web and Mobile Web Developer (DWWM)
Class: 2025-2026
Created: March 2026

📧 Email: [contact.valentin69400@gmail.com](mailto:contact.valentin69400@gmail.com)
🔗 GitHub: [@Vortexhub007](https://github.com/Vortexhub007)
💼 LinkedIn: [Valentin MARTIN](https://www.linkedin.com/in/valentin-martin-web/)

---

## 📄 License

This project was created in an educational context for the DWWM professional certification.

---

## 🙏 Acknowledgements

- **My instructors** for their support throughout the training
- **The PHP community** for the official documentation
- **Docker** for simplifying the development environment

---

**⭐ Don't forget to leave a star if you liked this project!**