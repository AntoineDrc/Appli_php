<?php 
    // Démarre une nouvelle session ou reprend une session existante
    session_start();

    // Vérifie si un fichier a été téléchargé via le formulaire
    if (isset($_FILES['file'])) {

    // Récupère les informations du fichier téléchargé
    $name = $_FILES['file']['name']; // Le nom original du fichier
    $type = $_FILES['file']['type']; // Le type MIME du fichier
    $tmpName = $_FILES['file']['tmp_name']; // L'emplacement temporaire du fichier
    $error = $_FILES['file']['error']; // Le code d'erreur associé au téléchargement
    $size = $_FILES['file']['size']; // La taille du fichier en octets

    // Sépare le nom du fichier pour obtenir l'extension
    $tabExtension = explode('.', $name);
    $extension = strtolower(end($tabExtension)); // Convertit l'extension en minuscules

    // Définit les extensions de fichier autorisées et la taille maximale
    $extensionsAutorisees = ['jpg', 'jpeg', 'gif', 'png'];
    $tailleMax = 400000; // Taille maximale autorisée (en octets)

    // Vérifie si l'extension du fichier est autorisée et si la taille du fichier est inférieure à la taille maximale
    if (in_array($extension, $extensionsAutorisees) && $size <= $tailleMax && $error == 0) {
        // Génère un nom unique pour le fichier pour éviter les conflits sur le serveur
        $uniqueName = uniqid('', true); // Génère un identifiant unique
        $fileName = $uniqueName . '.' . $extension; // Crée le nouveau nom de fichier avec l'extension

        // Déplace le fichier du répertoire temporaire vers le répertoire de destination
        move_uploaded_file($tmpName, './upload/' . $fileName);
    } else 
    {
        echo 'Mauvaise extension ou taille trop importante ou erreur présente';
    }

    }
   
    
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
                            "total" => $price*$qtt,
                            "image" => $fileName
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



            // Cas pour vider entièrement le panier et TOUTES les photos dans le répertoire
            case "vider";
                // Récupère tout les fichiers dans le repertoire
                $photos = glob('./upload/*');
                // Parcourt et supprime les photos
                foreach($photos as $photo)
                {
                    if(is_file($photo)) // Vérifie si l'élément est un fichier
                    {
                        unlink($photo); // Supprime le fichier 
                    }
                }
                // Supprime le tableau 'products' de la session
                unset($_SESSION['products']);
                // Redirige vers la page de récapitulatif et termine le script
                header("Location:recap.php"); die;
                break;



            // Cas pour supprimer un produit spécifique du panier
            case "supprimer":
                if(isset($_SESSION['products'][$_GET['id']]['image'])) 
                {
                    // Construit le chemin complet vers le fichier image
                    $cheminFichier = './upload/' . $_SESSION['products'][$_GET['id']]['image'];
                    // Vérifie si le fichier existe avant de tenter de le supprimer
                    if(file_exists($cheminFichier)) {
                        unlink($cheminFichier); // Supprime le fichier
                    }
                }
                // Supprime l'entrée du produit de la session après avoir supprimé l'image
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
                
                // Supprime l'article si la quantité est inférieure à 0
                if ($_SESSION['products'][$_GET['id']]['qtt'] < 1)
                {
                    // Supprime le produit spécifié par $id du tableau 'products'
                    unset($_SESSION['products'][$_GET['id']]);
                    // Message lors de la suppression
                    $_SESSION['message'] = "Le produit a été supprimé du panier !";
                }
                // Redirige et termine le script
                header("Location:recap.php"); die;
                break;
        }       
    }

    // Afficher le nombre de produits dans le panier 

    // Initialisation de la variable total quantité
    $totalQtt = 0;
    if(isset($_SESSION["products"])) {
        // Boucler sur tout les produits de la session 
        foreach($_SESSION['products'] as $product)
        {
            $totalQtt += $product['qtt'];

        }
    }

    
    ?>

