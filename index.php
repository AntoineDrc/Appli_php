<?php 
include 'traitement.php';
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <title>Ajout Produit</title>
    </head>
    <header>
        <nav class="navbar bg-body-tertiary">
            <form class="container-fluid justify-content-start">
                <a href="index.php" class="btn btn-primary me-2" type="button">Ajouter produit</a>
                <a href="recap.php" class="btn btn-primary position-relative" type="button">Panier
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo $totalQtt; ?></span></a>
                
            </form>
        </nav>
    </header>
    <body>
        
        <h1 class="display-5 text-primary fw-bold">Ajouter un produit</h1>
        <form action="traitement.php?action=add" method="post">
            <p>
                <label>
                    Nom de produit : 
                    <input type="text" name="name" class="input-group flex-nowrap">
                </label>
            </p>
            <p>
                <label>
                    Prix du produit en € : 
                    <input type="number" step="any" name="price" class="input-group flex-nowrap">
                </label>
            </p>
            <p>
                <label>
                    Quantité désirée : 
                    <input type="text" name="qtt" value="1" class="input-group flex-nowrap">
                </label>
            </p>
            <p>
                <input type="submit" name="submit" value="Ajouter le produit" class="btn btn-primary">
            </p>
        </form>
        <?php  
            // Affichage du message lors de l'ajout d'un produit
            if (isset($_SESSION['message'])) {
            echo "<p>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
            } 
        ?>    
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </body>
</html>

