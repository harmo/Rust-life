<?php
class ExampleTest extends Model {

    public function test()    {
        return $this->selectOne('utilisateurs', '*');
    }

}