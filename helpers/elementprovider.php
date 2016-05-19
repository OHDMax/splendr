<?php

require '../models/products_model.php';
require '../models/products_model.php';

class ElementProvider {

    public static function getMainElements($type) {

        if ($type === "products") {
            $data = Products_Model::provideProducts();
            return $data;
        } else if ($type === "boards") {
            $data = Boards_Model::provideBoards();
            return $data;
        }
    }

    public static function getLoginElement($isAuthenticated) {
        if (isset($isAuthenticated)) {
            return '<li role = "presentation"><a href="/users/<?php echo Session::getKey($userID) ?>">Profil</a></li>'
            .'<li role="presentation"><a href="users/logout" >Abmelden</a></li>';
        } else {
            return '<li role = "presentation"><a tabindex = "0" role = "button"
        data-toggle = "modal" data-target = "#signModal">Anmelden</a></li>'
         . '<li role="presentation"><a href="register.html" >Registrieren</a></li>';
        }
    }

}