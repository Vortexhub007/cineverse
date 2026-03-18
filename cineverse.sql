-- Active: 1773218389628@@localhost@3306@cineverse_db
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS watchlist;
DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS users;
DROP DATABASE IF EXISTS cineverse_db;
CREATE DATABASE IF NOT EXISTS cineverse_db;
USE cineverse_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    username VARCHAR(100),
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    api_id VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    poster_url VARCHAR(255),
    release_date DATE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_user_movie (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE watchlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    status ENUM('to_watch','watching','watched') NOT NULL DEFAULT 'to_watch',
    added_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    watched_at DATETIME NULL,
    UNIQUE KEY uniq_user_movie (user_id, movie_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    content TEXT NOT NULL,
    rating TINYINT UNSIGNED CHECK (rating BETWEEN 0 AND 10),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (email, password_hash, username, role) VALUES
('alice@cineverse.fr', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alice', 'admin'),
('bob@cineverse.fr',   '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bob',   'user'),
('carol@cineverse.fr', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Carol', 'user');


INSERT INTO movies (api_id, title, poster_url, release_date) VALUES
('tt0111161', 'The Shawshank Redemption', 'https://example.com/shawshank.jpg', '1994-09-23'),
('tt0068646', 'The Godfather',            'https://example.com/godfather.jpg', '1972-03-24'),
('tt0071562', 'The Godfather Part II',    'https://example.com/godfather2.jpg','1974-12-20');


INSERT INTO favorites (user_id, movie_id) VALUES (1, 1), (1, 2), (2, 1);


INSERT INTO watchlist (user_id, movie_id, status) VALUES
(1, 3, 'to_watch'),
(2, 2, 'watching'),
(3, 1, 'watched');

INSERT INTO comments (user_id, movie_id, content, rating) VALUES
(1, 1, 'Un chef-d\'œuvre absolu.', 10),
(2, 2, 'Le meilleur film de gangsters jamais réalisé.', 9),
(3, 3, 'Aussi bon que le premier volet.', 9);

-- Favoris avec utilisateur + film
SELECT 
    u.username,
    u.email,
    m.title,
    f.created_at
FROM favorites f
JOIN users u ON f.user_id = u.id
JOIN movies m ON f.movie_id = m.id; 