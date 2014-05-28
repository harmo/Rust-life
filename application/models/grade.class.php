<?php
class Grade extends Model {

    private $id;
    private $name;
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
        $loaded_grade->permissions = $this->permissions = json_decode($grade['permissions']);

        return$loaded_grade;
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
            'permissions' => $this->escapeString(json_encode($post['perms']))
        );
        if(!$this->update('grade', $data, array('id' => $post['grade_id']))){
            return array('in_error' => true, 'errors' => array('Enregistrement du rang impossible'));
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

        if(!isset($data['perms']) || sizeof($data['perms']) == 0){
            $errors['perms'] = 'Veuillez selectionner au moins une permission';
        }

        return $errors;
    }
}