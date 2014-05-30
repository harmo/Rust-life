<?php
class Reset_password extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        try {
            if($this->action == null){
                if(DEV){
                    throw new Exception('No parameters found');
                }
                $this->redirect('');
            }

            $params = explode('&', base64_decode($this->action));
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