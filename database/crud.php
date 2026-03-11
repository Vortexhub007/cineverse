<?php
require_once 'config.php';

/**
 * CREATE - Ajouter un film
 */
function createMovie($pdo, $api_id, $title, $poster_url = null, $release_date = null) {
    try {
        $sql = "INSERT INTO movies (api_id, title, poster_url, release_date) 
                VALUES (:api_id, :title, :poster_url, :release_date)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':api_id', $api_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':poster_url', $poster_url);
        $stmt->bindParam(':release_date', $release_date);
        
        $stmt->execute();
        return $pdo->lastInsertId();
        
    } catch(PDOException $e) {
        error_log("Erreur createMovie : " . $e->getMessage());
        return false;
    }
}

/**
 * READ - Récupérer tous les films
 */
function getAllMovies($pdo, $limit = 20, $offset = 0) {
    try {
        $sql = "SELECT * FROM movies 
                ORDER BY created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getAllMovies : " . $e->getMessage());
        return [];
    }
}

/**
 * READ - Récupérer un film par ID
 */
function getMovieById($pdo, $id) {
    try {
        $sql = "SELECT * FROM movies WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getMovieById : " . $e->getMessage());
        return false;
    }
}

/**
 * READ - Récupérer un film par api_id
 */
function getMovieByApiId($pdo, $api_id) {
    try {
        $sql = "SELECT * FROM movies WHERE api_id = :api_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':api_id', $api_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getMovieByApiId : " . $e->getMessage());
        return false;
    }
}

/**
 * UPDATE - Modifier un film
 */
function updateMovie($pdo, $id, $title, $poster_url = null, $release_date = null) {
    try {
        $sql = "UPDATE movies SET 
                title = :title, 
                poster_url = :poster_url, 
                release_date = :release_date 
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':poster_url', $poster_url);
        $stmt->bindParam(':release_date', $release_date);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Erreur updateMovie : " . $e->getMessage());
        return false;
    }
}

/**
 * DELETE - Supprimer un film
 */
function deleteMovie($pdo, $id) {
    try {
        $sql = "DELETE FROM movies WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Erreur deleteMovie : " . $e->getMessage());
        return false;
    }
}

/**
 * Compter le nombre total de films
 */
function countMovies($pdo) {
    try {
        $sql = "SELECT COUNT(*) FROM movies";
        $stmt = $pdo->query($sql);
        return $stmt->fetchColumn();
        
    } catch(PDOException $e) {
        error_log("Erreur countMovies : " . $e->getMessage());
        return 0;
    }
}

/**
 * Rechercher des films par titre
 */
function searchMovies($pdo, $search, $limit = 20) {
    try {
        $sql = "SELECT * FROM movies 
                WHERE title LIKE :search 
                ORDER BY title ASC 
                LIMIT :limit";
        
        $stmt = $pdo->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur searchMovies : " . $e->getMessage());
        return [];
    }
}

// ============================================
// CRUD FAVORITES
// ============================================

/**
 * CREATE - Ajouter un film aux favoris
 */
function addFavorite($pdo, $user_id, $movie_id) {
    try {
        $sql = "INSERT INTO favorites (user_id, movie_id) 
                VALUES (:user_id, :movie_id)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        // Contrainte UNIQUE - déjà en favoris
        if ($e->getCode() == 23000) {
            return false;
        }
        error_log("Erreur addFavorite : " . $e->getMessage());
        return false;
    }
}

/**
 * READ - Récupérer les favoris d'un utilisateur avec détails des films
 */
function getUserFavorites($pdo, $user_id) {
    try {
        $sql = "SELECT f.id as favorite_id, f.created_at, 
                       m.id, m.api_id, m.title, m.poster_url, m.release_date
                FROM favorites f
                INNER JOIN movies m ON f.movie_id = m.id
                WHERE f.user_id = :user_id
                ORDER BY f.created_at DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getUserFavorites : " . $e->getMessage());
        return [];
    }
}

/**
 * Vérifier si un film est dans les favoris
 */
function isFavorite($pdo, $user_id, $movie_id) {
    try {
        $sql = "SELECT COUNT(*) FROM favorites 
                WHERE user_id = :user_id AND movie_id = :movie_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
        
    } catch(PDOException $e) {
        error_log("Erreur isFavorite : " . $e->getMessage());
        return false;
    }
}

/**
 * DELETE - Retirer un film des favoris
 */
function removeFavorite($pdo, $user_id, $movie_id) {
    try {
        $sql = "DELETE FROM favorites 
                WHERE user_id = :user_id AND movie_id = :movie_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Erreur removeFavorite : " . $e->getMessage());
        return false;
    }
}

/**
 * Compter les favoris d'un utilisateur
 */
function countUserFavorites($pdo, $user_id) {
    try {
        $sql = "SELECT COUNT(*) FROM favorites WHERE user_id = :user_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn();
        
    } catch(PDOException $e) {
        error_log("Erreur countUserFavorites : " . $e->getMessage());
        return 0;
    }
}

// ============================================
// CRUD WATCHLIST
// ============================================

/**
 * CREATE - Ajouter un film à la watchlist
 */
function addToWatchlist($pdo, $user_id, $movie_id, $status = 'to_watch') {
    try {
        $sql = "INSERT INTO watchlist (user_id, movie_id, status) 
                VALUES (:user_id, :movie_id, :status)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        if ($e->getCode() == 23000) {
            return false; // Déjà dans la watchlist
        }
        error_log("Erreur addToWatchlist : " . $e->getMessage());
        return false;
    }
}

