<?php
class Users extends Controller {

    private $template;
    function __construct(){
        parent::__construct('admin');
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login', 'admin/users');
        }
        $user = $this->loadModel('user');
        $user_session = $user->get($user_id);
        if(!$user_session->is_admin){
            $this->redirect('');
        }

        $clan = $this->loadModel('clan');

        switch ($this->action){
            case 'list':
                $this->template = $this->loadView('admin/users/list');
                $this->template->set('title', 'Liste des membres');
                $this->template->set('users', $user->getAll());
                $this->template->set('clans', $clan->getAll());
                break;

            case 'add':
                $this->template = $this->loadView('admin/users/add');
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
                $this->template = $this->loadView('admin/users/update');
                $this->template->set('clans', $clan->getAll());
                if(isset($_GET['id'])){
                    $this->template->set('user_to_update', $user->get($_GET['id']));
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
                    if(!isset($_GET['id'])){
                        throw new Exception('Unable to find user id in GET parameters');
                    }
                    else {
                        $this->template = $this->loadView('admin/users/delete');
                        $this->template->set('title', 'Supprimer un membre');
                        $this->template->set('user', $user->get($_GET['id']));
                        if(isset($_POST['confirm'])){
                            $delete = $user->remove($clan);
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
                $this->template = $this->loadView('admin/users/main');
                $this->template->set('title', 'Membres');
                break;
        }

        $this->template->set('static', $this->staticFiles);
        $this->template->render();
    }

}