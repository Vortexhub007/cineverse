/**
 * Module Filters - Gestion de la recherche et du tri des films
 * Ce module contient les fonctions de filtrage et de tri
 */

/**
 * Filtre les films selon un terme de recherche
 * @param {Array} movies - Tableau de films
 * @param {string} searchTerm - Terme de recherche
 * @returns {Array} - Films filtrés
 */
export function filterMoviesBySearch(movies, searchTerm) {
    if (!searchTerm || searchTerm.trim() === '') {
        return movies;
    }
    
    const term = searchTerm.toLowerCase().trim();
    
    return movies.filter(movie => {
        const title = movie.title?.toLowerCase() || '';
        const overview = movie.overview?.toLowerCase() || '';
        
        return title.includes(term) || overview.includes(term);
    });
}

/**
 * Trie les films selon un critère
 * @param {Array} movies - Tableau de films à trier
 * @param {string} sortBy - Critère de tri (popularity, rating, date, title)
 * @returns {Array} - Films triés
 */
export function sortMovies(movies, sortBy) {
    if (!movies || movies.length === 0) {
        return movies;
    }
    
    // Créer une copie du tableau pour ne pas modifier l'original
    const sortedMovies = [...movies];
    
    switch (sortBy) {
        case 'popularity':
            // Tri par popularité décroissante
            return sortedMovies.sort((a, b) => {
                return (b.popularity || 0) - (a.popularity || 0);
            });
            
        case 'rating':
            // Tri par note décroissante
            return sortedMovies.sort((a, b) => {
                return (b.vote_average || 0) - (a.vote_average || 0);
            });
            
        case 'date':
            // Tri par date de sortie décroissante (plus récent en premier)
            return sortedMovies.sort((a, b) => {
                const dateA = new Date(a.release_date || 0);
                const dateB = new Date(b.release_date || 0);
                return dateB - dateA;
            });
            
        case 'title':
            // Tri alphabétique par titre
            return sortedMovies.sort((a, b) => {
                const titleA = (a.title || '').toLowerCase();
                const titleB = (b.title || '').toLowerCase();
                return titleA.localeCompare(titleB);
            });
            
        default:
            return sortedMovies;
    }
}

/**
 * Applique les filtres et le tri sur les films
 * @param {Array} movies - Tableau de films
 * @param {string} searchTerm - Terme de recherche
 * @param {string} sortBy - Critère de tri
 * @returns {Array} - Films filtrés et triés
 */
export function applyFiltersAndSort(movies, searchTerm, sortBy) {
    // D'abord filtrer
    let filteredMovies = filterMoviesBySearch(movies, searchTerm);
    
    // Puis trier
    filteredMovies = sortMovies(filteredMovies, sortBy);
    
    return filteredMovies;
}

/**
 * Crée un debounce pour limiter les appels de fonction
 * Utile pour la barre de recherche
 * @param {Function} func - Fonction à debouncer
 * @param {number} delay - Délai en millisecondes
 * @returns {Function} - Fonction debouncée
 */
export function debounce(func, delay = 300) {
    let timeoutId;
    
    return function(...args) {
        // Annuler le timeout précédent
        clearTimeout(timeoutId);
        
        // Créer un nouveau timeout
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

/**
 * Initialise les écouteurs d'événements pour la recherche et le tri
 * @param {Object} options - Options de configuration
 * @param {HTMLElement} options.searchInput - Input de recherche
 * @param {HTMLElement} options.sortSelect - Select de tri
 * @param {Function} options.onFilter - Callback appelé lors du filtrage
 */
export function initFilters({ searchInput, sortSelect, onFilter }) {
    if (!searchInput || !sortSelect || !onFilter) {
        console.error('Missing required elements for filter initialization');
        return;
    }
    
    // Debounce pour la recherche (attend 300ms après la dernière saisie)
    const debouncedSearch = debounce((searchTerm, sortBy) => {
        onFilter(searchTerm, sortBy);
    }, 300);
    
    // Écouteur sur l'input de recherche
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value;
        const sortBy = sortSelect.value;
        debouncedSearch(searchTerm, sortBy);
    });
    
    // Écouteur sur le select de tri
    sortSelect.addEventListener('change', (e) => {
        const searchTerm = searchInput.value;
        const sortBy = e.target.value;
        onFilter(searchTerm, sortBy);
    });
}

/**
 * Réinitialise les filtres
 * @param {HTMLElement} searchInput - Input de recherche
 * @param {HTMLElement} sortSelect - Select de tri
 */
export function resetFilters(searchInput, sortSelect) {
    if (searchInput) {
        searchInput.value = '';
    }
    
    if (sortSelect) {
        sortSelect.value = 'popularity';
    }
}

export default {
    filterMoviesBySearch,
    sortMovies,
    applyFiltersAndSort,
    debounce,
    initFilters,
    resetFilters
};