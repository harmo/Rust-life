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

    function reset_password($action, $params=null){
        try {
            if($params == null){
                if(DEV){
                    throw new Exception('No parameters found');
                }
                $this->redirect('');
            }
            $params = explode('&', base64_decode(key($params)));
            $action = explode('=', $params[0]);
            if($action[0] != 'action' || $action[1] != 'reset-password'){
                if(DEV){
                    throw new Exception('Bad action');
                }
                $this->redirect('');
            }
            $params = explode('=', $params[1]);
            if($params[0] != 'id' || (int)$params[1] == 0){
                if(DEV){
                    throw new Exception('Bad parameter');
                }
                $this->redirect('');
            }

            $user = $this->loadModel('user');

            $template = $this->loadView('reset-password');
            $template->set('static', $this->staticFiles);
            $template->set('title', 'Nouveau mot de passe');

            if(isset($_POST['send_reset'])){
                $reset_password = $user->resetPassword($_POST, $params[1]);
                if(!$reset_password || isset($reset_password['in_error']) && $reset_password['in_error']){
                    $template->set('errors', $reset_password['errors']);
                }
                else {
                    $template->set('success', $reset_password['success']);
                }
            }

            $template->render();
        }
        catch(Exception $e){
            exit($e->getMessage());
        }
    }

}