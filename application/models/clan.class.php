<?php
class Clan extends Model {

    private $id;
    private $name;
    private $mode;
    private $monney;
    private $members;
    private $owner;

    public $available_modes = array(
        1 => 'Privé',
        2 => 'Public',
        3 => 'Sur demande'
    );
    public static $PUBLIC = 2;

    public function get($id){
        return $this->loadClan($this->selectOne('clan', '*', array('id' => (int)$id)));
    }

    public function getAll(){
        $clans = array();
        foreach($this->selectAll('clan', '*') as $clan){
            $loaded_clan = $this->loadClan($clan);
            $clans[$loaded_clan->id] = $loaded_clan;
        }
        return $clans;
    }

    private function loadClan($clan){
        $loaded_clan = new stdClass();
        $loaded_clan->id        = $this->id     = $clan['id'];
        $loaded_clan->name      = $this->name   = $clan['name'];
        $loaded_clan->mode      = $this->mode   = $clan['mode'];
        $loaded_clan->monney    = $this->monney = $clan['monney'];

        $loaded_members = array();
        $members = $this->selectAll('utilisateurs', '*', array('clan' => $this->id));
        foreach($members as $member){
            $loaded_members[$member['id']] = $member['identifiant'];
            if($member['id'] == $clan['owner']){
                $loaded_clan->owner = $this->owner  = $member;
            }
        }
        $loaded_clan->members = $this->members = $loaded_members;

        return$loaded_clan;
    }

    public function create($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $data = array(
            'name' => $post['name'],
            'mode' => (int)$post['mode'],
            'monney' => $post['monney'],
            'owner' => (int)$post['owner'],
        );
        $clan_id = $this->insertOne('clan', $data);
        if(!$clan_id){
            return array('in_error' => true, 'errors' => array('Enregistrement du clan impossible'));
        }

        foreach($post['members'] as $member_id){
            $user = $this->selectOne('utilisateurs', '*', array('id' => (int)$member_id));
            $data = array('clan' => $clan_id);
            $this->update('utilisateurs', $data, array('id' => $user['id']));
        }

        return array('in_error' => false, 'success' => array('grade_id' => $clan_id));
    }

    public function updateData($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $data = array(
            'name' => $this->escapeString($post['name']),
            'mode' => (int)$post['mode'],
            'monney' => $post['monney'],
            'owner' => (int)$post['owner'],
        );
        if(!$this->update('clan', $data, array('id' => $post['clan_id']))){
            return array('in_error' => true, 'errors' => array('Mise à jour du clan impossible'));
        }

        foreach($post['members'] as $member_id){
            $user = $this->selectOne('utilisateurs', '*', array('id' => (int)$member_id));
            $data = array('clan' => $post['clan_id']);
            $this->update('utilisateurs', $data, array('id' => $user['id']));
        }
        if(sizeof($this->members) != sizeof($post['members'])){
            $this->unsetUsersNotIn($post['members']);
        }

        return array('in_error' => false, 'success' => true);
    }

    public function remove(){
        $this->unsetUsersIn($this->members);
        if(!$this->delete('clan', array('id' => $this->id))){
            return array('in_error' => true, 'errors' => array('Suppression du clan impossible'));
        }
        return array('in_error' => false, 'success' => true);
    }

    public function unsetUsersNotIn($data){
        foreach($this->members as $id => $login){
            if(!in_array($id, $data)){
                $this->update('utilisateurs', array('clan' => 'NULL'), array('id' => $id));
            }
        }
    }

    public function unsetUsersIn($data){
        foreach($data as $id => $user){
            $this->update('utilisateurs', array('clan' => 'NULL'), array('id' => $id));
        }
    }

    private function checkData($data){
        $errors = array();

        if(!isset($data['name']) || $data['name'] == ''){
            $errors['name'] = 'Veuillez fournir le nom';
        }

        if(!isset($data['monney']) || $data['monney'] == ''){
            $errors['monney'] = 'Veuillez indiquer le montant d\'argent';
        }

        if(!isset($data['owner']) || $data['owner'] == ''){
            $errors['owner'] = 'Veuillez indiquer le chef du clan';
        }

        if(!isset($data['members']) || sizeof($data['members']) == 0){
            $errors['members'] = 'Veuillez selectionner au moins un membre';
        }

        return $errors;
    }
}