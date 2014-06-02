<?php
class Profile extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_id = $this->session->get('user');
        if(!$user_id){
            $this->redirect('login');
        }

        $template = $this->loadView('front/user/profile');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Mon profil');
        $user = $this->loadModel('user');
        $template->set('user', $user->get($user_id));

        if(isset($_POST['send_profile'])){
            $post = $_POST;
            $post['user_id'] = $user_id;
            $profile = $user->updateData($post);
            if(isset($profile['in_error']) && $profile['in_error']){
                $template->set('errors', $profile['errors']);
            }
            elseif(isset($profile['success'])){
                $this->session->set('user', $user_id);
                $template->set('user', $this->session->get('user'));
                $template->set('success', $profile['success']);
            }
        }

        $template->render();
    }

}