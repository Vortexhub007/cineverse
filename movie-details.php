<?php
include_once './includes/header.php';
?>


<!-- Bouton retour -->
<section class="back-section">
    <div class="back-section__container">
        <a href="movies.php" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i>
            Retour aux films
        </a>
    </div>
</section>

<!-- Loader -->
<div class="loader" id="loader">
    <div class="loader__spinner"></div>
    <p class="loader__text">Chargement du film...</p>
</div>

<!-- Section Détails du film -->
<section class="movie-details" id="movieDetails" style="display: none;">
    <!-- Le contenu sera généré dynamiquement par JavaScript -->
</section>

<!-- Message d'erreur -->
<div class="error" id="error" style="display: none;">
    <i class="fas fa-exclamation-triangle error__icon"></i>
    <p class="error__text">Film non trouvé ou erreur de chargement.</p>
    <a href="movies.php" class="btn btn--primary">
        <i class="fas fa-arrow-left"></i>
        Retour aux films
    </a>
</div>

<?php
include_once './includes/footer.php';
?>