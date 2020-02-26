<?php
/*
        Librairie php 
        Auteur : Jorge Machado
        Date : 08.10.19
    */

//phpinfo();
require_once 'EDatabase.php';


function displayPosts($posts)
{

    $html = "";
    foreach ($posts as $key => $post) {
        $html .= "<div> \n
            <div class=\"uk-card uk-card-default\"> \n
            <div class=\"uk-card-header\">\n
                            <div class=\"uk-grid-small uk-flex-middle\" uk-grid>\n
                                <div class=\"uk-width-auto\">\n
                                    <img class=\"uk-border-circle\" width=\"40\" height=\"40\" src=\"img/avatar.jpg\">\n
                                </div>\n
                                <div class=\"uk-width-expand\">\n
                                    <h3 class=\"uk-card-title uk-margin-remove-bottom\">" . $post["titrePost"] . "</h3>\n
                                    <p class=\"uk-text-meta uk-margin-remove-top\"><time datetime=\"2016-04-01T19:00\">" . $post["dateCreationPost"] . "</time></p>\n
                                </div>\n
                            </div>\n
                        </div>
                        <div class=\"uk-card-media-top\">\n
                                    <img src=\"img/" . $post["nomFichierMedia"] . "\" width=\"100%\" height=\"100%\">\n
                                </div>\n

                                
                        <div class=\"uk-card-body\">\n
                            <p>" . $post["descriptionPost"] . "</p>\n
                        </div>\n
            </div>\n
        </div>\n";
    }

    echo $html;
}

function getPosts()
{
    static $req;

    $sql = 'SELECT titrePost, descriptionPost, dateCreationPost, dateModificationPost, nomFichierMedia FROM Post INNER JOIN Media ON Post.idPost = Media.idPost'; //AND rendu = 1
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
}


//TODO : REMETTRE BIEN LES FONCTIONS
function addMediaToServer($nomFichier, $typeFichier, $tmpName, $sizeFichier, $cpt = 0)
{
    $typesAcceptes = array("image/gif", "image/png", "image/jpeg", "video/mp4", "audio/mpeg"); //PAS SECURISE, A SECURISER



    if (in_array($typeFichier, $typesAcceptes)) {
        if (file_exists("./img/" . $nomFichier)) {

            $cpt++;
            $temp = explode(".", $nomFichier);

            addMediaToServer($cpt . $nomFichier, $typeFichier, $tmpName, $sizeFichier, $cpt);
        } else {

            move_uploaded_file($tmpName, "./img/" . $nomFichier);
        }
    }
}
