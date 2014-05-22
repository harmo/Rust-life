<?php
class Main extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user = $this->session->get('user');
        $template = $this->loadView('main');
        $template->set('static', $this->staticFiles);
        $template->render();
    }

}