<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CineVerse - Découvrez les meilleurs films du moment">
    <title>CineVerse - Accueil</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/responsive.css?v=<?= time(); ?>">
</head>
<body>
    <!-- Header avec Navigation -->
    <header class="header">
        <nav class="nav">
            <div class="nav__container">
                <a href="/cineverse/index.php" class="nav__logo">
                    <i class="fas fa-film"></i>
                    <span>CineVerse</span>
                </a>
                
                <ul class="nav__menu">
                    <li class="nav__item">
                        <a href="/cineverse/index.php" class="nav__link nav__link--active">
                            <i class="fa-solid fa-house"></i>
                            Accueil
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="/cineverse/movies.php" class="nav__link">
                            <i class="fas fa-video"></i>
                            Films
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="/cineverse/index.php#about" class="nav__link">
                            <i class="fas fa-info-circle"></i>
                            À propos
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="/cineverse/inscription.php" class="nav__link">
                            <i class="fas fa-user-plus"></i>
                            S'inscrire
                        </a>
                    </li>
                    <li class="nav__item">
                        <a href="/cineverse/connexion.php" class="nav__link">
                            <i class="fas fa-sign-in-alt"></i>
                            Se connecter
                        </a>
                </ul>
                
                <!-- Menu burger pour mobile -->
                <button class="nav__toggle" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- Section Hero -->
    <main>