<?php
class Infos extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $template = $this->loadView('infos');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Informations');
        $template->set('user', $this->session->get('user'));
        $template->render();
    }

}