<?php
//Author(s): Beesham Sarendranauth, Vithusanan Mathiaparanam
include_once("../utils/DatabaseUtils.php");
include_once("../utils/HTTPUtils.php");
include_once("../utils/User.php");
include_once("../utils/User_Settings.php");

class UserManager {

    private static function getDb() {
        $db = new DatabaseUtils();
        $db->connectTodb();
        return $db;
    }

    static function login_user($username, $password) {
        $db = UserManager::getdb();
        $status = $db->checkLogin($username, $password); 
        return $status;
    }

    static function logout_user() {
        session_start();
        unset($_SESSION["logged_in"]);
        session_unset();
        HTTPUtils::redirectPage("/php/homepage.php");
    }

    static function getUser($username) {
        $db = UserManager::getdb();
        $user = $db->queryUsers($username);
        return $user;
    }
    
    static function checkIfUserExist($username) {
        $user = UserManager::getUser($username);
        $a = $user->username;
        if(strcmp($a, $username) == 0) {
            return true;
        } else return false;
    }

    static function addUser($firstname, $lastname, $email, $password) {
        $db = UserManager::getdb();
        $user = new User();
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->username = $email;
        return $db->insertNewUser($user, $password); //return true or false if insert succeeded
    }

    static function updateSettings($username, $user_settings) {
        $db = UserManager::getdb();
        return $db->updateUserSettings($username, $user_settings);
    }

    static function deleteUser($username) {
        $db = UserManager::getdb();
        return $db->deleteUser($username);
    }

    static function changeUserPassword($username, $password) {
        $db = UserManager::getdb();
        return $db->updatePassword($username, $password);
    }

    static function getUserSettings($username) {
        $db = UserManager::getdb();
        return $db->querySettings($username);
    }

    static function addToDoListItem($username, $item) {
        $db = UserManager::getdb();
        return $db->addToDoListItem($username, $item);
    }

    static function getToDoListItem($username) {
        $db = UserManager::getdb();
        return $db->queryTodo($username);
    }

    static function deleteItem($username, $item) {
        $db = UserManager::getdb();
        return $db->deleteToDoListItem($username, $item);
    }


}
?>
