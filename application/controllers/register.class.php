<?php
class Register extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_id = $this->session->get('user');
        if($user_id){
            $this->redirect('');
        }

        $template = $this->loadView('front/user/register');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Créer un compte');

        if(isset($_POST['send_register'])){
            $user = $this->loadModel('user');
            $create = $user->create($_POST, true);
            if(isset($create['in_error']) && $create['in_error']){
                $template->set('errors', $create['errors']);
            }
            elseif(isset($create['success'])){
                $template->set('success', $create['success']);
                $this->session->set('user', $create['success']['user']);
            }
        }

        $template->render();
    }

}