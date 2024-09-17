<?php
session_start();

// Validation du formulaire
if (isset($_POST['email']) && isset($_POST['password'])) {
    include 'variables.php';
    $loggedUser = null;
    $errorMessage = null;

    // Parcourir la liste des utilisateurs
    foreach ($users as $user) {
        if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
            $loggedUser = [
                'email' => $user['email'],
                'full_name' => $user['full_name']
            ];
            $_SESSION['user'] = $loggedUser;

            // Vérifier si l'utilisateur souhaite rester connecté
            if (isset($_POST['remember_me'])) {
                // Créer un cookie qui expire dans 1 an
                setcookie('LOGGED_USER', $loggedUser['email'], time() + 365*24*3600, "", "", false, true);
            }

            // Redirection vers index.php après connexion réussie
            header('Location: index.php');
            exit;
        }
    }

    if (!$loggedUser) {
        $errorMessage = sprintf(
            'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
            $_POST['email'],
            $_POST['password']
        );
    }
}

// Si un utilisateur est déjà connecté via la session ou le cookie, on le récupère
if (isset($_SESSION['user'])) {
    $loggedUser = $_SESSION['user'];
} elseif (isset($_COOKIE['LOGGED_USER'])) {
    foreach ($users as $user) {
        if ($user['email'] === $_COOKIE['LOGGED_USER']) {
            $loggedUser = [
                'email' => $user['email'],
                'full_name' => $user['full_name']
            ];
            $_SESSION['user'] = $loggedUser;
            break;
        }
    }
}
?>

<?php if (!$loggedUser) : ?>
    <form action="login.php" method="post">
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $errorMessage; ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="you@exemple.com" required>
            <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
            <label class="form-check-label" for="remember_me">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
<?php else : ?>
    <div class="alert alert-success" role="alert">
        Bonjour <?= $loggedUser['email']; ?> et bienvenue sur le site !
    </div>
<?php endif; ?>