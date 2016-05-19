<?php

class Boards extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Session::set('visited', "boards/");
        Authentication::isAuthenticated();
        $data['title'] = 'Boards - Übersicht';
        $data['categories'] = Category::getAllCategories();

        if (isset($_POST['i_user'])) {
            $user = Sanatization::sanatizeFieldInput($_POST['i_user']);
            $cid = Sanatization::sanatizeFieldInput($_POST['i_category']);
            if ($user === "me") {
                $data['set_me'] = 'selected';
                $data['set_catid'] = $cid;
                $data['boards'] = $this->_model->getOwnBoards(Session::get('UserID'), $cid);
            } else {
                $data['set_catid'] = $cid;
                $data['boards'] = $this->_model->getAllBoards($cid);
            }
        } else {
            $data['boards'] = $this->_model->getAllBoards();
        }

        $this->_view->render('header', $data);
//        $this->_view->render('debug', $data);
//        $this->_view->render('debug', $_POST);
        $this->_view->render('boards/list', $data);
        $this->_view->render('footer');
    }

    public function details($BoardID) {
        Authentication::isAuthenticated();
        $id = Sanatization::sanatizeNumbers($BoardID);
        Session::set('visited', "boards/");

        $board = $this->_model->getBoardMeta($id);
        //set Board Meta Data
        $data['title'] = "Boards - Details ";
        $data['board'] = $board;
        $data['products'] = $this->_model->getBoardProducts($id);
        //
        $this->_view->render('header', $data);
//        $this->_view->render('debug', $_POST);
        $this->_view->render('boards/details', $data);
        $this->_view->render('footer');
    }

    public function insert($BoardID = FALSE) {
        if ($BoardID === FALSE) {
            if (!Authentication::isAuthenticated()) {
                Message::set("You have to be logged in!", "danger");
                URL::redirect(Session::get('visited'), "303 See other");
            }
            $this->_model->addBoard($_POST);
        } else {
            $id = Sanatization::sanatizeNumbers($BoardID);
            if (!$this->checkUserRights($id)) {
                URL::redirect(Session::get('visited'), "303 See other");
            }
            $this->_model->editBoard($id, $_POST);
            Message::set("The board has been edited", "info");
        }
        URL::redirect(Session::get('visited'), "303 See other");
    }

    public function delete($BoardID) {
        if (!$this->checkUserRights($BoardID)) {
            URL::redirect(Session::get('visited'), "303 See other");
        }
        Session::set('visited', "boards/");
        $bid = Sanatization::sanatizeNumbers($BoardID);
        $this->_model->deleteBoard($bid, Session::get('UserID'));
        Message::set("The Board has been deleted.", "info");
        URL::redirect(Session::get('visited'), "303 See Other");
    }

    public function addproduct($ProductID, $BoardID = FALSE) {
        if ($BoardID === FALSE) {
            if (!Authentication::isAuthenticated()) {
                URL::redirect(Session::get('visited'), "303 See other");
            }
            $pid = Sanatization::sanatizeNumbers($ProductID);
            //render list with all boards and link to addproduct (set boardid!)
            $data['title'] = 'Zu Board hinzufügen:';
            $data['productid'] = $pid;
            $data['categories'] = Category::getAllCategories();

            if (isset($_POST['i_user'])) {
                $user = Sanatization::sanatizeFieldInput($_POST['i_user']);
                $cid = Sanatization::sanatizeFieldInput($_POST['i_category']);
                if ($user === "me") {
                    $data['set_me'] = 'selected';
                    $data['set_catid'] = $cid;
                    $data['boards'] = $this->_model->getOwnBoards(Session::get('UserID'), $cid);
                } else {
                    $data['set_catid'] = $cid;
                    $data['boards'] = $this->_model->getAllBoards($cid);
                }
            } else {
                $data['boards'] = $this->_model->getAllBoards();
            }
            
            $data['main_heading'] = 'Zu welchem Board soll das Produkt hinzugefügt werden?';
            $this->_view->render('header', $data);
//            $this->_view->render('debug', $data);
//            $this->_view->render('debug', $_POST);
            $this->_view->render('boards/addlist', $data);
            $this->_view->render('footer');
        } else {
            if (!$this->checkUserRights($BoardID)) {
                URL::redirect(Session::get('visited'), "303 See other");
            }
            $bid = Sanatization::sanatizeNumbers($BoardID);
            $pid = Sanatization::sanatizeNumbers($ProductID);
            $this->_model->addRelation($bid, $pid);
            URL::redirect(Session::get('visited'), "303 See other");
        }
    }

    public function removeproduct($BoardID, $ProductID) {
        if (!$this->checkUserRights($BoardID)) {
            URL::redirect(Session::get('visited'), "303 See other");
        }
        $bid = Sanatization::sanatizeNumbers($BoardID);
        $pid = Sanatization::sanatizeNumbers($ProductID);
        $this->_model->removeRelation($bid, $pid);
        Message::set("The Product has succesfully been removed from the board.", "info");
        URL::redirect(Session::get('visited'), "303 See Other");
    }

    private function checkUserRights($BoardID) {
        $id = Sanatization::sanatizeNumbers($BoardID);
        if (!Authentication::isAuthenticated()) {
            Message::set("You have to be logged in!", "danger");
            return FALSE;
        }
        $arr = $this->_model->getBoardMeta($id);
        if ($arr['ownerid'] !== Session::get('UserID')) {
            if (Session::get('UserRole') === "admin") {
                return TRUE;
            }
            return FALSE;
        }
        return TRUE;
    }

}
