<?php 
    session_start();

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

    // Fonction pour vider le panier en cliquant sur "supprimer"
    if(isset($_GET['action']) && $_GET['action'] == 'Supprimer')
    {
        unset($_SESSION['products']);
    }
?>


<!-- if(isset($_SESSION['products'])) -->
