<?php
class Error extends Controller {

    function index(){
        $this->error404();
    }

    function error404(){
        echo '<h1>404 Error</h1>';
        echo '<p>Cette page n\'existe pas.</p>';
    }

}