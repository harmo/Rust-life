<?php
class Session {

    function set($key, $val){
        $_SESSION["$key"] = $val;
    }

    function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return false;
    }

    function destroy(){
        session_destroy();
    }

}