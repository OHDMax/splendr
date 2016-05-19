<?php

/*
 * Description of search
 *
 * @author julianmccloud
 */

class Search extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Authentication::isAuthenticated();
        if (isset($_GET['term'])) {
            $term = Sanatization::sanatizeFieldInput($_GET['term']);
        } else {
            $term = Sanatization::sanatizeFieldInput($_POST['term']);
        }
        if (isset($_POST['i_user'])) {
            $user = Sanatization::sanatizeFieldInput($_POST['i_user']);
            $cid = Sanatization::sanatizeFieldInput($_POST['i_category']);
            $type = Sanatization::sanatizeFieldInput($_POST['i_type']);
            if ($type === "boards") {
                $data['set_boards'] = 'true';
                if ($user === "me") {
                    $data['set_me'] = 'true';
                    $data['set_catid'] = $cid;
                    $data['stuff'] = $this->_model->searchOwn($term, Session::get('UserID'));
                    unset($data['stuff']['products']);
                } else {
                    $data['set_catid'] = $cid;
                    $data['stuff'] = $this->_model->searchAll($term, $cid);
                    unset($data['stuff']['products']);
                }
            } else if ($type === "products") {
                $data['set_products'] = 'true';
                if ($user === "me") {
                    $data['set_me'] = 'selected';
                    $data['set_catid'] = $cid;
                    $data['stuff'] = $this->_model->searchOwn($term, Session::get('UserID'), $cid);
                    unset($data['stuff']['boards']);
                } else {
                    $data['set_catid'] = $cid;
                    $data['stuff'] = $this->_model->searchAll($term, $cid);
                    unset($data['stuff']['boards']);
                }
            } else {
                if ($user === "me") {
                    $data['set_me'] = 'true';
                    $data['set_catid'] = $cid;
                    $data['stuff'] = $this->_model->searchOwn($term, Session::get('UserID'), $cid);
                } else {
                    $data['set_catid'] = $cid;
                    $data['stuff'] = $this->_model->searchAll($term, $cid);
                }
            }
        } else {
            $data['stuff'] = $this->_model->searchAll($term);
        }
        $data['title'] = "Suche";
        $data['term'] = $term;
        $data['categories'] = Category::getAllCategories();
        $this->_view->render('header', $data);
//        $this->_view->render('debug', $data);
        $this->_view->render('search/list', $data);
        $this->_view->render('footer');
    }

}
