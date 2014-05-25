<?php
class Login extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index($action, $params){
        $from = isset($params['from']) ? $params['from'] : false;
        $template = $this->loadView('login');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Connexion');
        $template->set('user', $this->session->get('user'));

        $user = $this->loadModel('user');
        if(isset($_POST['submit_login'])){
            $login = $user->login($_POST);
            if(isset($login['in_error']) && $login['in_error']){
                $template->set('errors', $login['errors']);
            }
            elseif(isset($login['success'])){
                $this->session->set('user', $login['success']['user']);
                $template->set('user', $login['success']['user']);
                if($from){
                    $this->redirect($from);
                }
            }
        }

        $template->render();
    }

}