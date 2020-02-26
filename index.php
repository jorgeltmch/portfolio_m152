<?php
require './lib.inc.php';

$posts = getPosts();
//var_dump($posts);




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
            <!-- <div>
        <div class="uk-card uk-card-default">
        <div class="uk-card-header">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <img class="uk-border-circle" width="40" height="40" src="img/avatar.jpg">
                            </div>
                            <div class="uk-width-expand">
                                <h3 class="uk-card-title uk-margin-remove-bottom">Arouf partout</h3>
                                <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">April 01, 2016</time></p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-media-top">
                                <img src="img/cfpt.jpg" alt="" width="100%" height="100%">
                            </div>
                    <div class="uk-card-body">
                        <p>Meme au CFPT</p>
                    </div>
        </div>
    </div>
    <div>
        <div class="uk-card uk-card-default">
        <div class="uk-card-header">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <img class="uk-border-circle" width="40" height="40" src="img/avatar.jpg">
                            </div>
                            <div class="uk-width-expand">
                                <h3 class="uk-card-title uk-margin-remove-bottom">Arouf a Paris</h3>
                                <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">April 01, 2016</time></p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-media-top">
                                <img src="img/paris.jpg" alt="" width="100%" height="100%">
                            </div>
                    <div class="uk-card-body">
                        <p>Le plus beau des rebeux</p>
                    </div>
        </div>
    </div>
    <div>
        <div class="uk-card uk-card-default">
        <div class="uk-card-header">
                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <img class="uk-border-circle" width="40" height="40" src="img/avatar.jpg">
                            </div>
                            <div class="uk-width-expand">
                                <h3 class="uk-card-title uk-margin-remove-bottom">Mes freres :)</h3>
                                <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">April 01, 2016</time></p>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-media-top">
                                <img src="img/ademo.jpg" alt="" width="100%" height="100%">
                            </div>
                    <div class="uk-card-body">
                        <p>Mon frere Ademo Ademo et Ademo, NOS n'a pas pu être présent</p>
                    </div>
        </div>
    </div> -->
        </div>

    </section>
</body>

<footer>
    <center>
        CFPT Informaque - Jorge Machado
    </center>
</footer>

</html>