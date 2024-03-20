<?php 
    session_start();
    
        $id = (isset($_GET["id"])) ? $_GET["id"] : null;
        // Fonction pour vider le panier en cliquant sur "supprimer"
        if(isset($_GET['action']))
        {
            switch($_GET['action'])
            {
                case "add": 
                    if(isset($_POST['submit']))
                    {
                        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                        $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

                        if($name && $price && $qtt)
                        {
                            $product = 
                            [
                                "name" => $name,
                                "price" => $price,
                                "qtt" => $qtt,
                                "total" => $price*$qtt
                            ];

                            $_SESSION['products'][] = $product;
                        }
                    }
                    
                    header("Location:index.php");
                    break;

                case "vider":
                    unset($_SESSION['products']);
                    header("Location:recap.php"); die;
                    break;
    
                case "supprimer":
                    unset($_SESSION['products'][$_GET['id']]);
                    header("Location:recap.php"); die;
                    break;

                case "ajouter":
                    $_SESSION['products'][$_GET['id']]['qtt']++;
                    header("Location:recap.php"); die;
                    break;

                case "retirer":
                    $_SESSION['products'][$_GET['id']]['qtt']--;
                    header("Location:recap.php"); die;
                    break;
            }       
        }

    
?>



