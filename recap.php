<?php 

    session_start();

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
            <a href="index.php" class="btn btn-primary me-2" type="button">Ajouter produit</a>
            <a href="recap.php" class="btn btn-primary" type="button">Panier</a>
        </form>
    </nav>
</header>
<body>
    <?php
    
    if(!isset($_SESSION['products']) || empty($_SESSION['products']))
    {
        echo "<p>Aucun produit en session...</p>";
    } else 
    {
        echo "<table class='table table-striped'>",
                "<thead>",
                    "<tr>",
                        "<th></th>",
                        "<th></th>",
                        "<th></th>",
                        "<th></th>",
                        "<th></th>",
                        "<th></th>",
                    "</tr>",
                "</thead>",
                "<tbody>";
        $totalGeneral = 0;
        foreach($_SESSION['products'] as $index => $product)
        {
            echo "<tr>",
                    "<td>".$index."</td>",
                    "<td>".$product['name']."</td>",
                    "<td>".number_format($product['price'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                    "<td>".$product['qtt']."</td>",
                    "<td><a class='btn btn-outline-success' href='traitement.php?action=ajouter&id=$index'>+</a></td>",
                    "<td><a class='btn btn-outline-danger' href='traitement.php?action=retirer&id=$index'>-</a></td>",
                    "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                    "<td><a class='btn btn-danger' href='traitement.php?action=supprimer&id=$index'>Supprimer</a></td>",
                "</tr>";
            $totalGeneral += $product['total'];
        }
        echo "<tr>",
                "<td colspan=4>Total général : </td>",
                "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;"). "&nbsp;€</strong></td>", 
            "</tr>",
            "</tbody>",
            "</table>";
    }
    ?>

    <a class="btn btn-danger" href="traitement.php?action=vider">Vider le panier</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

