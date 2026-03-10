<?php
include_once './includes/header.php';
?>

<!-- Section Filtres et Recherche -->
<section class="filters">
    <div class="filters__container">
        <h1 class="filters__title">
            <i class="fas fa-film"></i>
            Catalogue de films
        </h1>

        <div class="filters__controls">
            <!-- Barre de recherche -->
            <div class="search">
                <i class="fas fa-search search__icon"></i>
                <input
                    type="text"
                    class="search__input"
                    id="searchInput"
                    placeholder="Rechercher un film..."
                    aria-label="Rechercher un film">
            </div>

            <!-- Menu de tri -->
            <div class="sort">
                <label for="sortSelect" class="sort__label">
                    <i class="fas fa-sort"></i>
                    Trier par :
                </label>
                <select id="sortSelect" class="sort__select">
                    <option value="popularity">Popularité</option>
                    <option value="rating">Note</option>
                    <option value="date">Date de sortie</option>
                    <option value="title">Titre (A-Z)</option>
                </select>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="stats">
            <p class="stats__text">
                <span id="resultsCount">0</span> film(s) trouvé(s)
            </p>
        </div>
    </div>
</section>

<!-- Section Grille de films -->
<section class="movies">
    <div class="movies__container">
        <!-- Loader -->
        <div class="loader" id="loader">
            <div class="loader__spinner"></div>
            <p class="loader__text">Chargement des films...</p>
        </div>

        <!-- Message d'erreur -->
        <div class="error" id="error" style="display: none;">
            <i class="fas fa-exclamation-triangle error__icon"></i>
            <p class="error__text">Une erreur est survenue lors du chargement des films.</p>
            <button class="btn btn--primary" onclick="location.reload()">
                <i class="fas fa-redo"></i>
                Réessayer
            </button>
        </div>

        <!-- Grille de cartes films -->
        <div class="grid" id="moviesGrid">
            <!-- Les cartes seront générées dynamiquement par JavaScript -->
        </div>

        <!-- Message aucun résultat -->
        <div class="no-results" id="noResults" style="display: none;">
            <i class="fas fa-search no-results__icon"></i>
            <p class="no-results__text">Aucun film ne correspond à votre recherche.</p>
        </div>
    </div>
</section>


<?php
include_once './includes/footer.php';
?>