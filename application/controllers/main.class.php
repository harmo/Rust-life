<?php
class Main extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        global $config;
        $user = $this->session->get('user');
        $template = $this->loadView('main');
        $template->set('static', $this->staticFiles);
        $template->set('title', $config['project']);
        $template->render();
    }

}