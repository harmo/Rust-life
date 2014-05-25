<?php
class Admin extends Controller {

    private $template;

    function __construct(){
        parent::__construct('admin');
    }

    function index($action=array(), $params=array()){
        $user_session = $this->session->get('user');
        if(!$user_session){
            $this->redirect('login', 'admin');
        }
        if(!$user_session->is_admin){
            $this->redirect('');
        }

        $func = key($action);
        $action = array_shift($action);

        switch ($func){
            case 'users':
                $user = $this->loadModel('user');
                switch ($action) {
                    case 'list':
                        $this->template = $this->loadView('users-list');
                        $this->template->set('title', 'Liste des membres');
                        $this->template->set('users', $user->getAll());
                        break;

                    case 'add':
                        $this->template = $this->loadView('user-add');
                        $this->template->set('title', 'Ajouter un membre');
                        if(isset($_POST['add_user'])){
                            $create = $user->create($_POST);
                            if(isset($create['in_error']) && $create['in_error']){
                                $this->template->set('errors', $create['errors']);
                            }
                            elseif(isset($create['success'])){
                                $this->template->set('success', $create['success']);
                            }
                        }
                        break;

                    case 'update':
                        $this->template = $this->loadView('user-update');
                        if(isset($params['id'])){
                            $this->template->set('user_to_update', $user->get($params['id']));
                        }
                        if(isset($_POST['update_user'])){
                            $update = $user->updateData($_POST, 'admin');
                            if(isset($update['in_error']) && $update['in_error']){
                                $this->template->set('errors', $update['errors']);
                            }
                            elseif(isset($update['success'])){
                                $this->template->set('success', $update['success']);
                            }
                        }
                        break;

                    case 'delete':
                        try {
                            if(!isset($params['id'])){
                                throw new Exception('Unable to find user id in GET parameters');
                            }
                            else {
                                $this->template = $this->loadView('user-delete');
                                $this->template->set('title', 'Supprimer un membre');
                                $this->template->set('user', $user->get($params['id']));
                                if(isset($_POST['confirm'])){
                                    $delete = $user->remove();
                                    if(isset($delete['in_error']) && $delete['in_error']){
                                        $this->template->set('errors', $delete['errors']);
                                    }
                                    elseif(isset($delete['success'])){
                                        $this->template->set('success', $delete['success']);
                                    }
                                }
                                elseif(isset($_POST['cancel'])){
                                    $this->redirect('admin/users/list');
                                }
                            }
                        }
                        catch(Exception $e){
                            exit($e->getMessage());
                        }
                        break;

                    default:
                        $this->template = $this->loadView('users');
                        $this->template->set('title', 'Membres');
                        break;
                }
                break;

            default:
                $this->template = $this->loadView('admin');
                $this->template->set('title', 'Administration');
                break;
        }

        $this->template->set('static', $this->staticFiles);
        $this->template->render();
    }

}