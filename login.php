<?php
session_start();  // Démarrer la session pour gérer l'authentification

// Validation du formulaire
if (isset($_POST['email']) && isset($_POST['password'])) {
    include 'variables.php';  // Inclure le tableau des utilisateurs
    $loggedUser = null;
    $errorMessage = null;

    // Parcourir la liste des utilisateurs
    foreach ($users as $user) {
        if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
            // Si l'email et le mot de passe correspondent, connecter l'utilisateur
            $loggedUser = [
                'email' => $user['email'],
                'full_name' => $user['full_name']
            ];
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user'] = $loggedUser;
            break;
        }
    }

    // Si aucun utilisateur n'est trouvé, afficher un message d'erreur
    if (!$loggedUser) {
        $errorMessage = sprintf(
            'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
            $_POST['email'],
            $_POST['password']
        );
    }
}

// Si un utilisateur est déjà connecté, on récupère ses informations
if (isset($_SESSION['user'])) {
    $loggedUser = $_SESSION['user'];
}
?>

<!-- Si l'utilisateur n'est pas identifié, on affiche le formulaire -->
<?php if (!$loggedUser) : ?>
    <form action="login.php" method="post">
        <!-- Si message d'erreur, on l'affiche -->
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
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

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
<?php else : ?>
    <!-- Si l'utilisateur est bien connecté, on affiche un message de succès -->
    <div class="alert alert-success" role="alert">
        Bonjour <?php echo $loggedUser['email']; ?> et bienvenue sur le site !
    </div>
<?php endif; ?>