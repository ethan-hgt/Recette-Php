<!-- submit_contact.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Récapitulatif de Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- inclusion de l'entête du site -->
    <?php include_once('header.php'); ?>

    <h1>Récapitulatif de Contact</h1>

    <?php
    // Vérification des paramètres email et message
    if (
        !isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || 
        !isset($_POST['message']) || empty($_POST['message'])
    ) {
        echo '<h1>Il faut un email et un message valides pour soumettre le formulaire.</h1>';
        return; // Arrêter l'exécution si les paramètres sont invalides
    }

    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rappel de vos informations</h5>
            <p class="card-text"><b>Email</b> : <?php echo $email; ?></p>
            <p class="card-text"><b>Message</b> : <?php echo $message; ?></p>
        </div>
    </div>
</div>

    <!-- inclusion du bas de page -->
    <?php include_once('footer.php'); ?>
</body>
</html>