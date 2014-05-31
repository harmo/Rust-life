<?php
class Main extends Controller {

    private $template;

    function __construct(){
        parent::__construct('admin');
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login', 'admin');
        }
        $user = $this->loadModel('user');
        $user_session = $user->get($user_id);
        if(!$user_session->is_admin){
            $this->redirect('');
        }

        $this->template = $this->loadView('admin/admin');
        $this->template->set('title', 'Administration');
        $this->template->set('static', $this->staticFiles);
        $this->template->render();
    }

}