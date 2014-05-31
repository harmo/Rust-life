<?php
class Infos extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_session = $this->session->get('user');
        if(!$user_session){
            $this->redirect('login');
        }

        $template = $this->loadView('front/infos');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Informations');
        $template->set('user', $this->session->get('user'));
        $template->render();
    }

}