<?php
class Clans extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login');
        }

        $template = $this->loadView('front/clans');
        $user = $this->loadModel('user');
        $template->set('user', $user->get($user_id));
        $template->set('static', $this->staticFiles);
        $template->addJs('alertify-0.3.11/js/alertify.min', 'vendor');
        $template->addCss('alertify-0.3.11/css/alertify.core', 'vendor');
        $template->addCss('alertify-0.3.11/css/alertify.default', 'vendor');
        $template->addJs('clans');
        $clan = $this->loadModel('clan');
        if(isset($this->params[0])){
            if($this->action == 'join'){
                if($user->clan == ''){
                    $loaded_clan = $clan->getObject($this->params[0]);
                    if(!$loaded_clan->addUser($user)){
                        $template->set('errors', 'Impossible de rejoindre ce clan');
                    }
                    else {
                        $this->redirect('clans');
                    }
                }
            }
            elseif($this->action == 'unjoin'){
                $loaded_clan = $clan->getObject($this->params[0]);
                if($user->clan != ''){
                    if(!$loaded_clan->removeUser($user)){
                        $template->set('errors', 'Impossible de rejoindre ce clan');
                    }
                    else {
                        $this->redirect('clans');
                    }
                }
            }
            elseif($this->action == 'cancel'){
                $loaded_clan = $clan->getObject($this->params[0]);
                if(!$loaded_clan->cancelInvitation($user)){
                    $template->set('errors', 'Impossible d\'annuler la demande');
                }
                else {
                    $this->redirect('clans');
                }
            }
        }
        elseif($this->action == 'require'){
            if($user->clan == ''){
                $loaded_clan = $clan->getObject($_POST['clan_id']);
                die(json_encode($loaded_clan->requireInvitation($user, $_POST['message'])));
            }
        }
        elseif($this->action == 'accept_require'){
            $require = $clan->getRequire($_POST['require_id']);
            $loaded_clan = $clan->getObject($require['clan']);
            if($user->id == $loaded_clan->owner['id']){
                $user_required = $user->get($require['user']);
                die(json_encode($loaded_clan->acceptRequire($require, $user_required)));
            }
        }
        elseif($this->action == 'change_owner'){
            $loaded_clan = $clan->getObject($_POST['clan']);
            if($user->id == $loaded_clan->owner['id']){
                $loaded_user = $user->get($_POST['user']);
                die(json_encode($loaded_clan->changeOwner($loaded_user)));
            }
        }

        $template->set('title', 'Clans');

        $template->set('clans', $clan->getAll());


        $template->render();
    }

}