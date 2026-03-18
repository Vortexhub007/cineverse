<?php
// Protection : accès réservé aux utilisateurs connectés
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

include_once './database/config.php';

$username = $_SESSION['username'] ?? 'Utilisateur';
$role     = $_SESSION['role']     ?? 'user';

include_once 'includes/header.php';
?>

<!-- Overlay mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Bouton toggle sidebar (mobile) -->
<button class="sidebar__toggle" id="sidebarToggle" aria-label="Ouvrir le menu">
    <i class="fa-solid fa-bars"></i>
</button>

<div class="dashboard">

    <!-- ==========================================
         SIDEBAR
         ========================================== -->
    <aside class="sidebar" id="sidebar">

        <a href="index.php" class="sidebar__logo">
            <i class="fa-solid fa-film"></i>
            CineVerse
        </a>

        <div class="sidebar__user">
            <div class="sidebar__avatar">
                <?= strtoupper(mb_substr($username, 0, 1)) ?>
            </div>
            <div class="sidebar__user-info">
                <div class="sidebar__user-name"><?= htmlspecialchars($username) ?></div>
                <div class="sidebar__user-role"><?= ucfirst($role) ?></div>
            </div>
        </div>

        <nav class="sidebar__nav">
            <div class="sidebar__nav-label">Navigation</div>
            <a href="#favoris"    class="sidebar__link sidebar__link--active">
                <i class="fa-solid fa-heart"></i>
                Favoris
                <span class="sidebar__badge">0</span>
            </a>
            <a href="#watchlist"  class="sidebar__link">
                <i class="fa-solid fa-bookmark"></i>
                Watchlist
                <span class="sidebar__badge">0</span>
            </a>
            <a href="#commentaires" class="sidebar__link">
                <i class="fa-solid fa-comment"></i>
                Commentaires
                <span class="sidebar__badge">0</span>
            </a>
            <a href="#profil" class="sidebar__link">
                <i class="fa-solid fa-user"></i>
                Mon profil
            </a>

            <div class="sidebar__nav-label" style="margin-top: var(--spacing-sm);">Explorer</div>
            <a href="index.php" class="sidebar__link">
                <i class="fa-solid fa-house"></i>
                Accueil
            </a>
            <a href="movies.php" class="sidebar__link">
                <i class="fa-solid fa-clapperboard"></i>
                Films
            </a>
        </nav>

        <div class="sidebar__footer">
            <a href="connexion.php" class="sidebar__logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Se déconnecter
            </a>
        </div>

    </aside>

    <!-- ==========================================
         CONTENU PRINCIPAL
         ========================================== -->
    <main class="main">

        <!-- Topbar -->
        <div class="topbar">
            <span class="topbar__title">
                Bonjour, <?= htmlspecialchars($username) ?> 👋
            </span>
            <div class="topbar__actions">
                <a href="movies.php" class="topbar__btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Explorer les films</span>
                </a>
            </div>
        </div>

        <div class="content">

            <!-- ── Stats rapides ── -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card__icon"><i class="fa-solid fa-heart"></i></div>
                    <div>
                        <div class="stat-card__value">0</div>
                        <div class="stat-card__label">Favoris</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon"><i class="fa-solid fa-bookmark"></i></div>
                    <div>
                        <div class="stat-card__value">0</div>
                        <div class="stat-card__label">Watchlist</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon"><i class="fa-solid fa-eye"></i></div>
                    <div>
                        <div class="stat-card__value">0</div>
                        <div class="stat-card__label">Films vus</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon"><i class="fa-solid fa-comment"></i></div>
                    <div>
                        <div class="stat-card__value">0</div>
                        <div class="stat-card__label">Commentaires</div>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 SECTION FAVORIS
                 ========================================== -->
            <section class="section" id="favoris">
                <div class="section__header">
                    <h2 class="section__title">
                        <i class="fa-solid fa-heart"></i>
                        Mes favoris
                        <span class="section__count">0 film(s)</span>
                    </h2>
                    <a href="movies.php" class="section__link">
                        Ajouter un film <i class="fa-solid fa-plus"></i>
                    </a>
                </div>

                <!-- État vide -->
                <div class="empty-state">
                    <i class="fa-regular fa-heart"></i>
                    <p class="empty-state__text">Vous n'avez aucun film en favoris pour l'instant.</p>
                    <a href="movies.php" class="btn btn--primary">
                        <i class="fa-solid fa-clapperboard"></i>
                        Découvrir des films
                    </a>
                </div>

                <!-- Exemple de grille (décommenter quand les données sont réelles) -->
                <!--
                <div class="movies-grid">
                    <div class="movie-card">
                        <div class="movie-card__poster">
                            <div class="movie-card__poster-placeholder">
                                <i class="fa-solid fa-film"></i>
                                <span>Aucune affiche</span>
                            </div>
                            <div class="movie-card__rating">
                                <i class="fa-solid fa-star"></i> 8.2
                            </div>
                        </div>
                        <div class="movie-card__body">
                            <div class="movie-card__title">Titre du film</div>
                            <div class="movie-card__year">2024</div>
                        </div>
                        <div class="movie-card__actions">
                            <button class="movie-card__btn">
                                <i class="fa-solid fa-circle-info"></i> Détails
                            </button>
                            <button class="movie-card__btn movie-card__btn--danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                -->
            </section>

            <!-- ==========================================
                 SECTION WATCHLIST
                 ========================================== -->
            <section class="section" id="watchlist">
                <div class="section__header">
                    <h2 class="section__title">
                        <i class="fa-solid fa-bookmark"></i>
                        Ma watchlist
                        <span class="section__count">0 film(s)</span>
                    </h2>
                    <a href="movies.php" class="section__link">
                        Ajouter un film <i class="fa-solid fa-plus"></i>
                    </a>
                </div>

                <!-- État vide -->
                <div class="empty-state">
                    <i class="fa-regular fa-bookmark"></i>
                    <p class="empty-state__text">Votre watchlist est vide. Ajoutez des films à regarder !</p>
                    <a href="movies.php" class="btn btn--primary">
                        <i class="fa-solid fa-clapperboard"></i>
                        Découvrir des films
                    </a>
                </div>

                <!-- Exemple de grille avec badges de statut (décommenter quand les données sont réelles) -->
                <!--
                <div class="movies-grid">
                    <div class="movie-card">
                        <div class="movie-card__poster">
                            <div class="movie-card__poster-placeholder">
                                <i class="fa-solid fa-film"></i>
                                <span>Aucune affiche</span>
                            </div>
                            <span class="movie-card__status status--to-watch">À voir</span>
                        </div>
                        <div class="movie-card__body">
                            <div class="movie-card__title">Titre du film</div>
                            <div class="movie-card__year">2024</div>
                        </div>
                        <div class="movie-card__actions">
                            <button class="movie-card__btn">
                                <i class="fa-solid fa-circle-info"></i> Détails
                            </button>
                            <button class="movie-card__btn movie-card__btn--danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                -->
            </section>

            <!-- ==========================================
                 SECTION COMMENTAIRES
                 ========================================== -->
            <section class="section" id="commentaires">
                <div class="section__header">
                    <h2 class="section__title">
                        <i class="fa-solid fa-comment"></i>
                        Mes commentaires
                        <span class="section__count">0 commentaire(s)</span>
                    </h2>
                </div>

                <!-- État vide -->
                <div class="empty-state">
                    <i class="fa-regular fa-comment"></i>
                    <p class="empty-state__text">Vous n'avez encore rédigé aucun commentaire.</p>
                    <a href="movies.php" class="btn btn--primary">
                        <i class="fa-solid fa-star"></i>
                        Noter un film
                    </a>
                </div>

                <!-- Exemple de liste (décommenter quand les données sont réelles) -->
                <!--
                <div class="comments-list">
                    <div class="comment-card">
                        <div class="comment-card__poster">
                            <i class="fa-solid fa-film"></i>
                        </div>
                        <div>
                            <div class="comment-card__header">
                                <div class="comment-card__movie">Titre du film</div>
                                <div class="comment-card__meta">
                                    <div class="comment-card__rating">
                                        <i class="fa-solid fa-star"></i> 8/10
                                    </div>
                                    <div class="comment-card__date">01/01/2025</div>
                                </div>
                            </div>
                            <p class="comment-card__text">
                                Contenu du commentaire ici...
                            </p>
                            <div class="comment-card__actions">
                                <button class="comment-card__btn">
                                    <i class="fa-solid fa-pen"></i> Modifier
                                </button>
                                <button class="comment-card__btn comment-card__btn--danger">
                                    <i class="fa-solid fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                -->
            </section>

            <!-- ==========================================
                 SECTION PROFIL
                 ========================================== -->
            <section class="section" id="profil">
                <div class="section__header">
                    <h2 class="section__title">
                        <i class="fa-solid fa-user"></i>
                        Mon profil
                    </h2>
                </div>

                <div class="profile-grid">

                    <!-- Carte résumé -->
                    <div class="profile-card">
                        <div class="profile-card__top-bar"></div>
                        <div class="profile-card__body">
                            <div class="profile-avatar">
                                <?= strtoupper(mb_substr($username, 0, 1)) ?>
                            </div>
                            <div class="profile-info-name"><?= htmlspecialchars($username) ?></div>
                            <div class="profile-info-role"><?= ucfirst($role) ?></div>
                            <div class="profile-stats">
                                <div class="profile-stat">
                                    <div class="profile-stat__value">0</div>
                                    <div class="profile-stat__label">Favoris</div>
                                </div>
                                <div class="profile-stat">
                                    <div class="profile-stat__value">0</div>
                                    <div class="profile-stat__label">Watchlist</div>
                                </div>
                                <div class="profile-stat">
                                    <div class="profile-stat__value">0</div>
                                    <div class="profile-stat__label">Avis</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire modification profil -->
                    <div class="profile-card">
                        <div class="profile-card__top-bar"></div>
                        <div class="profile-card__body">

                            <div class="profile-form__title">
                                <i class="fa-solid fa-pen"></i>
                                Modifier mes informations
                            </div>

                            <form method="POST" action="update-profil.php" novalidate>
                                <div class="form__fields">

                                    <!-- username → VARCHAR(100) -->
                                    <div class="form__field">
                                        <label class="form__label" for="username">
                                            <i class="fa-solid fa-user"></i>
                                            Nom d'utilisateur
                                        </label>
                                        <input
                                            type="text"
                                            id="username"
                                            name="username"
                                            class="form__input"
                                            value="<?= htmlspecialchars($username) ?>"
                                            maxlength="100"
                                            required
                                        >
                                    </div>

                                    <!-- email → VARCHAR(255) -->
                                    <div class="form__field">
                                        <label class="form__label" for="email_profil">
                                            <i class="fa-solid fa-envelope"></i>
                                            Adresse e-mail
                                        </label>
                                        <input
                                            type="email"
                                            id="email_profil"
                                            name="email"
                                            class="form__input"
                                            placeholder="vous@exemple.com"
                                            maxlength="255"
                                            required
                                        >
                                    </div>

                                    <div class="profile-form__title" style="margin-top: var(--spacing-sm);">
                                        <i class="fa-solid fa-lock"></i>
                                        Changer le mot de passe
                                    </div>

                                    <!-- Nouveau mot de passe (optionnel) -->
                                    <div class="form__row">
                                        <div class="form__field">
                                            <label class="form__label" for="new_password">
                                                <i class="fa-solid fa-lock"></i>
                                                Nouveau mot de passe
                                            </label>
                                            <input
                                                type="password"
                                                id="new_password"
                                                name="new_password"
                                                class="form__input"
                                                placeholder="••••••••"
                                                maxlength="255"
                                                autocomplete="new-password"
                                            >
                                            <span class="form__hint">Laisser vide pour ne pas modifier</span>
                                        </div>
                                        <div class="form__field">
                                            <label class="form__label" for="confirm_password">
                                                <i class="fa-solid fa-shield-halved"></i>
                                                Confirmer
                                            </label>
                                            <input
                                                type="password"
                                                id="confirm_password"
                                                name="confirm_password"
                                                class="form__input"
                                                placeholder="••••••••"
                                                maxlength="255"
                                                autocomplete="new-password"
                                            >
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
                                        <button type="submit" class="btn btn--primary">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                            Enregistrer
                                        </button>
                                        <button type="reset" class="btn btn--secondary">
                                            <i class="fa-solid fa-rotate-left"></i>
                                            Annuler
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>

                </div><!-- /.profile-grid -->
            </section>

        </div><!-- /.content -->
    </main>

</div><!-- /.dashboard -->

<script>
    // ── Toggle sidebar mobile ──────────────────
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-open');
        toggle.innerHTML = '<i class="fa-solid fa-xmark"></i>';
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-open');
        toggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
    }

    toggle.addEventListener('click', () => {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    // ── Lien actif selon l'ancre visible ──────
    const sections = document.querySelectorAll('.section');
    const navLinks = document.querySelectorAll('.sidebar__link[href^="#"]');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('sidebar__link--active');
                    if (link.getAttribute('href') === '#' + entry.target.id) {
                        link.classList.add('sidebar__link--active');
                    }
                });
            }
        });
    }, { threshold: 0.3 });

    sections.forEach(s => observer.observe(s));
</script>

<?php include_once 'includes/footer.php'; ?>