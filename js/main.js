/**
 * Main.js - Point d'entrée principal de l'application
 * Orchestre les différents modules et initialise l'application
 */

import * as API from './api.js';
import * as UI from './ui.js';
import * as Filters from './filters.js';

// État global de l'application
let allMovies = [];
let currentPage = 1;

/**
 * Initialise la page movies.html
 */
async function initMoviesPage() {
    console.log('Initialisation de la page films...');
    
    // Récupération des éléments DOM
    const moviesGrid = document.getElementById('moviesGrid');
    const loader = document.getElementById('loader');
    const errorElement = document.getElementById('error');
    const noResults = document.getElementById('noResults');
    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');
    const resultsCount = document.getElementById('resultsCount');
    
    try {
        // Afficher le loader
        UI.showLoader(loader);
        UI.hideError(errorElement);
        UI.hideNoResults(noResults);
        
        // Charger les films depuis l'API
        const data = await API.getPopularMovies(currentPage);
        // const data = await API.getMoviesFromJSON();
        allMovies = data.results || [];
        
        // Cacher le loader
        UI.hideLoader(loader);
        
        // Afficher les films
        UI.displayMovies(allMovies, moviesGrid);
        UI.updateResultsCount(allMovies.length, resultsCount);
        
        // Initialiser les filtres
        Filters.initFilters({
            searchInput,
            sortSelect,
            onFilter: handleFilter
        });
        
    } catch (error) {
        console.error('Erreur lors du chargement des films:', error);
        UI.hideLoader(loader);
        UI.showError(errorElement);
    }
}

/**
 * Gère le filtrage et le tri des films
 * @param {string} searchTerm - Terme de recherche
 * @param {string} sortBy - Critère de tri
 */
function handleFilter(searchTerm, sortBy) {
    const moviesGrid = document.getElementById('moviesGrid');
    const noResults = document.getElementById('noResults');
    const resultsCount = document.getElementById('resultsCount');
    
    // Appliquer les filtres et le tri
    const filteredMovies = Filters.applyFiltersAndSort(allMovies, searchTerm, sortBy);
    
    // Afficher ou masquer le message "aucun résultat"
    if (filteredMovies.length === 0) {
        UI.showNoResults(noResults);
        moviesGrid.innerHTML = '';
    } else {
        UI.hideNoResults(noResults);
        UI.displayMovies(filteredMovies, moviesGrid);
    }
    
    // Mettre à jour le compteur
    UI.updateResultsCount(filteredMovies.length, resultsCount);
}

/**
 * Initialise la page movie-details.html
 */
async function initMovieDetailsPage() {
    console.log('Initialisation de la page détails...');
    
    // Récupérer l'ID du film depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const movieId = urlParams.get('id');
    
    if (!movieId) {
        console.error('Aucun ID de film fourni');
        document.getElementById('loader').style.display = 'none';
        document.getElementById('error').style.display = 'block';
        return;
    }
    
    const loader = document.getElementById('loader');
    const errorElement = document.getElementById('error');
    const detailsContainer = document.getElementById('movieDetails');
    
    try {
        // Afficher le loader
        UI.showLoader(loader);
        UI.hideError(errorElement);
        
        // Charger les détails du film
        const movie = await API.getMovieDetails(movieId);
        
        // Cacher le loader
        UI.hideLoader(loader);
        
        // Afficher les détails
        detailsContainer.style.display = 'block';
        UI.displayMovieDetails(movie, detailsContainer);
        
        // Mettre à jour le titre de la page
        document.title = `${movie.title} - CineVerse`;
        
    } catch (error) {
        console.error('Erreur lors du chargement des détails:', error);
        UI.hideLoader(loader);
        UI.showError(errorElement);
    }
}

/**
 * Initialise la page index.html
 */
function initHomePage() {
    console.log('Initialisation de la page d\'accueil...');
    // Pas de logique spécifique nécessaire pour la page d'accueil
    // Le menu mobile est initialisé pour toutes les pages
}

/**
 * Détecte la page actuelle et initialise la logique appropriée
 */
function initCurrentPage() {
    const currentPath = window.location.pathname;
    const currentPage = currentPath.substring(currentPath.lastIndexOf('/') + 1);
    
    console.log('Page actuelle:', currentPage);
    
    // Initialiser le menu mobile sur toutes les pages
    UI.initMobileMenu();
    
    // Initialiser la logique spécifique à chaque page
    if (currentPage === 'movies.html' || currentPage === '') {
        initMoviesPage();
    } else if (currentPage === 'movie-details.html') {
        initMovieDetailsPage();
    } else if (currentPage === 'index.html' || currentPage === '/') {
        initHomePage();
    }
}

/**
 * Point d'entrée de l'application
 * S'exécute quand le DOM est chargé
 */
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM chargé, initialisation de l\'application...');
    initCurrentPage();
});

/**
 * Gestion des erreurs globales
 */
window.addEventListener('error', (event) => {
    console.error('Erreur globale:', event.error);
});

/**
 * Export pour utilisation dans d'autres fichiers si nécessaire
 */
export {
    initMoviesPage,
    initMovieDetailsPage,
    initHomePage,
    handleFilter
};