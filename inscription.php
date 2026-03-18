<?php

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard-cineverse.php');
    exit();
}

include_once './database/config.php';


$erreurs  = [];
$succes   = false;
$username = '';
$email    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username     = htmlspecialchars(trim($_POST['username']     ?? ''));
    $email        = htmlspecialchars(trim($_POST['email']        ?? ''));
    $motdepasse   = $_POST['motdepasse']   ?? '';
    $confirmation = $_POST['confirmation'] ?? '';

    if (empty($username)) {
        $erreurs[] = "Le nom d'utilisateur est obligatoire.";
    } elseif (strlen($username) < 3 || strlen($username) > 100) {
        $erreurs[] = "Le nom d'utilisateur doit contenir entre 3 et 100 caractères.";
    }

    if (empty($email)) {
        $erreurs[] = "L'adresse e-mail est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Le format de l'adresse e-mail est invalide.";
    } elseif (strlen($email) > 255) {
        $erreurs[] = "L'adresse e-mail ne peut pas dépasser 255 caractères.";
    }

    if (empty($motdepasse)) {
        $erreurs[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($motdepasse) < 8) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if (empty($confirmation)) {
        $erreurs[] = "La confirmation du mot de passe est obligatoire.";
    } elseif ($motdepasse !== $confirmation) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->fetch()) {
                $erreurs[] = "Cette adresse e-mail est déjà utilisée.";
            } else {
                $passwordHash = password_hash($motdepasse, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("
                    INSERT INTO users (email, password_hash, username)
                    VALUES (:email, :password_hash, :username)
                ");
                $stmt->execute([
                    'email'         => $email,
                    'password_hash' => $passwordHash,
                    'username'      => $username,
                ]);

                $succes   = true;
                $username = '';
                $email    = '';
            }

        } catch (PDOException $e) {
            $erreurs[] = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
include_once './includes/header.php';
?>


<div class="page-wrapper">
    <div class="card">

        <div class="card__top-bar"></div>

        <div class="card__body">

            <!-- En-tête -->
            <div class="card__header">
                <h1 class="card__title">Créer un compte</h1>
                <p class="card__subtitle">Rejoignez la communauté CineVerse</p>
            </div>

            <!-- Succès -->
            <?php if ($succes): ?>
                <div class="alert alert--success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Inscription réussie !</span>
                    <a href="connexion.php">Se connecter →</a>
                </div>
            <?php endif; ?>

            <!-- Erreurs -->
            <?php if (!empty($erreurs)): ?>
                <div class="alert alert--error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <strong>Veuillez corriger les erreurs suivantes :</strong>
                        <ul>
                            <?php foreach ($erreurs as $err): ?>
                                <li><?= $err ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <?php if (!$succes): ?>
            <form method="POST" action="" novalidate>
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
                            class="form__input <?= (!empty($erreurs) && (empty($username) || strlen($username) < 3)) ? 'form__input--invalid' : '' ?>"
                            value="<?= htmlspecialchars($username) ?>"
                            maxlength="100"
                            placeholder="john_doe"
                            autocomplete="username"
                            required
                        >
                    </div>

                    <!-- email → VARCHAR(255) UNIQUE NOT NULL -->
                    <div class="form__field">
                        <label class="form__label" for="email">
                            <i class="fa-solid fa-envelope"></i>
                            Adresse e-mail
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form__input <?= in_array("L'adresse e-mail est obligatoire.", $erreurs) || in_array("Le format de l'adresse e-mail est invalide.", $erreurs) || in_array("Cette adresse e-mail est déjà utilisée.", $erreurs) ? 'form__input--invalid' : '' ?>"
                            value="<?= htmlspecialchars($email) ?>"
                            maxlength="255"
                            placeholder="vous@exemple.com"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <!-- password_hash → VARCHAR(255) NOT NULL -->
                    <div class="form__field">
                        <label class="form__label" for="motdepasse">
                            <i class="fa-solid fa-lock"></i>
                            Mot de passe
                        </label>
                        <input
                            type="password"
                            id="motdepasse"
                            name="motdepasse"
                            class="form__input <?= in_array("Le mot de passe est obligatoire.", $erreurs) || in_array("Le mot de passe doit contenir au moins 8 caractères.", $erreurs) ? 'form__input--invalid' : '' ?>"
                            maxlength="255"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            required
                        >
                        <span class="form__hint">Minimum 8 caractères</span>
                    </div>

                    <!-- Confirmation (non stockée en BDD) -->
                    <div class="form__field">
                        <label class="form__label" for="confirmation">
                            <i class="fa-solid fa-shield-halved"></i>
                            Confirmer le mot de passe
                        </label>
                        <input
                            type="password"
                            id="confirmation"
                            name="confirmation"
                            class="form__input <?= in_array("Les mots de passe ne correspondent pas.", $erreurs) || in_array("La confirmation du mot de passe est obligatoire.", $erreurs) ? 'form__input--invalid' : '' ?>"
                            maxlength="255"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <!-- role = 'user' par défaut (ENUM SQL), non exposé -->

                    <button type="submit" class="btn btn--primary">
                        <i class="fa-solid fa-user-plus"></i>
                        Créer mon compte
                    </button>

                </div>
            </form>

            <div class="card__footer">
                Déjà inscrit ? <a href="connexion.php">Se connecter</a>
            </div>

            <?php endif; ?>

        </div><!-- /.card__body -->
    </div><!-- /.card -->
</div><!-- /.page-wrapper -->

<?php 
include_once './includes/footer.php'; 
?>