<?php
class Permissions extends Controller {

    private $template;
    function __construct(){
        parent::__construct('admin');
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login', 'admin/perms');
        }
        $user = $this->loadModel('user');
        $user_session = $user->get($user_id);
        if(!$user_session->is_admin){
            $this->redirect('');
        }

        $permission = $this->loadModel('permission');

        switch ($this->action){
            case 'list':
                $this->template = $this->loadView('admin/permissions/list');
                $this->template->set('title', 'Liste des permissions');
                $this->template->set('permissions', $permission->getAll());
                break;

            case 'add':
                $this->template = $this->loadView('admin/permissions/add');
                $this->template->set('title', 'Ajouter une permission');

                if(isset($_POST['add_perm'])){
                    $create = $permission->create($_POST);
                    if(isset($create['in_error']) && $create['in_error']){
                        $this->template->set('errors', $create['errors']);
                    }
                    elseif(isset($create['success'])){
                        $this->template->set('success', $create['success']);
                    }
                }

                break;

            case 'update':
                $this->template = $this->loadView('admin/permissions/update');
                $this->template->set('static', $this->staticFiles);
                $this->template->set('title', 'Éditer une permission');
                if(isset($this->params)){
                    $this->template->set('permission_to_update', $permission->get($this->params));
                }
                if(isset($_POST['update_perm'])){
                    $update = $permission->updateData($_POST);
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
                    if(!isset($this->params)){
                        throw new Exception('Unable to find permission id in GET parameters');
                    }
                    else {
                        $this->template = $this->loadView('admin/permissions/delete');
                        $this->template->set('title', 'Supprimer une permission');
                        $this->template->set('permission', $permission->get($this->params));
                        if(isset($_POST['confirm'])){
                            $delete = $permission->remove();
                            if(isset($delete['in_error']) && $delete['in_error']){
                                $this->template->set('errors', $delete['errors']);
                            }
                            elseif(isset($delete['success'])){
                                $this->template->set('success', $delete['success']);
                            }
                        }
                        elseif(isset($_POST['cancel'])){
                            $this->redirect('admin/permissions/list');
                        }
                    }
                }
                catch(Exception $e){
                    exit($e->getMessage());
                }
                break;

            default:
                $this->template = $this->loadView('admin/permissions/main');
                $this->template->set('title', 'Permissions');
                break;
        }

        $this->template->set('static', $this->staticFiles);
        $this->template->render();
    }

}