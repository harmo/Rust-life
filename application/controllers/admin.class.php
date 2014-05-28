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
        else if(!$user_session->is_admin){
            $this->redirect('');
        }

        $func = key($action);
        $action = array_shift($action);

        switch ($func){
            case 'users':
                $user = $this->loadModel('user');
                switch ($action){
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

            case 'grades':
                $grade = $this->loadModel('grade');
                $permission = $this->loadModel('permission');
                switch ($action){
                    case 'list':
                        $this->template = $this->loadView('grades-list');
                        $this->template->set('title', 'Liste des rangs');
                        $this->template->set('grades', $grade->getAll());
                        $this->template->set('permissions', $permission->getAll());
                        break;

                    case 'add':
                        $this->template = $this->loadView('grade-add');
                        $this->template->set('static', $this->staticFiles);
                        $this->template->set('permissions', $permission->getAll());
                        $this->template->addCss('select2-3.4.1/select2', 'vendor');
                        $this->template->addJs('select2-3.4.1/select2.min', 'vendor');
                        $this->template->addJs('grades');
                        $this->template->set('title', 'Ajouter un rang');

                        if(isset($_POST['add_grade'])){
                            $create = $grade->create($_POST);
                            if(isset($create['in_error']) && $create['in_error']){
                                $this->template->set('errors', $create['errors']);
                            }
                            elseif(isset($create['success'])){
                                $this->template->set('success', $create['success']);
                            }
                        }

                        break;

                    case 'update':
                        $this->template = $this->loadView('grade-update');
                        $this->template->set('static', $this->staticFiles);
                        $this->template->set('title', 'Éditer un rang');
                        $this->template->set('permissions', $permission->getAll());
                        $this->template->addCss('select2-3.4.1/select2', 'vendor');
                        $this->template->addJs('select2-3.4.1/select2.min', 'vendor');
                        $this->template->addJs('grades');
                        if(isset($params['id'])){
                            $this->template->set('grade_to_update', $grade->get($params['id']));
                        }
                        if(isset($_POST['update_grade'])){
                            $update = $grade->updateData($_POST);
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
                                throw new Exception('Unable to find grade id in GET parameters');
                            }
                            else {
                                $this->template = $this->loadView('grade-delete');
                                $this->template->set('title', 'Supprimer un rang');
                                $this->template->set('grade', $grade->get($params['id']));
                                if(isset($_POST['confirm'])){
                                    $delete = $grade->remove();
                                    if(isset($delete['in_error']) && $delete['in_error']){
                                        $this->template->set('errors', $delete['errors']);
                                    }
                                    elseif(isset($delete['success'])){
                                        $this->template->set('success', $delete['success']);
                                    }
                                }
                                elseif(isset($_POST['cancel'])){
                                    $this->redirect('admin/grades/list');
                                }
                            }
                        }
                        catch(Exception $e){
                            exit($e->getMessage());
                        }
                        break;

                    default:
                        $this->template = $this->loadView('grades');
                        $this->template->set('title', 'Rangs');
                        break;
                }
                break;

            case 'permissions':
                $permission = $this->loadModel('permission');
                switch ($action){
                    case 'list':
                        $this->template = $this->loadView('permissions-list');
                        $this->template->set('title', 'Liste des permissions');
                        $this->template->set('permissions', $permission->getAll());
                        break;

                    case 'add':
                        $this->template = $this->loadView('permission-add');
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
                        $this->template = $this->loadView('permission-update');
                        $this->template->set('static', $this->staticFiles);
                        $this->template->set('title', 'Éditer une permission');
                        if(isset($params['id'])){
                            $this->template->set('permission_to_update', $permission->get($params['id']));
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
                            if(!isset($params['id'])){
                                throw new Exception('Unable to find permission id in GET parameters');
                            }
                            else {
                                $this->template = $this->loadView('permission-delete');
                                $this->template->set('title', 'Supprimer une permission');
                                $this->template->set('permission', $permission->get($params['id']));
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
                        $this->template = $this->loadView('permissions');
                        $this->template->set('title', 'Permissions');
                        break;
                }
                break;

            default:
                $this->template = $this->loadView('admin');
                $this->template->set('title', 'Administration');
                break;
        }

        if(!$this->template->get('static')){
            $this->template->set('static', $this->staticFiles);
        }
        $this->template->render();
    }

}