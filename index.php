<?php
require './lib.inc.php';

$posts = getPosts();
//var_dump($posts);

$idToDelete = (!empty($_GET["delete"])) ? $_GET["delete"] : "" ;
$idToUpdate = (!empty($_GET["update"])) ? $_GET["update"] : "" ;


if (!empty($idToDelete)) {
    removePost($idToDelete);
}

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
        <?php include 'navbar.php' ?>
    </header>

    <section class="uk-margin-large-left uk-margin-large-right">
        <div class="uk-child-width-1-4@m" uk-grid>

            <?php
            displayPosts($posts);
            ?>

        </div>

    </section>
</body>

<footer>
    <center>
        CFPT Informaque - Jorge Machado
    </center>
</footer>

</html>