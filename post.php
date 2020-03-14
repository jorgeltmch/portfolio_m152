<?php
    require './lib.inc.php';

    $titre = (empty($_POST["titre"])) ? "" : filter_input(INPUT_POST, "titre", FILTER_SANITIZE_STRING);
    $description = (empty($_POST["description"])) ? "" : filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
    $nomFichier = (empty($_FILES['img']['name'])) ? "" : $_FILES['img']['name'];
    $typeFichier = (empty($_FILES['img']['type'])) ? "" : $_FILES['img']['type'];


    $sizeFichier = (empty($_FILES['img']['size'])) ? "" : $_FILES['img']['size'];
    $tmpNameFichier = (empty($_FILES['img']['tmp_name'])) ? "" : $_FILES['img']['tmp_name'];
    
    $errFichier = (empty($_FILES['img']['error'])) ? "" : $_FILES['img']['error'][0] ;


    //POUR PLUS TARD
    // $_FILES['img']['size'];
    // $_FILES['img']['tmp_name'];
    // $_FILES['img']['error'];
    //var_dump($errFichier );
    if ($errFichier == 0) {
        if (!empty($titre) && !empty($description) && !empty($nomFichier) && !empty($typeFichier) && !empty($sizeFichier) && !empty($tmpNameFichier) ) {
            addPost($titre, $description, $typeFichier, $nomFichier,  $sizeFichier, $tmpNameFichier);
        }
    }

    
    //addPost($titre, $description, $typeMedia, $nomFichier)
?>

<!DOCTYPE html>
<html>
    <head>
        <title>AroufBook</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/uikit.css" />
        <link rel="stylesheet" href="css/newcss.css" />
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
    </head>
    <body>
        <header>

                <?php include 'navbar.php'?>

                <section class="uk-margin-large-left uk-margin-large-right">
                <div class="uk-card uk-card-default uk-padding-large uk-width-1@m">
                <form action="#" enctype="multipart/form-data" method="post">
                    <fieldset class="uk-fieldset">

                        

                        <legend class="uk-legend"><img class="uk-border-circle  uk-align-right" width="40" height="40" src="img/avatar.jpg">Nouveau post</legend>
                        
                        

                        <div class="uk-margin">
                            <input class="uk-input" name="titre" type="text" placeholder="Titre ...">
                            
                        </div>

                        

                        <div class="uk-margin">
                            <textarea class="uk-textarea" name="description" rows="5" placeholder="Description ..."></textarea>
                        </div>
                        <div class="js-upload uk-placeholder uk-text-center">
                            <span uk-icon="icon: cloud-upload"></span>
                            <span class="uk-text-middle">Déposez une image ou ajoutez la </span>
                            <div uk-form-custom>
                                <input type="file" name="img[]" multiple accept="audio/*, video/mp4,video/x-m4v,video/*,image/x-png,image/gif,image/jpeg" >
                                <span class="uk-link">en cliquant ici</span>
                            </div>
                        </div>
                        <button class="uk-button uk-button-primary uk-align-right" type="submit">Publier</button>
                    </fieldset>

                    
                </form>
                </div>

            </section>

        </header>
    </body>
</html>