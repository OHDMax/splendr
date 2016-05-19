<?php
$URI = $_SERVER['REQUEST_URI'];
$a = strpos($URI, "register");
$b = strpos($URI, "boards");
$c = strpos($URI, "profile");
($URI == "/~s0544210/Splendr2/" || $URI == "/~s0544210/Splendr2/welcome/") ? $d = TRUE : $d = FALSE;
$e = strpos($URI, "products");

if ($a !== FALSE) {
    $register = 'class = "active"';
    $brand = $profile = $products = $boards = " ";
} else if ($b !== FALSE) {
    $boards = 'class = "active"';
    $brand = $profile = $products = $register = " ";
} else if ($c !== FALSE) {
    $profile = 'class = "active"';
    $brand = $boards = $products = $register = " ";
} else if ($d !== FALSE) {
    $brand = 'active';
    $profile = $boards = $products = $register = " ";
} else if ($e !== FALSE) {
    $prodcuts = 'class = "active"';
} else {
    $brand = $profile = $products = $boards = $register = " ";
}
?>
<!doctype html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?= $data['title'] . ' - ' . SITETITLE ?></title>
        <link rel="stylesheet" href="<?= URL::STYLES('bootstrap.min') ?>">
        <link rel="stylesheet" href="<?= URL::STYLES('style') ?>">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class = "container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand <?= $brand ?>" href="<?= DIR ?>welcome/">Splendr</a>
                </div>
                <ul class ="nav navbar-nav">
                    <li role="presentation" <?= $boards ?>><a href="<?= DIR ?>boards/">Boards</a></li>
                    <li role="presentation" <?= $prodcuts ?>><a href="<?= DIR ?>products/">Produkte</a></li>
                    <li role="presentation">
                        <a tabindex="0" role="button" data-html='true'
                           data-toggle="popover" data-placement="bottom"
                           data-container="body" title="Neues Board anlegen" 
                           data-content='
                           <form method="post" action="<?= DIR ?>boards/insert">
                           <div class="form-group">
                           <label hidden for="i_board">Name:</label>
                           <input type="text" class="form-control" id="i_board" name="i_board" placeholder="Namen eingeben">
                           </div>
                           <div class="form-group">
                           <label hidden for="i_bpciture">Bild-Link:</label>
                           <input type="url" class="form-control" name="i_bpicture" placeholder="Link zum Bild" >
                           </div>
                           <div class="form-group">
                           <label hidden for="i_boardcat">Kategorie:</label>
                           <input type="text" class="form-control" id="i_boardcat" name="i_boardcat" placeholder="Kategorie eingeben">
                           </div>
                           <button type="submit" class="btn btn-primary">Anlegen</button>
                           </form>
                           '>
                            Board erstellen</a></li>
                    <li role="presentation">
                        <a tabindex="0" role="button" data-html='true'
                           data-toggle="popover" data-placement="bottom"
                           data-container="body" title="Neues Produkt anlegen" 
                           data-content='
                           <form method="post" action="<?= DIR ?>products/insert">
                           <div class="form-group">
                           <label hidden for="i_product">Name:</label>
                           <input type="text" class="form-control" id="i_name" name="i_name" placeholder="Bezeichnung eingeben">
                           </div>
                           <div class="form-group">
                           <label hidden for="i_price">Preis:</label> 
                           <div class="input-group">
                           <input type="number" step="any" min="0" class="form-control" id="i_price" name="i_price" placeholder="Preis eingeben" aria-describedby="addon€">
                           <span class="input-group-addon" id="addon€">€</span>
                           </div>
                           </div>
                           <div class="form-group">
                           <label hidden for="i_url">Link zum Produkt:</label>
                           <input type="text" class="form-control" id="i_url" name="i_url" placeholder="Link zum Produkt">
                           </div>
                           <div class="form-group">
                           <label hidden for="i_picture">Link zum Produkt:</label>
                           <input type="text" class="form-control" id="i_picture" name="i_picture" placeholder="Link zum Bild">
                           </div>
                           <div class="form-group">
                           <label hidden for="i_productcat">Kategorie:</label>
                           <input type="text" class="form-control" id="i_productcat" name="i_productcat" placeholder="Kategorie eingeben">
                           </div>
                           <button type="submit" class="btn btn-primary">Anlegen</button>
                           </form>
                           '>Produkt erstellen</a></li>
                </ul>
                <form class="navbar-form navbar-right" role="search" action="<?= DIR ?>search" method="get">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Suchen" id="term" name="term">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </span>
                        </div>
                    </div>
                </form>
                <ul class ="nav navbar-nav navbar-right">
                    <?php
                    if (Session::get('UserID')) {
                        echo'<li role = "presentation"' . $profile . '><a href="' . DIR . 'users/profile/' . Session::get('UserID') . '">Profil</a></li>'
                        . '<li role="presentation"><a href="' . DIR . 'users/logout" >Abmelden</a></li>';
                    } else {
                        echo '<li role = "presentation"><a tabindex = "0" role = "button"'
                        . 'data-toggle = "modal" data-target = "#signModal">Anmelden</a></li>'
                        . '<li role="presentation"' . $register . '><a href="' . DIR . 'welcome/register" >Registrieren</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>


        <!--Log-in Modal-->
        <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="signModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="signModalLabel">Einloggen</h4>
                    </div>
                    <form method="post" action="<?= DIR ?>users/login"> 
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="i_username">Nutzername:</label>
                                <input type="text" class="form-control" id="i_username" name="i_username">
                            </div>
                            <div class="form-group">
                                <label for="i_pass">Passwort:</label>
                                <input type="password" class="form-control" id="i_pass" name="i_pass">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="i_remember" name="i_remember" value="rem"> Angemeldet bleiben?
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary" >Anmelden</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  