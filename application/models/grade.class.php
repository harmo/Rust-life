<?php
class Grade extends Model {

    private $id;
    private $name;
    private $description;
    private $permissions;

    public function get($id){
        return $this->loadGrade($this->selectOne('grade', '*', array('id' => (int)$id)));
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
        $loaded_grade->permissions = $this->permissions = $this->getPermissions();
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
            'permissions' => json_encode($post['perms'])
        );
        $grade_id = $this->insertOne('grade', $data);
        if(!$grade_id){
            return array('in_error' => true, 'errors' => array('Enregistrement de la permission impossible'));
        }

        return array('in_error' => false, 'success' => array('grade_id' => $grade_id));
    }

    public function updateData($post){
        $errors = $this->checkData($post);
        if(!empty($errors)){
            return array('in_error' => true, 'errors' => $errors);
        }

        $data = array(
            'name' => $this->escapeString($post['name']),
            'description' => $this->escapeString($post['description'])
        );
        if(!$this->update('grade', $data, array('id' => $post['grade_id']))){
            return array('in_error' => true, 'errors' => array('Enregistrement du rang impossible'));
        }

        $perms_to_add = array();
        $perms_to_remove = array();
        foreach($this->permissions as $id => $perm){
            if(!in_array($id, $post['perms'])){
                array_push($perms_to_remove, $id);
            }
            else {
                array_push($perms_to_add, array('id_grade' => (int)$this->id, 'id_permission' => (int)$id));
            }
        }
        foreach($post['perms'] as $permission_id){
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

        return array('in_error' => false, 'success' => true);
    }

    public function remove(){
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