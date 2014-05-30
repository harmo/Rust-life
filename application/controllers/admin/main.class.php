<?php
class Main extends Controller {

    private $template;

    function __construct(){
        parent::__construct('admin');
    }

    function index(){
        $user_session = $this->session->get('user');
        if(!$user_session){
            $this->redirect('login', 'admin');
        }
        else if(!$user_session->is_admin){
            $this->redirect('');
        }

        $this->template = $this->loadView('admin/admin');
        $this->template->set('title', 'Administration');
        $this->template->set('static', $this->staticFiles);
        $this->template->render();
    }

}