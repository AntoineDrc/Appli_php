<?php 
    // Démarre une nouvelle session ou reprend une session existante
    session_start();
    
    // Vérifie si un ID a été envoyé via GET et le stocke dans $id, sinon $id est null
    $id = (isset($_GET["id"])) ? $_GET["id"] : null;
    
    // Vérifie si une action spécifique a été demandée via GET
    if(isset($_GET['action']))
    {
        // Sélectionne l'action à effectuer basée sur le paramètre 'action' dans l'URL
        switch($_GET['action'])
        {
            // Cas où un produit est ajouté au panier
            case "add": 
                // Vérifie si le formulaire a été soumis
                if(isset($_POST['submit']))
                {
                    // Nettoie et valide les données du formulaire pour éviter l'injection de code
                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

                    // Vérifie si toutes les données du formulaire sont valides
                    if($name && $price && $qtt)
                    {
                        // Crée un tableau représentant le produit avec nom, prix, quantité, et total
                        $product = 
                        [
                            "name" => $name,
                            "price" => $price,
                            "qtt" => $qtt,
                            "total" => $price*$qtt
                        ];

                        // Ajoute le produit au tableau 'products' dans la session
                        $_SESSION['products'][] = $product;
                    }

                        // Message en cas de réussite d'ajout du produit
                        $_SESSION['message'] = "Produit ajouté avec succès !";
                } else 
                {
                    $_SESSION['message'] = "Erreur lors de l'ajout du produit";
                }
                            
                // Redirige l'utilisateur vers la page principale pour éviter la soumission multiple du formulaire
                header("Location:index.php");
                break;

            // Cas pour vider entièrement le panier
            case "vider":
                // Supprime le tableau 'products' de la session
                unset($_SESSION['products']);
                // Redirige vers la page de récapitulatif et termine le script
                header("Location:recap.php"); die;
                break;

            // Cas pour supprimer un produit spécifique du panier
            case "supprimer":
                // Supprime le produit spécifié par $id du tableau 'products'
                unset($_SESSION['products'][$_GET['id']]);
                // Message lors de la suppression
                $_SESSION['message'] = "Le produit a été supprimé du panier !";
                // Redirige et termine le script
                header("Location:recap.php"); die;
                break;

            // Cas pour augmenter la quantité d'un produit spécifique
            case "ajouter":
                // Incrémente la quantité du produit spécifié par $id
                $_SESSION['products'][$_GET['id']]['qtt']++;
                // Redirige et termine le script
                header("Location:recap.php"); die;
                break;

            // Cas pour diminuer la quantité d'un produit spécifique
            case "retirer":
                // Décrémente la quantité du produit spécifié par $id
                $_SESSION['products'][$_GET['id']]['qtt']--;
                // Redirige et termine le script
                header("Location:recap.php"); die;
                break;
        }       
    }

    // Afficher le nombre de produits dans le panier 

    // Initialisation de la variable total quantité
    $totalQtt = 0;

    // Boucler sur tout les produits de la session 
    foreach($_SESSION['products'] as $product)
    {
        $totalQtt += $product['qtt'];
    }

    
    ?>
