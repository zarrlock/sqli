<?php


class User
{
    public function __construct ($id, $name, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
    }

    public function __get ($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }

    public function __set ($prop, $value) {
        if(property_exists($this, $prop)) {
            $this->$prop = $value;
        }
    }
}