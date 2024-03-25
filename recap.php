<?php 
    include 'traitement.php';
    ob_start(); // Démarre la temporisation de sortie 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Récapitulatif des produits</title>
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
<?php 
$content = ob_get_clean(); // Récupère le contenue capturé, le stock dans la variable content puis l'efface
$pageTitle = "Récapitulatif des produits"; // Définit le titre de la page pour utilisation dans le fichier template 
require_once "template.php";

?>
<body>
    <?php
    
    // Vérifie si le tableau 'products' dans la session est défini et non vide
    if(!isset($_SESSION['products']) || empty($_SESSION['products']))
    {
        // Affiche un message si aucun produit n'est en session
        echo "<p>Aucun produit en session...</p>";
    } else 
    {
        // Commence la construction du tableau HTML pour afficher les produits
        echo "<table class='table table-striped'>",
                "<thead>",
                    "<tr>",
                        "<th>ID</th>",
                        "<th>Nom</th>",
                        "<th>Prix unitaire</th>",
                        "<th>Quantité</th>",
                        "<th colspan='3'>Actions</th>",
                    "</tr>",
                "</thead>",
                "<tbody>";
        $totalGeneral = 0;
        // Boucle à travers chaque produit dans la session pour les afficher
        foreach($_SESSION['products'] as $index => $product)
        {
            echo "<tr>",
                    "<td>".$index."</td>",
                    "<td>".$product['name']."</td>",
                    "<td>".number_format($product['price'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                    "<td>".$product['qtt']."</td>",
                    // Boutons pour ajuster la quantité de chaque produit
                    "<td><a class='btn btn-outline-success' href='traitement.php?action=ajouter&id=$index'>+</a></td>",
                    "<td><a class='btn btn-outline-danger' href='traitement.php?action=retirer&id=$index'>-</a></td>",
                    "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                    // Bouton pour supprimer un produit du panier
                    "<td><a class='btn btn-danger' href='traitement.php?action=supprimer&id=$index'>Supprimer</a></td>",
                "</tr>";
            $totalGeneral += $product['total'];
        }
        // Affiche le total général des produits dans le panier
        echo "<tr>",
                "<td colspan='6'>Total général : </td>",
                "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;"). "&nbsp;€</strong></td>", 
            "</tr>",
            "</tbody>",
            "</table>";
    }
    ?>

    <!-- Bouton pour vider entièrement le panier -->
    <a class="btn btn-danger" href="traitement.php?action=vider">Vider le panier</a>

    <div>
    <?php 
    // Affichage du message en cas de suppression d'un article 
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-danger mt-3'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
        }
    ?>
    </div>

<!-- Script Bootstrap pour assurer le bon fonctionnement des composants interactifs -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
