<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    include 'variables.php';
    $loggedUser = null;
    $errorMessage = null;

    foreach ($users as $user) {
        if ($user['email'] === $_POST['email'] && $user['password'] === $_POST['password']) {
            $loggedUser = [
                'email' => $user['email'],
                'full_name' => $user['full_name']
            ];
            $_SESSION['user'] = $loggedUser;
            break;
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

if (isset($_SESSION['user'])) {
    $loggedUser = $_SESSION['user'];
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
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
<?php else : ?>
    <div class="alert alert-success" role="alert">
        Bonjour <?= $loggedUser['email']; ?> et bienvenue sur le site !
    </div>
<?php endif; ?>