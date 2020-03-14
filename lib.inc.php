<?php
/*
        Librairie php 
        Auteur : Jorge Machado
        Date : 08.10.19
    */

//phpinfo();
require_once 'EDatabase.php';


function displayPosts($posts){
    //var_dump($posts);
    $html = "";
    foreach ($posts as $key => $post) {
        $html .= "<div> \n
            <div class=\"uk-card uk-card-default\"> \n
            <div class=\"uk-card-header\">\n
                            <div class=\"uk-grid-small uk-flex-middle\" uk-grid>\n
                                <div class=\"uk-width-auto\">\n
                                    <img class=\"uk-border-circle\" width=\"40\" height=\"40\" src=\"img/avatar.jpg\"> \n
                                </div>\n
                                <div class=\"uk-width-expand\">\n
                                    <h3 class=\"uk-card-title uk-margin-remove-bottom\">" . $post["titrePost"] . "</h3> \n
                                    <p class=\"uk-text-meta uk-margin-remove-top\"><time datetime=\"2016-04-01T19:00\">" . $post["dateCreationPost"] . "</time> </p>\n
                                </div>\n
                            </div>\n
                        </div>";
                        $medias = getMediaFromPostID($post["idPost"]);

                        if (!empty($medias)) {
                            $medias = getMediaFromPostID($post["idPost"]);

                                $html.= 
                                "<div class=\"uk-card-media-top\">
                                <div class=\"uk-position-relative uk-visible-toggle uk-light\" tabindex=\"-1\" uk-slideshow>
                                    <ul class=\"uk-slideshow-items\">";

                                    foreach ($medias as $key => $fichier) {
                                        if (mime_content_type('img/'. $fichier["nomFichierMedia"] )=='video/mp4') {
                                            $html .= "<li>
                                            <video controls autoplay>

                                            <source src=\"img/" . $fichier["nomFichierMedia"]  . "\"
                                                    type=\"video/webm\">
                                        </video>
                                           
                                        </li>";
                                        }
                                        
                                        else if(mime_content_type('img/'. $fichier["nomFichierMedia"] )=='audio/mpeg'){
                                            $html .=  "<audio controls=\"controls\" > ";
                                            $html .= "<source src=\"img/" . $fichier["nomFichierMedia"]  . "\" type=\"audio/mpeg\" /> ";
                                            $html .= "</audio>";
                                        }
                                        else{
                                            $html .= "<li>

                                            <img src=\"img/" . $fichier["nomFichierMedia"]  . "\" alt=\"\" uk-cover>
                                        </li>";
                                        }
                                        
                                    }
                                    

                                    $html .= "</ul><a class=\"uk-position-center-left uk-position-small uk-hidden-hover\" href=\"#\" uk-slidenav-previous uk-slideshow-item=\"previous\"></a>
                                    <a class=\"uk-position-center-right uk-position-small uk-hidden-hover\" href=\"#\" uk-slidenav-next uk-slideshow-item=\"next\"></a>
                                </div>
                                </div>";

                            // $html .=    "<div class=\"uk-card-media-top\">\n
                            //                 <img src=\"img/" . $post["nomFichierMedia"] . "\" width=\"100%\" height=\"100%\">\n
                            //             </div>\n";

                            


                        }
                                
                        $html .= "<div class=\"uk-card-body\">\n
                            <p>" . $post["descriptionPost"] . " <a  class=\"uk-align-right\" href=\"\" uk-icon=\"icon: pencil\"> </a> <a class=\"uk-align-right\" href=\"\" uk-icon=\"icon: trash\"> </a></p> \n
                        </div>\n
            </div>\n
        </div>\n";
    }

    echo $html;
}

function getPosts(){
    static $req;

    $sql = 'SELECT idPost, titrePost, descriptionPost, dateCreationPost, dateModificationPost FROM Post ORDER BY dateCreationPost DESC'; 
    if ($req == null) {
        try {
            $req = EDatabase::prepare($sql); //plus rapide qu'un query
            $req->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    return $req->fetchAll(PDO::FETCH_ASSOC);
}


function getMediaFromPostID($id){


    $sql = 'SELECT nomFichierMedia, dateCreationMedia, dateModificationMedia, typeMedia FROM Media WHERE idPost = :id'; 
    
        try {
            $req = EDatabase::prepare($sql); //plus rapide qu'un query
            $req->execute(
                array(
                    'id' => $id
                )
            );
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    
    return $req->fetchAll(PDO::FETCH_ASSOC);
}


function getPostsAndMedias()
{
    static $req;

    $sql = 'SELECT titrePost, descriptionPost, dateCreationPost, dateModificationPost, nomFichierMedia FROM Post INNER JOIN Media ON Post.idPost = Media.idPost ORDER BY dateCreationPost DESC'; 
    if ($req == null) {
        try {
            $req = EDatabase::prepare($sql); //plus rapide qu'un query
            $req->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    return $req->fetchAll(PDO::FETCH_ASSOC);
}




function addPost($titre, $description, $typeMedia, $nomFichier, $sizeFichier, $tmpNameFichier)
{

    try {
        EDatabase::beginTransaction();

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

        if (!empty($nomFichier)) {
            $id = EDatabase::lastInsertId();
    
            $sql = "INSERT INTO Media(typeMedia, nomFichierMedia, dateCreationMedia, dateModificationMedia, idPost) VALUES(:typeMedia, :nomFichier, :dateCrea, :dateModif, :post)";
    
            for ($i = 0; $i < count($nomFichier); $i++) {

                $tmp = changeFileNameIfExists($nomFichier[$i]);
                $req = EDatabase::prepare($sql);
                $req->execute(
                    array(
                        'typeMedia' => $typeMedia[$i],
                        'nomFichier' => $tmp,
                        'dateCrea' => date("Y-m-d H:i:s"),
                        'dateModif' => date("Y-m-d H:i:s"),
                        'post' => $id
                    )
                );

                addMediaToServer($tmp, $typeMedia[$i], $tmpNameFichier[$i], $sizeFichier[$i]);
    
            }
        }
        EDatabase::commit(); 
    } catch (\Throwable $th) {
        EDatabase::rollBack();
    }

}

function changeFileNameIfExists($fileName , $cpt = 0){

    if (file_exists("./img/" . $fileName)) {
        while(file_exists("./img/" . $cpt . $fileName)){
            $cpt++;
        }
    
        return $cpt . $fileName; 
    }
    else{
        return $fileName; 
    }
   
   
}




function addMediaToServer($nomFichier, $typeFichier, $tmpName, $sizeFichier, $cpt = 0)
{
    $typesAcceptes = array("image/gif", "image/png", "image/jpeg", "video/mp4", "audio/mpeg"); //PAS SECURISE, A SECURISER

    try {
        //if (in_array($typeFichier, $typesAcceptes)) { //TODO ajouter securité

                //$nomFichier = $cpt .= $nomFichier;
                if (!move_uploaded_file($tmpName, "./img/" .  changeFileNameIfExists($nomFichier))){
                    throw new Exception();    //si il retourne false, throw, si il throw deja il va dans le catch
            }
    
              
            
        //}
    } catch (\Throwable $th) {
        throw new Exception();
    }


}
