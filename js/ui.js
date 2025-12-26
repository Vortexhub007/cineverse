/**
 * Module UI - Gestion de l'interface utilisateur
 */

import * as API from './api.js';

/**
 * Affiche le loader
 * @param {HTMLElement} loader - Élément du loader
 */
export function showLoader(loader) {
    if (loader) loader.style.display = 'block';
}

/**
 * Cache le loader
 * @param {HTMLElement} loader - Élément du loader
 */
export function hideLoader(loader) {
    if (loader) loader.style.display = 'none';
}

/**
 * Affiche le message d'erreur
 * @param {HTMLElement} errorElement - Élément d'erreur
 */
export function showError(errorElement) {
    if (errorElement) errorElement.style.display = 'block';
}

/**
 * Cache le message d'erreur
 * @param {HTMLElement} errorElement - Élément d'erreur
 */
export function hideError(errorElement) {
    if (errorElement) errorElement.style.display = 'none';
}

/**
 * Affiche le message "aucun résultat"
 * @param {HTMLElement} noResultsElement - Élément de message
 */
export function showNoResults(noResultsElement) {
    if (noResultsElement) noResultsElement.style.display = 'block';
}

/**
 * Cache le message "aucun résultat"
 * @param {HTMLElement} noResultsElement - Élément de message
 */
export function hideNoResults(noResultsElement) {
    if (noResultsElement) noResultsElement.style.display = 'none';
}

/**
 * Met à jour le compteur de résultats
 * @param {number} count - Nombre de films
 * @param {HTMLElement} element - Élément d'affichage
 */
export function updateResultsCount(count, element) {
    if (element) {
        element.textContent = `${count} film${count > 1 ? 's' : ''} trouvé${count > 1 ? 's' : ''}`;
    }
}

/**
 * Affiche la liste des films dans la grille
 * @param {Array} movies - Liste des films
 * @param {HTMLElement} container - Grille de destination
 */
export function displayMovies(movies, container) {
    if (!container) return;
    
    // Vider le conteneur
    container.innerHTML = '';
    
    movies.forEach(movie => {
        const movieCard = document.createElement('div');
        movieCard.className = 'movie-card';
        
        movieCard.innerHTML = `
            <a href="movie-details.html?id=${movie.id}" class="movie-link">
                <div class="movie-poster">
                    <img src="${API.getImageUrl(movie.poster_path)}" alt="${movie.title}" loading="lazy">
                    <div class="movie-rating">⭐ ${movie.vote_average.toFixed(1)}</div>
                </div>
                <div class="movie-info">
                    <h3>${movie.title}</h3>
                    <p class="movie-date">${API.formatDate(movie.release_date)}</p>
                </div>
            </a>
        `;
        
        container.appendChild(movieCard);
    });
}

/**
 * Affiche les détails d'un film
 * @param {Object} movie - Données du film
 * @param {HTMLElement} container - Conteneur de destination
 */
export function displayMovieDetails(movie, container) {
    if (!container) return;
    
    container.innerHTML = `
        <div class="movie-details-content">
            <div class="detail-header" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.9)), url('${API.getImageUrl(movie.backdrop_path, 'backdrop')}')">
                <div class="container">
                    <div class="detail-main">
                        <img src="${API.getImageUrl(movie.poster_path)}" alt="${movie.title}" class="detail-poster">
                        <div class="detail-text">
                            <h1>${movie.title}</h1>
                            <div class="detail-meta">
                                <span>📅 ${API.formatDate(movie.release_date)}</span>
                                <span>⏱️ ${API.formatRuntime(movie.runtime)}</span>
                                <span>⭐ ${movie.vote_average.toFixed(1)}/10</span>
                            </div>
                            <div class="genres">
                                ${movie.genres.map(g => `<span class="genre-tag">${g.name}</span>`).join('')}
                            </div>
                            <h3>Synopsis</h3>
                            <p>${movie.overview || 'Aucun synopsis disponible.'}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Initialise le menu mobile
 */
export function initMobileMenu() {
    // On utilise querySelector avec les classes BEM de ton HTML
    const menuBtn = document.querySelector('.nav__toggle'); 
    const navLinks = document.querySelector('.nav__menu');

    if (menuBtn && navLinks) {
        menuBtn.addEventListener('click', () => {
            // On ajoute/enlève la classe 'active' pour afficher le menu
            navLinks.classList.toggle('active');
            
            // Optionnel : Changer l'icône du menu (burger vs croix)
            const icon = menuBtn.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });
    } else {
        console.warn("Éléments du menu mobile non trouvés (.nav__toggle ou .nav__menu)");
    }
}

// Exportation par défaut de toutes les fonctions
export default {
    showLoader,
    hideLoader,
    showError,
    hideError,
    showNoResults,
    hideNoResults,
    updateResultsCount,
    displayMovies,
    displayMovieDetails,
    initMobileMenu
};