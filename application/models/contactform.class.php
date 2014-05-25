<?php
class ContactForm extends Model {

    public function __construct($config){
        $this->config = $config;
    }

    public function send($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $message = $post['firstname'] . ' ' . $post['lastname'] . "\r\n" . $post['email'] . "\r\n\r\n" . $post['message'];
        $message = wordwrap($message, 70, "\r\n");

        foreach($this->config['admins'] as $admin){
            mail($admin, $this->config['project'].' - Contact', $message);
        }
    }

    private function checkData($data){
        $errors = array();

        if($data['firstname'] == ''){
            $errors['firstname'] = 'Veuillez indiquer votre prénom';
        }
        if($data['lastname'] == ''){
            $errors['lastname'] = 'Veuillez indiquer votre nom';
        }
        if($data['email'] == ''){
            $errors['email'] = 'Veuillez fournir une adresse e-mail';
        }
        elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Format d\'adresse e-mail invalide';
        }
        if($data['message'] == ''){
            $errors['message'] = 'Veuillez écrire un message';
        }
        if($data['captcha'] == ''){
            $errors['captcha'] = 'Veuillez remplir le captcha';
        }
        elseif($data['captcha'] != $data['captcha_defaut']){
            $errors['captcha'] = 'Le captcha ne correspond pas';
        }

        return $errors;
    }

}