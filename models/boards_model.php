<?php

class Boards_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getBoardMeta($BoardID) {
        $boarddata['id'] = $BoardID;
        $arr = $this->_db->select("SELECT id, name, picture, updated, ownerid, catid FROM boards WHERE id = :id LIMIT 1", $boarddata);
        $arr[0]['category'] = Category::getCategory($arr[0]['catid']);
        return $arr[0];
    }

    public function getBoardProducts($BoardID) {
        $boarddata['id'] = $BoardID;
        $arr = $this->_db->select("SELECT p.id, p.name, p.price, p.source,p.picture, p.ownerid"
                . ", p.catid, b.id as bid, b.name as bname, r.productid, r.boardid "
                . "FROM boards b, products p, ispartof r "
                . "WHERE b.id = :id "
                . "AND b.id = r.boardid "
                . "AND r.productid = p.id", $boarddata);
        return $arr;
    }

    /**
     * Gibt die letzten 20 Einträge im Archiv zurück.
     * @return array Liste aus Produkten mit id, timestamp, name, url, image und price
     */
    public function getAllBoards($CatID = 0) {
        if ($CatID == 0) {
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, updated'
                            . ' FROM boards ORDER BY id DESC LIMIT 20');
        } else {
            $boarddata['catid'] = $CatID;
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, updated'
                            . ' FROM boards WHERE catid = :catid  ORDER BY id DESC LIMIT 20', $boarddata);
        }
    }

    public function getOwnBoards($UserID, $CatID) {
        if ($UserID) {
            $boarddata['ownerid'] = $UserID;
        } else {
            $boarddata['ownerid'] = 0;
        }
        if ($CatID == 0) {
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, updated'
                            . ' FROM boards WHERE ownerid = :ownerid  ORDER BY id DESC LIMIT 20', $boarddata);
        } else {
            $boarddata['catid'] = $CatID;
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, updated '
                            . 'FROM boards WHERE ownerid = :ownerid AND catid = :catid ORDER BY id DESC LIMIT 20', $boarddata);
        }
    }

    public function addBoard($data) {
        $boarddata['name'] = Sanatization::sanatizeFieldInput($data['i_board']);
        $boarddata['ownerid'] = Session::get('UserID');
        $boarddata['picture'] = Sanatization::sanatizeFieldInput($data['i_bpicture']);
        $category = Sanatization::sanatizeFieldInput($data['i_boardcat']);
        //check for Kategory
        if (Category::checkCategory($category) === FALSE) {
            $id = Category::insertCategory($category);
        } else {
            $id = Category::checkCategory($category);
        }
        //set Kategorie ID for Board
        $boarddata['catid'] = $id;
        //insert new Board
        $this->_db->insert("boards", $boarddata);
    }

    public function editBoard($bid, $data) {
        $boarddata['id'] = $bid;
        $boarddata['name'] = Sanatization::sanatizeFieldInput($data['i_board']);
        $boarddata['picture'] = Sanatization::sanatizeFieldInput($data['i_bpicture']);
        $category = Sanatization::sanatizeFieldInput($data['i_boardcat']);
        //check for Kategory
        if (Category::checkCategory($category) === FALSE) {
            $id = Category::insertCategory($category);
        } else {
            $id = Category::checkCategory($category);
        }
        //set Kategorie ID for Board
        $boarddata['catid'] = $id;
        //insert new Board
        $this->_db->update("boards", $boarddata, "id = :id");
    }

    public function deleteBoard($bid, $oid) {
        $this->_db->psqldelete("boards", "id = $bid AND ownerid = $oid");
    }

    public function addRelation($bid, $pid) {
        $data['boardid'] = $bid;
        $data['productid'] = $pid;
        $arr = $this->_db->select("SELECT boardid, productid FROM ispartof WHERE boardid = :boardid AND productid = :productid", $data);
        if (!sizeof($arr[0]['boardid'])) {
            $this->_db->insert("ispartof", $data);
        }
    }

    public function removeRelation($bid, $pid) {
        $this->_db->psqldelete("ispartof", "boardid = $bid AND productid = $pid");
    }

}
