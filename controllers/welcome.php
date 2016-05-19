<?php

class Welcome extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Session::init();
        Authentication::isAuthenticated();
        Session::set("visited", "welcome/index");
    
        $data = array();
        $data['title'] = 'Startseite';
        $data['products'] = ElementProvider::getMainElements('products');
        $data['boards'] = ElementProvider::getMainElements('boards');
        
        $this->_view->render('header', $data);
        $this->_view->render('welcome/start_content', $data);
        $this->_view->render('footer');
    }

    public function register() {
        //this is the register view only! The input is parsed by users/register
        Session::init();
        Session::set("visited", "welcome/index");
        $data = array();
        $data['title'] = 'Registrieren';
        $this->_view->render('header', $data);
//        $this->_view->render('debug', $_POST);
        $this->_view->render('welcome/register', $data);
        $this->_view->render('footer');
    }

}
