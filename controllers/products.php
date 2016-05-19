<?php

class Products extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Authentication::isAuthenticated();
        Session::set('visited', "products/");
        $data['title'] = 'Produkte - Übersicht';
        $data['categories'] = Category::getAllCategories();

        if (isset($_POST['i_user'])) {
            $user = Sanatization::sanatizeFieldInput($_POST['i_user']);
            $cid = Sanatization::sanatizeFieldInput($_POST['i_category']);
            if ($user === "me") {
                $data['set_me'] = 'selected';
                $data['set_catid'] = $cid;
                $data['products'] = $this->_model->getOwnProducts(Session::get('UserID'), $cid);
            } else {
                $data['set_catid'] = $cid;
                $data['products'] = $this->_model->getAllProducts($cid);
            }
        } else {
            $data['products'] = $this->_model->getAllProducts();
        }

        $this->_view->render('header', $data);
        $this->_view->render('products/list', $data);
        $this->_view->render('footer');
    }

    public function edit($ProductID) {
        if (!$this->checkUserRights($ProductID)) {
            URL::redirect(Session::get('visited'), "303 See other");
        }
        $id = Sanatization::sanatizeNumbers($ProductID);
        $data['title'] = 'Produkt bearbeiten';
        $data['form_header'] = 'Produkt bearbeiten';
        $data['product'] = $this->_model->getProductMeta($id);

        $this->_view->render('header', $data);
        $this->_view->render('products/form', $data);
        $this->_view->render('footer');
    }

    public function insert($ProductID = FALSE) {
        if ($ProductID === FALSE) {
            if (!Authentication::isAuthenticated()) {
                Message::set("You have to be logged in!", "danger");
                URL::redirect(Session::get('visited'), "303 See other");
            }
            $this->_model->addProduct($_POST);
        } else {
            $id = Sanatization::sanatizeNumbers($ProductID);
            if (!$this->checkUserRights($id)) {
                URL::redirect(Session::get('visited'), "303 See other");
            }
            $this->_model->editProduct($id, $_POST);
            Message::set("The product has been edited", "info");
        }
        URL::redirect(Session::get('visited'), "303 See other");
    }

    public function delete($ProductID) {
        if (!$this->checkUserRights($ProductID)) {
            URL::redirect(Session::get('visited'), "303 See other");
        }
        Session::set('visited', "products/");
        $pid = Sanatization::sanatizeNumbers($ProductID);
        $this->_model->removeProduct($pid, Session::get('UserID'));
        Message::set("The Product has been deleted. (It was also removed from all containing Boards)", "info");
        URL::redirect(Session::get('visited'), "303 See Other");
    }
    
    public function addtoboard($BoardID){
        if (!Authentication::isAuthenticated()) {
            URL::redirect(Session::get('visited'), "303 See other");
        }
        $bid = Sanatization::sanatizeNumbers($BoardID);
        Session::set('visited', "products/addtoboard/$bid");
        //render List with all products and link to addproduct (set boardid!)
        $data['title'] = 'Produkte zu Board hinzufügen';
        $data['boardid'] = $bid;
        $data['categories'] = Category::getAllCategories();

        if (isset($_POST['i_user'])) {
            $user = Sanatization::sanatizeFieldInput($_POST['i_user']);
            $cid = Sanatization::sanatizeFieldInput($_POST['i_category']);
            if ($user === "me") {
                $data['set_me'] = 'selected';
                $data['set_catid'] = $cid;
                $data['products'] = $this->_model->getOwnProducts(Session::get('UserID'), $cid);
            } else {
                $data['set_catid'] = $cid;
                $data['products'] = $this->_model->getAllProducts($cid);
            }
        } else {
            $data['products'] = $this->_model->getAllProducts();
        }
        $data['main_heading'] = 'Welches Produkt soll hinzugefügt werden?';
        $this->_view->render('header', $data);
        $this->_view->render('products/addlist', $data);
        $this->_view->render('footer');
    }

    private function checkUserRights($ProductID) {
        $id = Sanatization::sanatizeNumbers($ProductID);
        if (!Authentication::isAuthenticated()) {
            Message::set("You have to be logged in!", "danger");
            return FALSE;
        }
        $arr = $this->_model->getProductMeta($id);
        if ($arr['ownerid'] !== Session::get('UserID')) {
            if (Session::get('UserRole') === "admin") {
                return TRUE;
            }
            Message::set("You can't edit what isn't yours >:(", "danger");
            return FALSE;
        }
        return TRUE;
    }

}
