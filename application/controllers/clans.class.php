<?php
class Clans extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id && !isset($this->params[0])){
            $this->redirect('login');
        }

        $template = $this->loadView('front/clan/list');
        $template->set('static', $this->staticFiles);
        $user = $this->loadModel('user');
        $user_object = $user->getObject($user_id);
        $clan = $this->loadModel('clan');
        $grade = $this->loadModel('grade');
        $permission = $this->loadModel('permission');

        if(isset($this->params[0])){
            // URL calls
            switch ($this->action) {
                case 'join':
                    if($user_object->clan == ''){
                        $loaded_clan = $clan->getObject($this->params[0]);
                        if(!$loaded_clan->addUser($user_object)){
                            $template->set('errors', 'Impossible de rejoindre ce clan');
                        }
                        else {
                            $this->redirect('clans');
                        }
                    }
                    break;

                case 'unjoin':
                    $loaded_clan = $clan->getObject($this->params[0]);
                    if($user_object->clan != ''){
                        if(!$loaded_clan->removeUser($user_object)){
                            $template->set('errors', 'Impossible de rejoindre ce clan');
                        }
                        else {
                            $this->redirect('clans');
                        }
                    }
                    break;

                case 'cancel':
                    $loaded_clan = $clan->getObject($this->params[0]);
                    if(!$loaded_clan->cancelInvitation($user_object)){
                        $template->set('errors', 'Impossible d\'annuler la demande');
                    }
                    else {
                        $this->redirect('clans');
                    }
                    break;

                case 'remove':
                    $loaded_clan = $clan->getObject($this->params[0]);
                    if($loaded_clan->owner['id'] != $user_object->id){
                        $this->redirect('clans');
                    }

                    $remove = $loaded_clan->remove();
                    if($remove['in_error']){
                        $template->set('errors', $remove['errors']);
                    }
                    else {
                        $this->redirect('clans');
                    }
                    break;

                case 'add':
                    if($user_object->clan != ''){
                        $this->redirect('clans');
                    }

                    $template = $this->loadView('front/clan/add');
                    $template->set('static', $this->staticFiles);
                    $template->addCss('select2-3.4.1/select2', 'vendor');
                    $template->addJs('select2-3.4.1/select2.min', 'vendor');
                    $template->set('users', $user_object->getAllWithoutClan(true));

                    if(isset($_POST['add_clan'])){
                        $_POST['members'] = isset($_POST['members']) ? $_POST['members'] : array();
                        array_push($_POST['members'], $_POST['owner']);
                        $create = $clan->create($_POST);
                        if($create['in_error']){
                            $template->set('errors', $create['errors']);
                        }
                        else {
                            $template->set('success', $create['success']);
                        }
                    }
                    break;

                case 'edit':
                    $loaded_clan = $clan->getObject($this->params[0]);
                    if($loaded_clan->owner['id'] != $user_object->id){
                        $this->redirect('clans');
                    }

                    $template = $this->loadView('front/clan/edit');
                    $template->set('static', $this->staticFiles);
                    $template->addCss('select2-3.4.1/select2', 'vendor');
                    $template->addJs('select2-3.4.1/select2.min', 'vendor');
                    $template->set('users', $user_object->getAll(true, 0));
                    $template->set('clan', $loaded_clan);
                    $template->set('permissions', $permission->getAllForClanOwner());

                    if(isset($_POST['submit_edit_grade'])){
                        $_POST['type'] = 2;
                        $update = $grade->updateData($_POST);
                        if($update['in_error']){
                            $template->set('errors', $update['errors']);
                        }
                        else {
                            $template->set('success', true);
                        }
                    }
                    break;
            }
        }
        else {
            // AJAX calls
            switch ($this->action) {
                case 'require':
                    if($user->clan == ''){
                        $loaded_clan = $clan->getObject($_POST['clan_id']);
                        die(json_encode($loaded_clan->requireInvitation($user, $_POST['message'])));
                    }
                    break;

                case 'accept_require':
                    $require = $clan->getRequire($_POST['require_id']);
                    $loaded_clan = $clan->getObject($require['clan']);
                    if($user->id == $loaded_clan->owner['id']){
                        $user_required = $user->getObject($require['user']);
                        die(json_encode($loaded_clan->acceptRequire($require, $user_required)));
                    }
                    break;

                case 'refuse_require':
                    $require = $clan->getRequire($_POST['require_id']);
                    $loaded_clan = $clan->getObject($require['clan']);
                    if($user->id == $loaded_clan->owner['id']){
                        $user_required = $user->getObject($require['user']);
                        die(json_encode($loaded_clan->refuseRequire($require, $user_required)));
                    }
                    break;

                case 'change_owner':
                    $loaded_clan = $clan->getObject($_POST['clan']);
                    if($user->id == $loaded_clan->owner['id']){
                        $loaded_user = $user->get($_POST['user']);
                        die(json_encode($loaded_clan->changeOwner($loaded_user)));
                    }
                    break;

                case 'add_grade':
                    $loaded_clan = $clan->getObject($_POST['clan_id']);
                    if($user->id == $loaded_clan->owner['id']){
                        die(json_encode($loaded_clan->addGrade($_POST)));
                    }
                    break;

                case 'delete_grade':
                    $loaded_clan = $clan->getObject($_POST['clan_id']);
                    if($user->id == $loaded_clan->owner['id']){
                        die(json_encode($loaded_clan->removeGrade($_POST)));
                    }
                    break;
            }
        }

        $template->addJs('alertify-0.3.11/js/alertify.min', 'vendor');
        $template->addCss('alertify-0.3.11/css/alertify.core', 'vendor');
        $template->addCss('alertify-0.3.11/css/alertify.default', 'vendor');
        $template->addJs('clans');
        $template->set('title', 'Clans');
        $template->set('clan_modes', $clan->available_modes);
        $template->set('clans', $clan->getAll());
        $template->set('user', $user->get($user_id));


        $template->render();
    }

}