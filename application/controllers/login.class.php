<?php
class Login extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index($action=false, $params=false){
        $user_id = $this->session->get('user');
        if($user_id){
            $this->redirect('');
        }

        $from = isset($_GET['from']) ? $_GET['from'] : false;
        $template = $this->loadView('front/user/login');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Connexion');
        $template->set('action', $action);
        $template->set('params', $params);

        $user = $this->loadModel('user');
        $template->set('user', $user->get($user_id));
        if(isset($_POST['submit_login'])){
            $login = $user->login($_POST);
            if(isset($login['in_error']) && $login['in_error']){
                $template->set('errors', $login['errors']);
            }
            elseif(isset($login['success'])){
                $this->session->set('user', $login['success']['user_id']);
                $template->set('user', $user->get($login['success']['user_id']));
                if($from){
                    $this->redirect($from);
                }
            }
        }
        elseif(isset($_POST['send_login_lost'])){
            $login_lost = $user->loginLost($_POST['email']);
            if(!$login_lost || isset($login_lost['in_error']) && $login_lost['in_error']){
                $template->set('errors', $login_lost['errors']);
            }
            else {
                $template->set('success', $login_lost['success']);
            }
        }
        elseif(isset($_POST['send_password_lost'])){
            $password_lost = $user->passwordLost($_POST['login']);
            if(!$password_lost || isset($password_lost['in_error']) && $password_lost['in_error']){
                $template->set('errors', $password_lost['errors']);
            }
            else {
                $template->set('success', $password_lost['success']);
            }
        }

        $template->render();
    }

}