/**
 * READ - Récupérer la watchlist d'un utilisateur avec détails
 */
function getUserWatchlist($pdo, $user_id, $status = null) {
    try {
        $sql = "SELECT w.id as watchlist_id, w.status, w.added_at, w.watched_at,
                       m.id, m.api_id, m.title, m.poster_url, m.release_date
                FROM watchlist w
                INNER JOIN movies m ON w.movie_id = m.id
                WHERE w.user_id = :user_id";
        
        $params = [':user_id' => $user_id];
        
        if ($status) {
            $sql .= " AND w.status = :status";
            $params[':status'] = $status;
        }
        
        $sql .= " ORDER BY w.added_at DESC";
        
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getUserWatchlist : " . $e->getMessage());
        return [];
    }
}

/**
 * UPDATE - Mettre à jour le statut d'un film dans la watchlist
 */
function updateWatchlistStatus($pdo, $watchlist_id, $status) {
    try {
        // Si status = 'watched', mettre à jour watched_at
        if ($status === 'watched') {
            $sql = "UPDATE watchlist SET 
                    status = :status, 
                    watched_at = CURRENT_TIMESTAMP 
                    WHERE id = :id";
        } else {
            $sql = "UPDATE watchlist SET 
                    status = :status, 
                    watched_at = NULL 
                    WHERE id = :id";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $watchlist_id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Erreur updateWatchlistStatus : " . $e->getMessage());
        return false;
    }
}

/**
 * DELETE - Retirer un film de la watchlist
 */
function removeFromWatchlist($pdo, $user_id, $movie_id) {
    try {
        $sql = "DELETE FROM watchlist 
                WHERE user_id = :user_id AND movie_id = :movie_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Erreur removeFromWatchlist : " . $e->getMessage());
        return false;
    }
}

/**
 * Vérifier si un film est dans la watchlist
 */
function isInWatchlist($pdo, $user_id, $movie_id) {
    try {
        $sql = "SELECT COUNT(*) FROM watchlist 
                WHERE user_id = :user_id AND movie_id = :movie_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
        
    } catch(PDOException $e) {
        error_log("Erreur isInWatchlist : " . $e->getMessage());
        return false;
    }
}

// ============================================
// CRUD COMMENTS
// ============================================

/**
 * CREATE - Ajouter un commentaire
 */
function addComment($pdo, $user_id, $movie_id, $content, $rating = null) {
    try {
        $sql = "INSERT INTO comments (user_id, movie_id, content, rating) 
                VALUES (:user_id, :movie_id, :content, :rating)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        
        $stmt->execute();
        return $pdo->lastInsertId();
        
    } catch(PDOException $e) {
        error_log("Erreur addComment : " . $e->getMessage());
        return false;
    }
}

/**
 * READ - Récupérer tous les commentaires d'un film avec infos utilisateur
 */
function getMovieComments($pdo, $movie_id) {
    try {
        $sql = "SELECT c.id, c.content, c.rating, c.created_at,
                       u.id as user_id, u.username, u.email
                FROM comments c
                INNER JOIN users u ON c.user_id = u.id
                WHERE c.movie_id = :movie_id
                ORDER BY c.created_at DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getMovieComments : " . $e->getMessage());
        return [];
    }
}

/**
 * READ - Récupérer un commentaire par ID
 */
function getCommentById($pdo, $comment_id) {
    try {
        $sql = "SELECT c.*, u.username 
                FROM comments c
                INNER JOIN users u ON c.user_id = u.id
                WHERE c.id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $comment_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getCommentById : " . $e->getMessage());
        return false;
    }
}

/**
 * READ - Récupérer les commentaires d'un utilisateur
 */
function getUserComments($pdo, $user_id) {
    try {
        $sql = "SELECT c.id, c.content, c.rating, c.created_at,
                       m.id as movie_id, m.title, m.poster_url
                FROM comments c
                INNER JOIN movies m ON c.movie_id = m.id
                WHERE c.user_id = :user_id
                ORDER BY c.created_at DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        error_log("Erreur getUserComments : " . $e->getMessage());
        return [];
    }
}

/**
 * UPDATE - Modifier un commentaire
 */
function updateComment($pdo, $comment_id, $content, $rating = null) {
    try {
        $sql = "UPDATE comments SET 
                content = :content, 
                rating = :rating 
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':id', $comment_id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Erreur updateComment : " . $e->getMessage());
        return false;
    }
}

/**
 * DELETE - Supprimer un commentaire
 */
function deleteComment($pdo, $comment_id) {
    try {
        $sql = "DELETE FROM comments WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $comment_id, PDO::PARAM_INT);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Erreur deleteComment : " . $e->getMessage());
        return false;
    }
}

/**
 * Compter les commentaires d'un film
 */
function countMovieComments($pdo, $movie_id) {
    try {
        $sql = "SELECT COUNT(*) FROM comments WHERE movie_id = :movie_id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn();
        
    } catch(PDOException $e) {
        error_log("Erreur countMovieComments : " . $e->getMessage());
        return 0;
    }
}

/**
 * Calculer la note moyenne d'un film
 */
function getMovieAverageRating($pdo, $movie_id) {
    try {
        $sql = "SELECT AVG(rating) FROM comments 
                WHERE movie_id = :movie_id AND rating IS NOT NULL";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $average = $stmt->fetchColumn();
        return $average ? round($average, 1) : null;
        
    } catch(PDOException $e) {
        error_log("Erreur getMovieAverageRating : " . $e->getMessage());
        return null;
    }
}
?>