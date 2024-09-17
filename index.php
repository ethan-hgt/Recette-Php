<?php
session_start();  // Pour gérer la session utilisateur

// Inclure les fichiers nécessaires
include_once('variables.php');
include_once('functions.php');

// Vérifier si un utilisateur est connecté
$loggedUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <!-- Inclusion de l'entête du site -->
        <?php include_once('header.php'); ?>
        <h1>Site de recettes</h1>

        <!-- Si l'utilisateur est connecté, on affiche les recettes -->
        <?php if ($loggedUser): ?>
            <div class="alert alert-success">
                Bonjour <?= $loggedUser['email']; ?>, bienvenue sur le site !
            </div>
            <h2>Voici la liste des recettes :</h2>
            <?php foreach(getRecipes($recipes) as $recipe) : ?>
                <?php if ($recipe['is_enabled']) : ?>
                    <article>
                        <h3><?= $recipe['title']; ?></h3>
                        <div><?= $recipe['recipe']; ?></div>
                        <i><?= displayAuthor($recipe['author'], $users); ?></i>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Inclusion du formulaire de connexion si l'utilisateur n'est pas connecté -->
            <p>Veuillez vous connecter pour voir la liste des recettes.</p>
            <?php include_once('login.php'); ?>
        <?php endif; ?>
    </div>

    <!-- Inclusion du bas de page du site -->
    <?php include_once('footer.php'); ?>
</body>
</html>