<?php
class Main extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        global $config;
        $template = $this->loadView('front/main');
        $template->set('static', $this->staticFiles);
        $template->set('title', $config['project']);
        $user = $this->loadModel('user');
        $template->set('user', $user->get($this->session->get('user')));
        $template->render();
    }

}