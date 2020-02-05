<?php
    /*
        Librairie php 
        Auteur : Jorge Machado
        Date : 08.10.19
    */

    function DB(){
        static $db = null;

        if ($db == null) {
            try {
                $db = new PDO('mysql:host=localhost;dbname=m152', "jorge", "Super");
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        return $db;
    }       

    

    function addPost($titre, $description, $typeMedia, $nomFichier){
        $sql = "INSERT INTO Post(titrePost, descriptionPost, dateCreationPost, dateModificationPost) VALUES(:titre, :descr, :dateCrea, :dateModif)";
        $req = DB()->prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
        $req->execute(
          array(
             'titrePost' => $titre,
             'descriptionArticle' => $description,
             'dateCrea' => date("Y-m-d H:i:s"),
             'dateModif' => date("Y-m-d H:i:s")
             )
         );
        $id = DB()->lastInsertId();


        $sql = "INSERT INTO Media(typeMedia, nomFichierMedia, dateCreationMedia, dateModificationMedia, idPost) VALUES(:typeMedia, :nomFichier, :dateCrea, :dateModif, :post)";
        $req = DB()->prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_SCROLL));
        $req->execute(
          array(
             'typeMedia' => $typeMedia,
             'nomFichier' => $nomFichier,
             'dateCrea' => date("Y-m-d H:i:s"),
             'dateModif' => date("Y-m-d H:i:s"),
             'post' => $id
             )
         );   
    }

?>
    