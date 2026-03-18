-- Active: 1773218389628@@localhost@3306@cineverse_db
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS watchlist;
DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS users;
DROP DATABASE IF EXISTS cineverse_db;
CREATE DATABASE IF NOT EXISTS cineverse_db;
USE cineverse_db;

CREATE TABLE users(
   user_id INT AUTO_INCREMENT,
   email VARCHAR(255) NOT NULL,
   password_hash VARCHAR(255) NOT NULL,
   username VARCHAR(100),
   role ENUM,
   created_at DATETIME NOT NULL,
   updated_at DATETIME NOT NULL,
   watchlist_id INT NOT NULL,
   favorite_id INT NOT NULL,
   PRIMARY KEY(user_id),
   UNIQUE(email),
   FOREIGN KEY(watchlist_id) REFERENCES watchlist(watchlist_id),
   FOREIGN KEY(favorite_id) REFERENCES favorites(favorite_id)
);

CREATE TABLE movies(
   movie_id INT AUTO_INCREMENT,
   api_id VARCHAR(50) NOT NULL,
   title VARCHAR(255) NOT NULL,
   poster_url VARCHAR(255),
   release_date DATE,
   created_at DATETIME NOT NULL,
   updated_at DATETIME NOT NULL,
   PRIMARY KEY(movie_id),
   UNIQUE(api_id)
);

CREATE TABLE favorites(
   favorite_id INT AUTO_INCREMENT,
   created_at DATETIME NOT NULL,
   PRIMARY KEY(favorite_id)
);

CREATE TABLE watchlist(
   watchlist_id INT AUTO_INCREMENT,
   status ENUM NOT NULL,
   added_at DATETIME NOT NULL,
   watched_at DATETIME,
   PRIMARY KEY(watchlist_id)
);

CREATE TABLE comments(
   comment_id INT AUTO_INCREMENT,
   content TEXT NOT NULL,
   rating LOGICAL,
   created_at DATETIME NOT NULL,
   movie_id INT,
   user_id INT NOT NULL,
   PRIMARY KEY(comment_id),
   FOREIGN KEY(movie_id) REFERENCES movies(movie_id),
   FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE AIMER(
   movie_id INT,
   favorite_id INT,
   PRIMARY KEY(movie_id, favorite_id),
   FOREIGN KEY(movie_id) REFERENCES movies(movie_id),
   FOREIGN KEY(favorite_id) REFERENCES favorites(favorite_id)
);

CREATE TABLE SAUVEGARDER(
   movie_id INT,
   watchlist_id INT,
   PRIMARY KEY(movie_id, watchlist_id),
   FOREIGN KEY(movie_id) REFERENCES movies(movie_id),
   FOREIGN KEY(watchlist_id) REFERENCES watchlist(watchlist_id)
);

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