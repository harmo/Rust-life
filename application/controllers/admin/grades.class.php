<?php
class Grades extends Controller {

    private $template;
    function __construct(){
        parent::__construct('admin');
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login', 'admin/grades');
        }
        $user = $this->loadModel('user');
        $user_session = $user->get($user_id);
        if(!$user_session->is_admin){
            $this->redirect('');
        }

        $grade = $this->loadModel('grade');
        $permission = $this->loadModel('permission');

        switch ($this->action){
            case 'list':
                $this->template = $this->loadView('admin/grades/list');
                $this->template->set('title', 'Liste des rangs');
                $this->template->set('grades', $grade->getAll());
                $this->template->set('permissions', $permission->getAll());
                break;

            case 'add':
                $this->template = $this->loadView('admin/grades/add');
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
                $this->template = $this->loadView('admin/grades/update');
                $this->template->set('static', $this->staticFiles);
                $this->template->set('title', 'Éditer un rang');
                $this->template->set('permissions', $permission->getAll());
                $this->template->addCss('select2-3.4.1/select2', 'vendor');
                $this->template->addJs('select2-3.4.1/select2.min', 'vendor');
                $this->template->addJs('grades');
                if(isset($_GET['id'])){
                    $this->template->set('grade_to_update', $grade->get($_GET['id']));
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
                    if(!isset($_GET['id'])){
                        throw new Exception('Unable to find grade id in GET parameters');
                    }
                    else {
                        $this->template = $this->loadView('admin/grades/delete');
                        $this->template->set('title', 'Supprimer un rang');
                        $this->template->set('grade', $grade->get($_GET['id']));
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
                $this->template = $this->loadView('admin/grades/main');
                $this->template->set('title', 'Rangs');
                break;
        }

        $this->template->set('static', $this->staticFiles);
        $this->template->render();
    }

}