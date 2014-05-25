<?php
class Session {

    function set($key, $val){
        $_SESSION[$key] = serialize($val);
    }

    function get($key){
        if(isset($_SESSION[$key])){
            return unserialize($_SESSION[$key]);
        }
        return false;
    }

    function delete($key){
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }

}