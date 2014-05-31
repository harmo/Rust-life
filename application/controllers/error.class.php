<?php
class Error extends Controller {

    function index(){
        $this->error404();
    }

    function error404(){
        $template = $this->loadView('error404');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'ERREUR 404');
        $user_id = $this->session->get('user');
        $user = $this->loadModel('user');
        $template->set('user', $user->get($user_id));
        $template->render();
    }

}