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
    // Activer l'affichage des erreurs PHP pour le débogage
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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

    // Vérifier si un fichier a été uploadé
    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK) {
        // Limite de taille du fichier (1 Mo)
        if ($_FILES['screenshot']['size'] <= 1000000) {
            // Récupération de l'extension du fichier
            $fileInfo = pathinfo($_FILES['screenshot']['name']);
            $extension = $fileInfo['extension'];
            $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

            // Vérification de l'extension
            if (in_array($extension, $allowedExtensions)) {
                // Définir le répertoire de destination
                $uploadDir = 'uploads/';
                $fileName = basename($_FILES['screenshot']['name']);
                $screenshotPath = $uploadDir . $fileName;

                // Déplacement du fichier uploadé vers le répertoire
                if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $screenshotPath)) {
                    echo '<div class="alert alert-success">Le fichier a été téléchargé avec succès.</div>';
                } else {
                    echo '<div class="alert alert-danger">Échec du téléchargement du fichier.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Type de fichier non autorisé. Veuillez télécharger une image (jpg, jpeg, gif, png).</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Le fichier est trop gros. Taille maximale : 1 Mo.</div>';
        }
    } elseif (isset($_FILES['screenshot']['error']) && $_FILES['screenshot']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Affichage des erreurs si le fichier ne s'est pas bien uploadé
        $error_messages = [
            UPLOAD_ERR_INI_SIZE   => 'Le fichier dépasse la taille maximale autorisée par le serveur.',
            UPLOAD_ERR_FORM_SIZE  => 'Le fichier dépasse la taille maximale spécifiée dans le formulaire HTML.',
            UPLOAD_ERR_PARTIAL    => 'Le fichier a été partiellement téléchargé.',
            UPLOAD_ERR_NO_FILE    => 'Aucun fichier n’a été téléchargé.',
            UPLOAD_ERR_NO_TMP_DIR => 'Un dossier temporaire est manquant.',
            UPLOAD_ERR_CANT_WRITE => 'Échec de l’écriture du fichier sur le disque.',
            UPLOAD_ERR_EXTENSION  => 'Une extension PHP a arrêté le téléchargement du fichier.',
        ];

        $error_code = $_FILES['screenshot']['error'];
        echo '<div class="alert alert-danger">Erreur lors du téléchargement : ' . ($error_messages[$error_code] ?? 'Erreur inconnue') . '</div>';
    } else {
        echo '<div class="alert alert-warning">Aucun fichier n\'a été téléchargé.</div>';
    }

    ?>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Rappel de vos informations</h5>
            <p class="card-text"><b>Email</b> : <?php echo $email; ?></p>
            <p class="card-text"><b>Message</b> : <?php echo $message; ?></p>
            <?php if (isset($screenshotPath) && file_exists($screenshotPath)): ?>
                <p class="card-text"><b>Capture d'écran</b> :</p>
                <img src="uploads/<?php echo htmlspecialchars($fileName); ?>" alt="Screenshot" class="img-fluid" />
            <?php endif; ?>
        </div>
    </div>

    </div>

    <!-- inclusion du bas de page -->
    <?php include_once('footer.php'); ?>
</body>
</html>