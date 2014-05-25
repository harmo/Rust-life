<?php
class Profile extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $template = $this->loadView('profile');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Mon profil');
        $current_user = $this->session->get('user');
        $template->set('user', $current_user);

        if(isset($_POST['send_profile'])){
            $user = $this->loadModel('user');
            $post = $_POST;
            $post['user_id'] = $current_user->id;
            $profile = $user->updateData($post);
            if(isset($profile['in_error']) && $profile['in_error']){
                $template->set('errors', $profile['errors']);
            }
            elseif(isset($profile['success'])){
                $this->session->set('user', $user->get($current_user->id));
                $template->set('user', $this->session->get('user'));
                $template->set('success', $profile['success']);
            }
        }

        $template->render();
    }

}