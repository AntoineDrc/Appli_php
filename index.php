<?php 

include 'traitement.php';
ob_start();

    
    $content = ob_get_clean(); // Récupère le contenue capturé, le stock dans la variable content puis l'efface
    $pageTitle = "Ajout Produit"; // Définit le titre de la page pour utilisation dans le fichier
    require_once "template.php"; 

?>

    <body>
        
        <h1 class="display-5 text-primary fw-bold">Ajouter un produit</h1>
        <form action="traitement.php?action=add" method="post" enctype="multipart/form-data">
            <p>
                <label>
                    Nom de produit : 
                    <input type="text" name="name" class="input-group flex-nowrap">
                </label>
            </p>
            <p>
                <label>
                    Prix du produit en € : 
                    <input type="number" min='1' step="any" name="price" class="input-group flex-nowrap">
                </label>
            </p>
            <p>
                <label>
                    Quantité désirée : 
                    <input type="text" name="qtt" value="1" class="input-group flex-nowrap">
                </label>
            </p>
            <p>
                <label>
                    Déscription : 
                    <textarea name="description" class="input-group flex-nowrap"></textarea>
                </label>
            </p>
            <p>
                <label>
                Image :
                <input type="file" name="file" class="input-group flex-nowrap">
                </label>
            </p>
            <p> 
                <input type="submit" name="submit" value="Ajouter le produit" class="btn btn-primary">
            </p>
        </form>
        <?php  
        
            // Affichage du message lors de l'ajout d'un produit
            if (isset($_SESSION['message'])) {
            echo "<p class='alert alert-success'>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
            } 
        ?>    
        
    </body>
</html>


