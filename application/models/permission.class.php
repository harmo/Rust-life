<?php
class Permission extends Model {

    private $id;
    private $slug;
    private $description;

    private $permissions_for_clan = array(12, 13, 14, 16, 17, 18, 19, 20, 21, 23);

    public function get($id){
        return $this->loadPerm($this->selectOne('permission', '*', array('id' => (int)$id)));
    }

    public function getMultiple($ids){
        $selected_permissions = array();
        $permissions = $this->selectAll('permission', '*', null, 'WHERE id IN ('.implode(', ', $ids).')');
        foreach($permissions as $permission){
            $perm = $this->loadPerm($permission);
            $selected_permissions[$perm->id] = $perm;
        }
        return $selected_permissions;
    }

    public function getAll(){
        $permissions = array();
        foreach($this->selectAll('permission', '*') as $perm){
            $loaded_perm = $this->loadPerm($perm);
            $permissions[$loaded_perm->id] = $loaded_perm;
        }
        return $permissions;
    }

    public function getAllForClanOwner(){
        $permissions = array();
        foreach($this->selectAll('permission', '*', null, 'WHERE id IN ('.implode(', ', $this->permissions_for_clan).')') as $perm){
            $loaded_perm = $this->loadPerm($perm);
            $permissions[$loaded_perm->id] = $loaded_perm;
        }
        return $permissions;
    }

    private function loadPerm($perm){
        $loaded_perm = new stdClass();
        $loaded_perm->id          = $this->id          = $perm['id'];
        $loaded_perm->slug        = $this->slug        = $perm['slug'];
        $loaded_perm->description = $this->description = $perm['description'];

        return $loaded_perm;
    }

    public function create($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $data = array(
            'slug' => $post['name'],
            'description' => $post['desc']
        );
        $permission_id = $this->insertOne('permission', $data);
        if(!$permission_id){
            return array('in_error' => true, 'errors' => array('Enregistrement de la permission impossible'));
        }

        return array('in_error' => false, 'success' => array('permission_id' => $permission_id));
    }

    public function updateData($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $data = array(
            'slug' => $this->escapeString($post['name']),
            'description' => $this->escapeString($post['desc'])
        );
        if(!$this->update('permission', $data, array('id' => $post['perm_id']))){
            return array('in_error' => true, 'errors' => array('Enregistrement de la permission impossible'));
        }
        return array('in_error' => false, 'success' => true);
    }

    public function remove(){
        if(!$this->delete('permission', array('id' => $this->id))){
            return array('in_error' => true, 'errors' => array('Suppression de la permission impossible'));
        }
        return array('in_error' => false, 'success' => true);
    }

    private function checkData($data){
        $errors = array();

        if(!isset($data['name']) || $data['name'] == ''){
            $errors['name'] = 'Veuillez fournir le nom';
        }

        if(!isset($data['desc']) || $data['desc'] == ''){
            $errors['desc'] = 'Veuillez remplir la description';
        }

        return $errors;
    }
}