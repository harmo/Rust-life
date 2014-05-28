<?php
class Error extends Controller {

    function index(){
        $this->error404();
    }

    function error404(){
        $template = $this->loadView('error404');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'ERREUR 404');
        $template->set('user', $this->session->get('user'));
        $template->render();
    }

}