<?php
class Clans extends Controller {

    private $template;
    function __construct(){
        parent::__construct('admin');
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login', 'admin/clans');
        }
        $user = $this->loadModel('user');
        $user_session = $user->get($user_id);
        if(!$user_session->is_admin){
            $this->redirect();
        }

        $clan = $this->loadModel('clan');

        switch ($this->action){
            case 'list':
                $this->template = $this->loadView('admin/clans/list');
                $this->template->set('title', 'Liste des clans');
                $this->template->set('clans', $clan->getAll());
                $this->template->set('static', $this->staticFiles);
                $this->template->addJs('tablesorter/jquery.tablesorter.min', 'vendor');
                $this->template->addCss('tablesorter/style', 'vendor');
                $this->template->addJs('clans');
                break;

            case 'add':
                $this->template = $this->loadView('admin/clans/add');
                $this->template->set('static', $this->staticFiles);
                $this->template->addCss('select2-3.4.1/select2', 'vendor');
                $this->template->addJs('select2-3.4.1/select2.min', 'vendor');
                $this->template->addJs('clans');
                $this->template->set('title', 'Ajouter un clan');

                $this->template->set('users', $user->getAll());

                if(isset($_POST['add_clan'])){
                    $create = $clan->create($_POST);
                    if(isset($create['in_error']) && $create['in_error']){
                        $this->template->set('errors', $create['errors']);
                    }
                    elseif(isset($create['success'])){
                        $this->template->set('success', $create['success']);
                    }
                }

                break;

            case 'update':
                $this->template = $this->loadView('admin/clans/update');
                $this->template->set('static', $this->staticFiles);
                $this->template->addCss('select2-3.4.1/select2', 'vendor');
                $this->template->addJs('select2-3.4.1/select2.min', 'vendor');
                $this->template->addJs('clans');
                $this->template->set('title', 'Éditer un clan');

                if(isset($_GET['id'])){
                    $this->template->set('users', $user->getAll());
                    $this->template->set('clan_to_update', $clan->get($_GET['id']));
                }
                if(isset($_POST['update_clan'])){
                    $update = $clan->updateData($_POST);
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
                        throw new Exception('Unable to find clan id in GET parameters');
                    }
                    else {
                        $this->template = $this->loadView('admin/clans/delete');
                        $this->template->set('title', 'Supprimer un clan');
                        $this->template->set('clan', $clan->get($_GET['id']));
                        if(isset($_POST['confirm'])){
                            $delete = $clan->remove();
                            if(isset($delete['in_error']) && $delete['in_error']){
                                $this->template->set('errors', $delete['errors']);
                            }
                            elseif(isset($delete['success'])){
                                $this->template->set('success', $delete['success']);
                            }
                        }
                        elseif(isset($_POST['cancel'])){
                            $this->redirect('admin/clans/list');
                        }
                    }
                }
                catch(Exception $e){
                    exit($e->getMessage());
                }
                break;

            default:
                $this->template = $this->loadView('admin/clans/main');
                $this->template->set('title', 'Rangs');
                break;
        }

        $this->template->set('modes', $clan->available_modes);
        $this->template->set('static', $this->staticFiles);
        $this->template->render();
    }

}