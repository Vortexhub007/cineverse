<?php

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard-cineverse.php');
    exit();
}

include_once './database/config.php';

$erreurs = [];
$email   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email      = htmlspecialchars(trim($_POST['email']      ?? ''));
    $motdepasse = $_POST['motdepasse'] ?? '';

    // ── Validation email ─────────────────────
    if (empty($email)) {
        $erreurs[] = "L'adresse e-mail est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Le format de l'adresse e-mail est invalide.";
    }

    // ── Validation mot de passe ──────────────
    if (empty($motdepasse)) {
        $erreurs[] = "Le mot de passe est obligatoire.";
    }

    // ── Vérification en base ─────────────────
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($motdepasse, $user['password_hash'])) {
                // Message générique pour ne pas révéler si l'email existe
                $erreurs[] = "Identifiants incorrects. Veuillez réessayer.";
            } else {
                // ── Connexion réussie ────────────────────
                session_regenerate_id(true);

                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];

                header('Location: dashboard-cineverse.php');
                exit();
            }

        } catch (PDOException $e) {
            $erreurs[] = "Erreur lors de la connexion : " . $e->getMessage();
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
                <h1 class="card__title">Connexion</h1>
                <p class="card__subtitle">Bon retour parmi nous !</p>
            </div>

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
            <form method="POST" action="" novalidate>
                <div class="form__fields">

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
                            class="form__input <?= !empty($erreurs) ? 'form__input--invalid' : '' ?>"
                            value="<?= htmlspecialchars($email) ?>"
                            maxlength="255"
                            placeholder="vous@exemple.com"
                            autocomplete="email"
                            required
                        >
                    </div>

                    <!-- password_hash → vérifié via password_verify() -->
                    <div class="form__field">
                        <div class="form__field-header">
                            <label class="form__label" for="motdepasse">
                                <i class="fa-solid fa-lock"></i>
                                Mot de passe
                            </label>
                        </div>
                        <input
                            type="password"
                            id="motdepasse"
                            name="motdepasse"
                            class="form__input <?= !empty($erreurs) ? 'form__input--invalid' : '' ?>"
                            maxlength="255"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn--primary">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Se connecter
                    </button>

                </div>
            </form>

            <div class="card__footer">
                Pas encore de compte ? <a href="inscription.php">S'inscrire</a>
            </div>

        </div><!-- /.card__body -->
    </div><!-- /.card -->
</div><!-- /.page-wrapper -->

<?php
include_once './includes/footer.php';
?>