<?php
class Join extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        global $config;
        $template = $this->loadView('join');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Nous rejoindre');
        $template->render();
    }

}