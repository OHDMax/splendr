<?php

class Users extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        Session::init();
        if (isset($_POST['i_username'])) {
            $this->_model->checkUserCredentials($_POST) ? $successfull = 'TRUE' : $successfull = 'FALSE';
        } else {
            $successfull = 'FALSE';
        }

        if ($successfull === 'TRUE') {
            $this->_model->authoriseUser($_POST);
            var_dump($_POST);
            if ($_POST['i_remember'] == "rem") {
                $token = $this->_model->rememberUser(Session::get('UserID'));
                setcookie("RemembeR", $token, time() + 259200, "/", "studi.f4.htw-berlin.de", false, true);
            }
            //set success message 
            $msg = "You have been successfully logged in.";
            $type = "success";
        } else {
            //set error message
            $msg = "Oh no! Your inputs were not correct, please try again.";
            $type = "danger";
        }
        Message::set($msg, $type);
        URL::redirect(Session::get('visited'), "303 See Other");
    }

    public function logout() {
        Session::clear('UserID');
        if (isset($_COOKIE['RemembeR'])) {
            setcookie("RemembeR", '', time() - 259200, "/", "studi.f4.htw-berlin.de", false, true);
        }
        Message::set("You have been successfully logged out", "success");
        URL::redirect(Session::get("visited"), "303 See other");
    }

    public function register() {
        Session::init();
        $this->_model->registerUser($_POST) ? $successfull = 'TRUE' : $successfull = 'FALSE';
        if ($successfull === 'TRUE') {
            $this->_model->authoriseUser($_POST);
            //set success message
            Message::set("You have been successfully logged in.", "success");
            URL::redirect(Session::get('visited'), "303 See Other");
        } else {
            URL::redirect("welcome/register", "303 See Other");
//            $this->_view->render("header");
//            $this->_view->render("debug", $_POST);
//            $this->_view->render("footer");
        }
    }

    public function profile($UserID) {
        $id = Sanatization::sanatizeNumbers($UserID);
        $data = $this->_model->getUserMeta($id);
        $data['title'] = "Profil";
        $this->_view->render("header", $data);
        $this->_view->render("users/profile", $data);
        $this->_view->render("footer");
    }

    public function edit(){
        $id = Session::get('UserID');
        $this->_model->editUser($id, $_POST);
        Message::set("Your profile has been updated", "info");
        URL::redirect("users/profile/".Session::get('UserID'), "303 See Other");
    }
}
