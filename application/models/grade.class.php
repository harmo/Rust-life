<?php
class Grade extends Model {

    private $id;
    private $name;
    private $description;
    private $type;
    private $permissions;
    private $is_editable;

    public $grade_types = array(
        1 => 'Rang de site',
        2 => 'Rang de clan'
    );

    public $not_editable = array(11, 12);

    public function get($id){
        return $this->loadGrade($this->selectOne('grade', '*', array('id' => (int)$id)));
    }

    public function getObject($id){
        $this->get($id);
        return $this;
    }

    public function getAll(){
        $grades = array();
        foreach($this->selectAll('grade', '*') as $grade){
            $loaded_grade = $this->loadGrade($grade);
            $grades[$loaded_grade->id] = $loaded_grade;
        }
        return $grades;
    }

    private function loadGrade($grade){
        $loaded_grade = new stdClass();
        $loaded_grade->id          = $this->id          = $grade['id'];
        $loaded_grade->name        = $this->name        = $grade['name'];
        $loaded_grade->description = $this->description = $grade['description'];
        $loaded_grade->type        = $this->type        = $grade['type'];
        $loaded_grade->permissions = $this->permissions = $this->getPermissions();
        $loaded_grade->is_editable = $this->is_editable = !in_array($this->id, $this->not_editable);
        return $loaded_grade;
    }

    private function getPermissions(){
        $results = $this->selectAll('grade_permission', 'id_permission', array('id_grade' => (int)$this->id));
        $permissions = array();
        foreach($results as $permission){
            $permissions[$permission['id_permission']] = $this->selectOne('permission', '*', array('id' => $permission['id_permission']));
        }
        return $permissions;
    }

    public function create($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $data = array(
            'name' => $post['name'],
            'description' => $post['description'],
            'type' => $post['type']
        );
        $this->id = $this->insertOne('grade', $data);
        if(!$this->id){
            return array('in_error' => true, 'errors' => array('Enregistrement de la permission impossible'));
        }

        $this->updatePermissions($post['perms']);

        return array('in_error' => false, 'success' => array('grade_id' => $this->id));
    }

    public function updateData($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $data = array(
            'name' => $this->escapeString($post['name']),
            'type' => (int)$post['type'],
            'description' => $this->escapeString($post['description'])
        );
        if(!$this->update('grade', $data, array('id' => $post['grade_id']))){
            return array('in_error' => true, 'errors' => array('Enregistrement du rang impossible'));
        }

        $this->updatePermissions($post['perms']);

        return array('in_error' => false, 'success' => true);
    }

    private function updatePermissions($posted_permissions){
        $perms_to_add = array();
        $perms_to_remove = array();
        if(is_array($this->permissions)){
            foreach($this->permissions as $id => $perm){
                if(!in_array($id, $posted_permissions)){
                    array_push($perms_to_remove, $id);
                }
                else {
                    array_push($perms_to_add, array('id_grade' => (int)$this->id, 'id_permission' => (int)$id));
                }
            }
        }
        foreach($posted_permissions as $permission_id){
            if(!isset($this->permissions[$permission_id])){
                array_push($perms_to_add, array('id_grade' => (int)$this->id, 'id_permission' => (int)$permission_id));
            }
        }
        if(!empty($perms_to_remove)){
            foreach($perms_to_remove as $perm){
                $this->delete('grade_permission', array('id_grade' => (int)$this->id, 'id_permission' => (int)$perm));
            }
        }
        if(!empty($perms_to_add)){
            $this->insertMultiple('grade_permission', $perms_to_add);
        }
    }

    public function remove(){
        if(is_array($this->permissions)){
            foreach($this->permissions as $id => $perm){
                $this->delete('grade_permission', array('id_grade' => (int)$this->id, 'id_permission' => (int)$id));
            }
        }

        $this->delete('clan_grade', array('id_grade' => (int)$this->id));

        $user_class = new User();
        foreach($this->selectAll('user', '*', null, 'WHERE site_grade='.(int)$this->id.' OR clan_grade='.(int)$this->id) as $user){
            $user['site_grade'] = $user['site_grade'] != null && $user['site_grade'] == (int)$this->id ? null : $user['site_grade'];
            $user['clan_grade'] = $user['clan_grade'] != null && $user['clan_grade'] == (int)$this->id ? null : $user['clan_grade'];
            $user_class->updateData($user);
        }

        if(!$this->delete('grade', array('id' => $this->id))){
            return array('in_error' => true, 'errors' => array('Suppression du rang impossible'));
        }
        return array('in_error' => false, 'success' => true);
    }

    private function checkData($data){
        $errors = array();

        if(!isset($data['name']) || $data['name'] == ''){
            $errors['name'] = 'Veuillez fournir le nom';
        }

        if(!isset($data['description']) || sizeof($data['description']) == 0){
            $errors['description'] = 'Veuillez remplir la description';
        }

        if(!isset($data['perms']) || sizeof($data['perms']) == 0){
            $errors['perms'] = 'Veuillez selectionner au moins une permission';
        }

        return $errors;
    }
}