<?php

class Search_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function searchAll($term, $catid = 0) {
        $data['name'] = "%$term%";

        if ($catid == 0) {
            $arr = $this->_db->select("SELECT name, id, picture FROM boards WHERE name LIKE :name", $data);
            $brr = $this->_db->select("SELECT name, id, picture, price, source FROM products WHERE name LIKE :name", $data);
        } else {
            $data['catid'] = $catid;
            $arr = $this->_db->select("SELECT name, id, picture, catid FROM boards WHERE catid = :catid AND name LIKE :name", $data);
            $brr = $this->_db->select("SELECT name, id, picture, price, source, catid FROM products WHERE catid = :catid AND name LIKE :name", $data);
        }

        $crr['boards'] = $arr;
        $crr['products'] = $brr;

//        var_dump($crr['boards']);
//        echo '<br>';
//        var_dump($crr['products']);
//        echo '<br>';
        
        return $crr;
    }

    public function searchOwn($term, $id, $catid = 0) {
        $data['name'] = "%$term%";
        if ($id) {
            $data['ownerid'] = $id;
        } else {
            $data['ownerid'] = 0;
        }

        if ($catid == 0) {
            $arr = $this->_db->select("SELECT name, id, picture, ownerid FROM boards WHERE ownerid = :ownerid AND name LIKE :name", $data);
            $brr = $this->_db->select("SELECT name, id, picture, price, ownerid, source FROM products WHERE ownerid = :ownerid AND name LIKE :name", $data);
        } else {
            $data['catid'] = $catid;
            $arr = $this->_db->select("SELECT name, id, picture, catid, ownerid FROM boards WHERE catid = :catid AND ownerid = :ownerid AND name LIKE :name", $data);
            $brr = $this->_db->select("SELECT name, id, picture, price, source, catid, ownerid FROM products WHERE catid = :catid AND ownerid = :ownerid AND name LIKE :name", $data);
        }

        $crr['boards'] = $arr;
        $crr['products'] = $brr;
        return $crr;
    }

}
