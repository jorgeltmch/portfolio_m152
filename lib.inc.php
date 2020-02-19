<?php
    /*
        Librairie php 
        Auteur : Jorge Machado
        Date : 08.10.19
    */

    require_once 'EDatabase.php';




    function addPost($titre, $description, $typeMedia, $nomFichier, $sizeFichier, $tmpNameFichier){
        $sql = "INSERT INTO Post(titrePost, descriptionPost, dateCreationPost, dateModificationPost) VALUES(:titrePost, :descriptionArticle, :dateCrea, :dateModif)";
        $req = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
        $req->execute(
          array(
             'titrePost' => $titre,
             'descriptionArticle' => $description,
             'dateCrea' => date("Y-m-d H:i:s"),
             'dateModif' => date("Y-m-d H:i:s")
             )
         );
        $id = EDatabase::lastInsertId();


        $sql = "INSERT INTO Media(typeMedia, nomFichierMedia, dateCreationMedia, dateModificationMedia, idPost) VALUES(:typeMedia, :nomFichier, :dateCrea, :dateModif, :post)";
        $req = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
        $req->execute(
          array(
             'typeMedia' => $typeMedia,
             'nomFichier' => $nomFichier,
             'dateCrea' => date("Y-m-d H:i:s"),
             'dateModif' => date("Y-m-d H:i:s"),
             'post' => $id
             )
         );  
         
         addMediaToServer($typeMedia, $tmpNameFichier, $sizeFichier);
    }


    //TODO : REMETTRE BIEN LES FONCTIONS
    function addMediaToServer($typeFichier, $tmpName, $sizeFichier){
        $typesAcceptes = array("image/gif", "image/png", "image/jpeg", "video/mp4", "audio/mpeg"); //PAS SECURISE, A SECURISER


        if (in_array($typeFichier, $typesAcceptes)) {
            move_uploaded_file($tmpName, "/img");
        }


    }

?>
    