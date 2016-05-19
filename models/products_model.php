<?php

class Products_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getProductMeta($ProductID) {
        $productdata['id'] = $ProductID;
        $arr = $this->_db->select("SELECT id, ownerid, catid, name, picture, price, source"
                . " FROM products WHERE id = :id LIMIT 1", $productdata);
        $arr[0]['category'] = Category::getCategory($arr[0]['catid']);
        return $arr[0];
    }

    /**
     * Gibt die letzten 20 Einträge im Archiv zurück.
     * @return array Liste aus Produkten mit id, timestamp, name, url, image und price
     */
    public function getAllProducts($CatID = 0) {
        if ($CatID == 0) {
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, price, source'
                            . ' FROM products ORDER BY id DESC LIMIT 20');
        } else {
            $productdata['catid'] = $CatID;
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, price, source'
                            . ' FROM products WHERE catid = :catid  ORDER BY id DESC LIMIT 20', $productdata);
        }
    }

    public function getOwnProducts($UserID, $CatID) {
        if ($UserID) {
            $productdata['ownerid'] = $UserID;
        } else {
            $productdata['ownerid'] = 0;
        }
        if ($CatID == 0) {
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, price, source'
                            . ' FROM products WHERE ownerid = :ownerid  ORDER BY id DESC LIMIT 20', $productdata);
        } else {
            $productdata['catid'] = $CatID;
            return $this->_db->select('SELECT id, ownerid, catid, name, picture, price, source'
                            . 'FROM products WHERE ownerid = :ownerid AND catid = :catid ORDER BY id DESC LIMIT 20', $productdata);
        }
    }

    public function addProduct($data) {
        $productdata['name'] = Sanatization::sanatizeFieldInput($data['i_name']);
        $productdata['source'] = Sanatization::sanatizeFieldInput($data['i_url']);
        $productdata['price']  = $this->tofloat(Sanatization::sanatizeFieldInput($data['i_price']));
        $productdata['picture']  = Sanatization::sanatizeFieldInput($data['i_picture']);
        $productdata['ownerid'] = Session::get('UserID');
        $category = Sanatization::sanatizeFieldInput($data['i_productcat']);
        //check for Kategory
        if (Category::checkCategory($category) === FALSE) {
            $id = Category::insertCategory($category);
        } else {
            $id = Category::checkCategory($category);
        }
        //set Kategorie ID for Product
        $productdata['catid'] = $id;
        //insert new Product
        $this->_db->insert("products", $productdata);
    }

    public function editProduct($pid, $data) {
        $productdata['id'] = $pid;
        $productdata['name'] = Sanatization::sanatizeFieldInput($data['i_name']);
        $productdata['source'] = Sanatization::sanatizeFieldInput($data['i_url']);
        $productdata['price']  = $this->tofloat(Sanatization::sanatizeFieldInput($data['i_price']));
        $productdata['picture']  = Sanatization::sanatizeFieldInput($data['i_picture']);
        $category = Sanatization::sanatizeFieldInput($data['i_productcat']);
        //check for Kategory
        if (Category::checkCategory($category) === FALSE) {
            $id = Category::insertCategory($category);
        } else {
            $id = Category::checkCategory($category);
        }
        //set Kategorie ID for Product
        $productdata['catid'] = $id;
        //insert new Product
        $this->_db->update("products", $productdata, "id = :id");
    }

    public function removeProduct($pid, $oid){
        $this->_db->psqldelete("products", "id = $pid AND ownerid = $oid");
    }
        
    private static function tofloat($num) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
  
    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
}

}
