<?php
include_once './includes/header.php';
?>

<section class="hero">
    <div class="hero__container">
        <div class="hero__content">
            <h1 class="hero__title">
                Découvrez l'univers<br>
                <span class="hero__title--highlight">du cinéma</span>
            </h1>
            <p class="hero__description">
                Explorez des milliers de films, lisez les critiques et trouvez votre prochaine séance cinéma.
            </p>
            <a href="movies.php" class="btn btn--primary">
                <i class="fas fa-play"></i>
                Découvrir les films
            </a>
        </div>
        <div class="hero__image">
            <i class="fas fa-film hero__icon"></i>
        </div>
    </div>
</section>

<!-- Section Fonctionnalités -->
<section class="features" id="about">
    <div class="features__container">
        <h2 class="features__title">Pourquoi CineVerse ?</h2>

        <div class="features__grid">
            <article class="feature-card">
                <div class="feature-card__icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="feature-card__title">Recherche avancée</h3>
                <p class="feature-card__description">
                    Trouvez facilement vos films préférés grâce à notre système de recherche puissant.
                </p>
            </article>

            <article class="feature-card">
                <div class="feature-card__icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="feature-card__title">Notes et critiques</h3>
                <p class="feature-card__description">
                    Consultez les avis et notes de milliers d'utilisateurs avant de choisir.
                </p>
            </article>

            <article class="feature-card">
                <div class="feature-card__icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-card__title">Design responsive</h3>
                <p class="feature-card__description">
                    Profitez d'une expérience optimale sur tous vos appareils.
                </p>
            </article>

            <article class="feature-card">
                <div class="feature-card__icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="feature-card__title">Rapide et moderne</h3>
                <p class="feature-card__description">
                    Interface rapide et intuitive pour une navigation fluide.
                </p>
            </article>
        </div>
    </div>
</section>

<?php
include_once './includes/footer.php';
?>