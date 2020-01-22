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
                <form>
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Ajouter un post ...</legend>

                        <div class="uk-margin">
                            <input class="uk-input" type="text" placeholder="Titre ...">
                        </div>

                        <div class="uk-margin">
                            <textarea class="uk-textarea" rows="5" placeholder="Description ..."></textarea>
                        </div>

                    </fieldset>
                </form>
                </div>

            </section>

        </header>
    </body>
</html>