<?php 

    include 'traitement.php';
    ob_start(); // Démarre la temporisation de sortie 

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
                        "<th>Image</th>",
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
                    "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€</td>";
                    // Vérification et affichage de l'image du produit 
                    if(isset($product['image']))
                    {
                        $imageUrl = './upload/' . $product['image'];
                        echo 
                        "<td><img src='$imageUrl' alt='image de l'article' style=width:100px></td>";
                    } else 
                    {
                        echo 
                        "Pas d'image disponible";
                    }
                    // Bouton pour supprimer un produit du panier
                    echo
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
    <?php
    $content = ob_get_clean(); // Récupère le contenue capturé, le stock dans la variable content puis l'efface
    $pageTitle = "Récapitulatif des produits"; // Définit le titre de la page pour utilisation dans le fichier template 
    require_once "template.php";
    ?>

</body>
</html>
