<?php
    /*
        Librairie php 
        Auteur : Jorge Machado
        Date : 08.10.19
    */

    require_once 'EDatabase.php';


    function getPost(){
        
    }



    function addPost($titre, $description, $typeMedia, $nomFichier, $sizeFichier, $tmpNameFichier){
        $sql = "INSERT INTO Post(titrePost, descriptionPost, dateCreationPost, dateModificationPost) VALUES(:titrePost, :descriptionArticle, :dateCrea, :dateModif)";
        $req = EDatabase::prepare($sql);
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

        for ($i=0; $i < count($nomFichier); $i++) { 
            $req = EDatabase::prepare($sql);
            $req->execute(
              array(
                 'typeMedia' => $typeMedia[$i],
                 'nomFichier' => $nomFichier[$i],
                 'dateCrea' => date("Y-m-d H:i:s"),
                 'dateModif' => date("Y-m-d H:i:s"),
                 'post' => $id
                 )
             );  
             
             addMediaToServer($nomFichier[$i], $typeMedia[$i], $tmpNameFichier[$i], $sizeFichier[$i]);
        }
        
    }


    //TODO : REMETTRE BIEN LES FONCTIONS
    function addMediaToServer($nomFichier, $typeFichier, $tmpName, $sizeFichier, $cpt = 0){
        $typesAcceptes = array("image/gif", "image/png", "image/jpeg", "video/mp4", "audio/mpeg"); //PAS SECURISE, A SECURISER



            if (in_array($typeFichier, $typesAcceptes)) {
                if (file_exists("./img/" . $nomFichier)) {

                    $cpt++;
                    $temp = explode(".", $nomFichier);
                    
                    addMediaToServer( $cpt . $nomFichier  , $typeFichier, $tmpName, $sizeFichier, $cpt);
                }
                else{
                    
                    move_uploaded_file($tmpName, "./img/" . $nomFichier);
                }    
            }



    }

?>
    