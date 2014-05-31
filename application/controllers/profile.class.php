<?php
class Profile extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $user_session = $this->session->get('user');
        if(!$user_session){
            $this->redirect('login');
        }

        $template = $this->loadView('front/user/profile');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Mon profil');
        $template->set('user', $user_session);

        if(isset($_POST['send_profile'])){
            $user = $this->loadModel('user');
            $post = $_POST;
            $post['user_id'] = $user_session->id;
            $profile = $user->updateData($post);
            if(isset($profile['in_error']) && $profile['in_error']){
                $template->set('errors', $profile['errors']);
            }
            elseif(isset($profile['success'])){
                $this->session->set('user', $user->get($user_session->id));
                $template->set('user', $this->session->get('user'));
                $template->set('success', $profile['success']);
            }
        }

        $template->render();
    }

}