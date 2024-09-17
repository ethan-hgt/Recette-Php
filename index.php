<?php
session_start();

include_once('variables.php');
include_once('functions.php');

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
        <?php include_once('header.php'); ?>
        <h1>Site de recettes</h1>

        <?php include_once('login.php'); ?>

        <?php if ($loggedUser): ?>
            <h2>Bonjour <?= $loggedUser['email'] ?>, voici la liste des recettes :</h2>
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
            <p>Veuillez vous connecter pour voir la liste des recettes.</p>
        <?php endif; ?>
    </div>

    <?php include_once('footer.php'); ?>
</body>
</html>