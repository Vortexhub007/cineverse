/**
 * Module API - Gestion des appels à l'API TMDB
 * Ce module contient toutes les fonctions pour récupérer les données des films
 */

// Configuration de l'API
const API_CONFIG = {
    BASE_URL: 'https://api.themoviedb.org/3',
    API_KEY: '13f2b9408bb6a67e1ff40b289d940cd2', // À remplacer par votre clé API
    IMAGE_BASE_URL: 'https://image.tmdb.org/t/p',
    IMAGE_SIZES: {
        poster: 'w500',
        backdrop: 'w1280',
        profile: 'w185'
    },
    LANGUAGE: 'fr-FR'
};

/**
 * Récupère les films populaires depuis l'API TMDB
 * @param {number} page - Numéro de la page à récupérer
 * @returns {Promise<Object>} - Objet contenant les films et métadonnées
 */
export async function getPopularMovies(page = 1) {
    try {
        const url = `${API_CONFIG.BASE_URL}/movie/popular?api_key=${API_CONFIG.API_KEY}&language=${API_CONFIG.LANGUAGE}&page=${page}`;
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erreur lors de la récupération des films populaires:', error);
        throw error;
    }
}

/**
 * Récupère les détails d'un film spécifique
 * @param {number} movieId - ID du film
 * @returns {Promise<Object>} - Objet contenant les détails du film
 */
export async function getMovieDetails(movieId) {
    try {
        const url = `${API_CONFIG.BASE_URL}/movie/${movieId}?api_key=${API_CONFIG.API_KEY}&language=${API_CONFIG.LANGUAGE}&append_to_response=credits,videos`;
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erreur lors de la récupération des détails du film:', error);
        throw error;
    }
}

/**
 * Recherche des films par titre
 * @param {string} query - Terme de recherche
 * @param {number} page - Numéro de la page
 * @returns {Promise<Object>} - Résultats de la recherche
 */
export async function searchMovies(query, page = 1) {
    try {
        const url = `${API_CONFIG.BASE_URL}/search/movie?api_key=${API_CONFIG.API_KEY}&language=${API_CONFIG.LANGUAGE}&query=${encodeURIComponent(query)}&page=${page}`;
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erreur lors de la recherche de films:', error);
        throw error;
    }
}

/**
 * Construit l'URL complète d'une image
 * @param {string} path - Chemin de l'image
 * @param {string} size - Taille de l'image (poster, backdrop, profile)
 * @returns {string} - URL complète de l'image
 */
export function getImageUrl(path, size = 'poster') {
    if (!path) {
        return 'https://via.placeholder.com/500x750?text=No+Image';
    }
    
    const imageSize = API_CONFIG.IMAGE_SIZES[size] || 'w500';
    return `${API_CONFIG.IMAGE_BASE_URL}/${imageSize}${path}`;
}

/**
 * Formate une date au format français
 * @param {string} dateString - Date au format YYYY-MM-DD
 * @returns {string} - Date formatée
 */
export function formatDate(dateString) {
    if (!dateString) return 'Date inconnue';
    
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

/**
 * Formate la durée d'un film en heures et minutes
 * @param {number} minutes - Durée en minutes
 * @returns {string} - Durée formatée
 */
export function formatRuntime(minutes) {
    if (!minutes) return 'Durée inconnue';
    
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return `${hours}h ${mins}min`;
}

/**
 * Récupère les films depuis un fichier JSON local (fallback)
 * À utiliser si l'API TMDB n'est pas disponible
 * @returns {Promise<Array>} - Liste des films
 */
export async function getMoviesFromJSON() {
    try {
        const response = await fetch('data/movies.json');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erreur lors du chargement du fichier JSON:', error);
        throw error;
    }
}

export default {
    getPopularMovies,
    getMovieDetails,
    searchMovies,
    getImageUrl,
    formatDate,
    formatRuntime,
    getMoviesFromJSON
};