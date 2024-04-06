<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title><?php echo $pageTitle ?></title> <!-- Affiche le titre récupèré, correspondant a la page  -->
</head>

<header>
    <nav class="navbar bg-body-tertiary">
        <form class="container-fluid justify-content-start">
            <!-- Boutons pour naviguer entre les pages d'ajout de produit et de récapitulatif du panier -->
            <a href="index.php" class="btn btn-primary me-2" type="button">Ajouter produit</a>
            <a href="recap.php" class="btn btn-primary position-relative" type="button">Panier
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo $totalQtt; ?></span></a>
        </form>
    </nav>
</header>

<body>
    
<?= $content; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>