<?php
class Clans extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login');
        }

        $template = $this->loadView('front/clans');
        $user = $this->loadModel('user');
        $template->set('user', $user->get($user_id));
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Clans');

        $clan = $this->loadModel('clan');
        $template->set('clans', $clan->getAll());


        $template->render();
    }

}