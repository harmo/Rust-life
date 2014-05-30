<?php
class Contact extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $template = $this->loadView('front/contact');
        $template->set('static', $this->staticFiles);
        $template->set('title', 'Contact');
        $template->set('rand', rand(1000, 9999));

        if(isset($_POST['send_message'])){
            $contact = $this->loadModel('contactForm', $this->config);
            $send = $contact->send($_POST);
            if(isset($send['in_error']) && $send['in_error']){
                $template->set('errors', $send['errors']);
            }
            else {
                $template->set('success', true);
            }
        }

        $template->render();
    }

}