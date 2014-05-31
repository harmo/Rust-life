<?php
class Clans extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_session = $this->session->get('user');
        if(!$user_session){
            $this->redirect('login');
        }

        $template = $this->loadView('front/clans');
        $template->set('user', $user_session);
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Clans');

        $clan = $this->loadModel('clan');
        $template->set('clans', $clan->getAll());

        $template->render();
    }

}