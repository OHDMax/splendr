<?php

/*
 * This Class is responsible for Methods concerning Users
 * like Login, Logout, Edit User, Delete User, Register
 */

class Users_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUserMeta($UserID){
        $userdata['id'] = $UserID;
        $arr = $this->_db->select("SELECT name, email, role, city, realname FROM users WHERE id = :id", $userdata);
        return $arr[0];
    }
    
    public function checkUserCredentials($data) {
        //extract and sanatize input from $_POST
        $userdata['name'] = Sanatization::sanatizeFieldInput($data['i_username']);
        $pw = $data['i_pass'];
        //check if user exits in the database
        $arr = $this->_db->select("SELECT name, pwhash  FROM users WHERE name = :name LIMIT 1", $userdata);
        if (!sizeof($arr[0]['pwhash'])) {
            return FALSE;
        }
        //check if passwords match
        $correct_hash = $arr[0]['pwhash'];
        //return true or false
        return Password::validate($pw, $correct_hash);
    }

    public function authoriseUser($data) {
        //generate login token          \
        //push login token to database   | ->depracted
        //save login token in $_Session /
        //save userID in Session
        $userdata['name'] = Sanatization::sanatizeFieldInput($data['i_username']);
        $arr = $this->_db->select("SELECT id, name FROM users WHERE name = :name LIMIT 1", $userdata);
        Session::set('UserID', $arr[0]['id']);
        Session::set('UserRole', $arr[0]['role']);
    }

    public function registerUser($data) {
        //extract and sanatize input from $_POST
        $userdata['name'] = Sanatization::sanatizeFieldInput($data['i_username']);
        $userdata['email'] = Sanatization::sanatizeFieldInput($data['i_mail']);
        $testname['name'] = $userdata['name'];
        $testmail['email'] =  $userdata['email'];
        //check if user exits in the database
        $arr = $this->_db->select("SELECT email, name  FROM users WHERE name = :name LIMIT 1", $testname);       
        $brr = $this->_db->select("SELECT email, name  FROM users WHERE email= :email LIMIT 1", $testmail);
        //check if Username is used
        if (sizeof($brr[0]['email'])) {
            Message::set("Your Mail Adress is already registered", "warning");
            return FALSE;
        } else if (sizeof($arr[0]['name'])) {
            Message::set("This name is already in use. Please choose another.", "warning");
            return FALSE;
        }
        //check if provided passwords match
        if (!($data['i_pass'] === $data['i_pass_conf'])) {
            Message::set("The passwords you entered didn't match. Please try again.", "warning");
            return FALSE;
        }
        //hash password
        $userdata['pwhash'] = Password::hash($data['i_pass']);
        //put Username and password into the database
        $this->_db->insert('users', $userdata);
        return TRUE;
    }

    public function rememberUser($UserID) {
        //TODO: 
        //generate TOKEN
        $token = hash("md5", $UserID . Session::get('ID'));
        $userdata['id'] = $UserID;
        $userdata['tokenhash'] = hash("sha1", $token);
        //submit hashed(token) to the database
        $this->_db->update("users", $userdata, "id = :id");
        return $token;
    }

    public function editUser($UserID, $data){
        $userdata['realname'] = Sanatization::sanatizeFieldInput($data['i_name']);
        $userdata['city'] = Sanatization::sanatizeFieldInput($data['i_loc']);
        $userdata['id'] = $UserID;
        $this->_db->update("users", $userdata, "id = :id");    
    }
    
}
