<?php
class Logout extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->session->delete('user');
        $this->redirect('');
    }

}